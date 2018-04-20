<?php

namespace App\Console\Commands;

use App\Notification;
use Illuminate\Console\Command;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class SaeSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sae:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will send notifications every 15min';

    /**
     * Create a new command instance.
     *
     */

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $notifications = Notification::where('status', false)->with(['students'])->get();

        foreach ($notifications as $notification) {
            $client = new Client();
            $result = $client->post('https://onesignal.com/api/v1/notifications', [
                'form_params' => [
                    'app_id' => '4d6ac746-a6a2-45c8-baaf-ef15c5d850a9',
                    'included_segments' => ['All Users'],
                    'include_player_ids' => $notification->students->user_id,
                    'content_available'=> 'template_id',
                    'title' => $notification->title,
                    'body' => $notification->body
                ]
            ]);

            $notification->status = true;
            $notification->save();
        }
    }
}


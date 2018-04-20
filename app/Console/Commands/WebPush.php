<?php

namespace App\Console\Commands;

use App\Notification;
use Illuminate\Console\Command;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class WebPush extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will fetch notifications every 15min';

    /**
     * Create a new command instance.
     *
     * @return void
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
                    'user' => $notification->students->user_id,
                    'title' => $notification->title,
                    'message' => $notification->body
                ]
            ]);

            $notification->status = true;
            $notification->save();
        }
    }

}

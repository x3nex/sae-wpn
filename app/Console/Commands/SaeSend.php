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
    protected $description = 'This command will send notifications every to user from the DB';

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

            $not = $notification->body;

            function sendMessage($data)
            {
                $content = array(
                    "en" => 'English Message'
                );
                $hashes_array = array();

                array_push($hashes_array, array(
                    "id" => "like-button-2",
                    "text" => $data,
                    "icon" => "img/brand.gif",
                    "url" => "https://learn.sae.edu.rs/login/canvas"
                ));
                $fields = array(
                    'app_id' => "4d6ac746-a6a2-45c8-baaf-ef15c5d850a9",
                    'included_segments' => array(
                        'All'
                    ),
                    'data' => array(
                        "foo" => "bar"
                    ),
                    'contents' => $content,
                    'web_buttons' => $hashes_array
                );

                $fields = json_encode($fields);
                print("\nJSON sent:\n");
                print($fields);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json; charset=utf-8',
                    'Authorization: Basic YjQ2M2VkMmYtNjQ5NS00YTMwLWE3YWMtYTkyNzUwNGYzMzIw'
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

                $response = curl_exec($ch);
                curl_close($ch);

                return $response;
            }

            $response = sendMessage($not);
            $return["allresponses"] = $response;
            $return = json_encode($return);

            print("\n\nJSON received:\n");
            print($return);
            print("\n");

        }

        $notification->status = true;
        $notification->save();
    }
}
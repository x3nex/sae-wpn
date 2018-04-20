<?php

namespace App\Console\Commands;
use App\Notification;
use App\Student;
use Illuminate\Console\Command;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class SaeFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sae:fetch';

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
        /* Instead of really fetching from canvas, I will mock the answer */


        // mocking api

        $result = [

            'title' => "New Message",
            'body' => "Please check you email"
    ];

        foreach ($result as $notification) {

            Notification::create([

                'title' => $notification->title,
                'body' => $notification->body
            ]);
        }

        }




}


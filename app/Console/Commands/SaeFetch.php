<?php

namespace App\Console\Commands;
use App\Notification;
use App\Student;
use Illuminate\Console\Command;


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
    protected $description = 'This command will fetch notifications from the mocking API and store them into DB';

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

        $result = array(
            array('title','New Message'),
            array('body','Please check your email')
        );

        Notification::create([
            'title' => $result[0][1],
            'body' => $result[1][1]

        ]);


        }




}


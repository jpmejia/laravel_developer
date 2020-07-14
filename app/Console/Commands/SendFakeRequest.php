<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendFakeRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'requestfake:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Simple POST request /fakepost';

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
     * @return int
     */
    public function handle()
    {   
	$request = \App\Request::where('send', false)->first();
        if($request) {
	    dispatch(function() use ($request){
	        event(new \App\Events\SendRequestFakeEvent($request));
	    });
	}
        return 0;
    }
}

<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class SendRequestFakeListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
	try {
	    $request = $event->request;
            $url = $request->url;
            $method = $request->method;
            $parameters = json_decode($request->parameters, true);
	    if(strtolower($method) == 'post') {
	        $response = Http::post($url, $parameters);
	    } else if(strtolower($method) == 'get') { 
	        $response = Http::get($url, $parameters);
	    } else {
	        throw new Exception('No Support Method');
	    }
	    $request->code = $response->status();
	    $request->body = json_encode($response->body());
	    if($response->serverError()) {
	        $request->send = false;
	    } else if($response->failed()) {
	        $request->send = false;
	    } else if($response->successful()) {
                $request->send = true;
	    }
	    $request->save();
	} catch(Exception $ex){
            $request->code = 0;
	    $request->body = $ex->getMessage();
	    $request->save();
	}

    }
}

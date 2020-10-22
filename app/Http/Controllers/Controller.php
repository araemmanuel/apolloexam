<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\Random;
use App\Models\Breakdown;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function index()
    {
        for ($i=0; $i < rand(5,10); $i++) { 
            $random = array('values' => $this->randomString(), );
            $randomId = Random::create($random)->id;
            $breakdown = array('random_id' => $randomId, );
            for ($j=0; $j < rand(5,10); $j++) { 
                $breakdown['values'] = $this->randomString();
                Breakdown::create($breakdown);
            }
        }

        return view('welcome');
    }

    public function show()
    {
        $randoms = Random::where('flag',false)->get();
        Random::where('flag',false)->update(['flag' => true]);
        $bdCollection = collect();
        foreach ($randoms as $rand) {
            foreach ($rand->breakdowns()->get() as $breakdown) {
                $bdCollection->push($breakdown);
            }
        }
        $breakdowns = $bdCollection->implode('values',' ');
        // $breakdowns = "asdfasdfasdfsadfasdfasdfas sdaf asdf asdf asdf as fasdf sad ";
        return $breakdowns;
    }

    public function randomString()
    {
        $characters = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $string = "";
        for ($i=0; $i < 5; $i++) { 
            $string .= $characters[rand(0, strlen($characters)-1)];
        }
        return $string;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Breakdown;
use Illuminate\Support\Str;
use App\Models\Random;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(){
        Random::where('flag', '=', 0)->update(['flag' => 1]);
        for($i=0; $i<rand(5,10);$i++){
            $b=Random::create([
                'values'=>Str::random(10)
            ]);
            for ($v=0; $v<rand(5,10);$v++){
                $b->breakdowns()->create([
                    'values'=>Str::random(10)
                ]);
            }
        }
        $random=Random::with('breakdowns')->where('flag','=',0)->get();
        $strms='';
        foreach($random as $rnd){
            foreach($rnd->breakdowns as $breakdown){
                $strms.=$breakdown->values.' ';
            }

        }

        return response()->json(['values'=>$strms],200);

    }
}

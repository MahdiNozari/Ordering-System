<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $months = 12;
        $successtransactions = Transaction::GetData($months,1);
        $data = $this->chartData($successtransactions,$months);
        return view('home',compact('data'));
    }

    public function chartData($transactions,$month){
        $months = $transactions->map(function($item){
            return verta($item->created_at)->format('%B %Y');
        });

        $amounts = $transactions->map(function($item){
            return $item->amount;
        });

        
        foreach($months as $i=>$v){
            if(!isset($result[$v])){
                $result[$v] = 0;
            }
            $result[$v] += $amounts[$i];
        }

        if(count($result) != $month){
            for($i=0 ; $i < $month ; $i++){
                $monthname = verta()->submonths($i)->format('%B %Y');
                $allmonths[$monthname] = 0;
            }
        }
        
        $result = array_merge($allmonths,$result);

        $finalresult = [];
        foreach($result as $month=>$val){
            array_push($finalresult,['month'=>$month, 'value'=>$val]);
        }

        return $finalresult;
        
    }
}

<?php

namespace App\Models;

use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
     use SoftDeletes;
    protected $guarded=[];

     public function getStatusAttribute($status)
    {
        switch ($status) {
            case '0':
                $status = 'ناموفق';
                break;
            case '1':
                $status = 'موفق';
                break;
        }
        return $status;
    }

    public function scopeGetData($query,$month,$status){
        $months = Verta::startmonth()->submonths($month-1);
        return $query->where('created_at','>',$months->tocarbon())->where('status',$status)->get();
    }
}

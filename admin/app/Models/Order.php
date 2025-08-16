<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
   use SoftDeletes;
    protected $guarded=[];

    public function products(){
        return $this->belongsToMany(Product::class,'order_items');
    }
    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function getStatusAttribute($status)
    {
        switch ($status) {
            case '0':
                $status = 'در انتظار پرداخت';
                break;
            case '1':
                $status = 'در حال پردازش';
                break;
            case '2':
                $status = 'ارسال شده';
                break;
            case '3':
                $status = 'کنسل شده';
                break;
        }
        return $status;
    }

    public function getPaymentStatusAttribute($paymentStatus)
    {
        switch ($paymentStatus) {
            case '0':
                $paymentStatus = 'ناموفق';
                break;
            case '1':
                $paymentStatus = 'موفق';
                break;
        }
        return $paymentStatus;
    }

    public function orderitems(){
        return $this->hasMany(OrderItem::class);
    }
}

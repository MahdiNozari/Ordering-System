<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::latest()->with(['address','orderitems'])->paginate(5);
        return view('order.index',compact('orders'));
    }

    
}

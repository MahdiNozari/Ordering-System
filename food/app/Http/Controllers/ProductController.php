<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product){
        $randomProduct = Product::where('status',1)->where('quantity','>','0')->get()->random(4);
        return view('product.show',compact('product','randomProduct'));
    }

    public function menu (Request $request){
        $categories = Category::all();
        $products = Product::where('quantity','>',0)->where('status',1)->search($request->search)->filter()->paginate(9);
        return view('product.menu',compact('products','categories'));
    }
}

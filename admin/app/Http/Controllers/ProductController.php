<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products=Product::paginate(5);
        return view('product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('product.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'primary_image' => 'required|image',
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'description' => 'required',
            'price' => 'required|integer',
            'status' => 'required|integer',
            'quantity' => 'required|integer',
            'sale_price' => 'nullable|integer',
            'date_on_sale_from' => 'nullable|date_format:Y/m/d H:i:s',
            'date_on_sale_to' => 'nullable|date_format:Y/m/d H:i:s',
            'images.*' => 'nullable|image'
        ]);

        $main_image = Carbon::now()->microsecond . '-' . $request->primary_image->getclientoriginalname();
        $request->primary_image->storeas('/images/products',$main_image);
        
        if($request->has('images') && $request->images !== null){
            $imagenames = [];
            foreach($request->images as $image){
                $imagename = Carbon::now()->microsecond . '-' . $image->getclientoriginalname();
                $image->storeas('/images/products',$imagename);
                array_push($imagenames,$imagename);
            }
        }
        DB::begintransaction();
        
        $product = Product::create([
            'name' => $request->name,
            'slug' => makeslug($request->name),
            'category_id' => $request->category_id,
            'primary_image' => $main_image,
            'description' => $request->description,
            'status' => $request->status,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'sale_price' => $request-> sale_price !== null ? $request->sale_price:0,
            'date_on_sale_from' => $request->date_on_sale_from !== null ? shmasitomiladi($request->date_on_sale_from) : null,
            'date_on_sale_to' => $request->date_on_sale_to !== null ? shmasitomiladi($request->date_on_sale_to) : null,
        ]);

        if($request->has('images') && $request->images !== null){
            foreach($imagenames as $imagename){
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imagename
                ]);
            }
        }

        DB::commit();
        return redirect()->route('products.index')->with('success','محصول با موفقیت ایجاد شد');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('product.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('product.edit',compact('categories','product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'primary_image' => 'nullable|image',
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'description' => 'required',
            'price' => 'required|integer',
            'status' => 'required|integer',
            'quantity' => 'required|integer',
            'sale_price' => 'nullable|integer',
            'date_on_sale_from' => 'nullable|date_format:Y/m/d H:i:s',
            'date_on_sale_to' => 'nullable|date_format:Y/m/d H:i:s',
            'images.*' => 'nullable|image'
        ]);

        if($request->has('primary_image') && $request->primary_image !== null)
        {
            Storage::delete('images/products/'.$product->primary_image);
            $main_image = Carbon::now()->microsecond . '-' . $request->primary_image->getclientoriginalname();
            $request->primary_image->storeas('/images/products',$main_image);
        }
        
        
        if($request->has('images') && $request->images !== null){
            $imagenames = [];

            foreach($product->images as $image){
                Storage::delete('images/products/'.$image);
                $image->delete();
            }
            foreach($request->images as $image){
                $imagename = Carbon::now()->microsecond . '-' . $image->getclientoriginalname();
                $image->storeas('/images/products',$imagename);
                array_push($imagenames,$imagename);
            }
        }
        DB::begintransaction();
        
        $product->update([
            'name' => $request->name,
            'slug' => makeslug($request->name),
            'category_id' => $request->category_id,
            'primary_image' => $request->primary_image ==! null ? $main_image : $product->primary_image,
            'description' => $request->description,
            'status' => $request->status,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'sale_price' => $request-> sale_price !== null ? $request->sale_price:0,
            'date_on_sale_from' => $request->date_on_sale_from !== null ? shmasitomiladi($request->date_on_sale_from) : null,
            'date_on_sale_to' => $request->date_on_sale_to !== null ? shmasitomiladi($request->date_on_sale_to) : null,
        ]);

        if($request->has('images') && $request->images !== null){
            
            foreach($imagenames as $imagename){
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imagename
                ]);
            }
        }

        DB::commit();
        return redirect()->route('products.index')->with('success','محصول با موفقیت ایجاد شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success','محصول با موفقیت ویرایش شد');        
    }
}

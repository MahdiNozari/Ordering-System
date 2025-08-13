<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $appends =['is_sale'];

    public function getIsSaleAttribute(){
        return $this->sale_price !== null && $this->sale_price !==0 && $this->date_on_sale_from < Carbon::now() && $this->date_on_sale_to > Carbon::now() ;
    }

    public function images(){
        return $this->hasMany(ProductImage::class);
    }

    public function scopeSearch($query,$search){
        return $query->where('name', 'LIKE', '%' . trim($search) . '%')->orwhere('description', 'LIKE', '%' . trim($search) . '%');
    }

    public function scopeFilter($query){
        if(request()->has('category')){
            $query->where('category_id',request()->category);
        }

        if(request()->has('sortBy')){
            switch(request()->sortBy){
                case 'max':
                    $query->orderBy('price','desc');
                    break;
                case 'min':
                    $query->orderBy('price');
                    break;
                case 'bestseller':
                    $query;
                    break;
                case 'sale':
                    $query->where('sale_price','!=',null)->where('sale_price','!=',0)->where('date_on_sale_from','<',Carbon::now())->where('date_on_sale_to','>',Carbon::now());
                    break;
                case 'default':
                    $query;
                    break;
                
            }
        }

        return $query;
    }
}

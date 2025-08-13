<?php


function ImageUrl($image){
    return env('ADMIN_PANEL_URL') . env('PRODUCT_IMAGES_PATH') . $image;
}

function SalePercent($price,$sale_price){
    return round((($price-$sale_price)/$price)*100);
}
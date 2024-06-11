<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Variation;
use App\Models\ProductMedia;

class ProductsController extends Controller
{
    public function product()
    {
        $pagename = 'Product';
        $product = Product::select('products.*')
            ->where('status', '1')
            ->orderBy('products.id', 'desc')
            ->get();

        return view('frontend.product', compact('pagename', 'product'));
    }

    // product details
    public function productdetail($sku = null)
    {
        $pagename = 'Product Details';

        $product = Product::select('*')->where('sku', $sku)->first();
        $Pid = $product->id;

        $images = ProductMedia::select('product_media_name', 'id')->where('id', $Pid)->get();
        $variation = Variation::select('*')->where('id', $Pid)->get();

        return view('frontend.product_detail', compact('pagename', 'product', 'images', 'variation'));
    }
}

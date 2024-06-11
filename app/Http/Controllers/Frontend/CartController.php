<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Variation;
use Auth;
use DB;
use Session;
use Carbon\Carbon;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart_arr = [];

        if (Auth::user()) {
            $id = Auth::user()->id;
            $cart = Cart::where('id', $id)
                ->with(['product', 'variation'])
                ->get();
        } else {
            $cart = Cart::where('device_ip', $request->ip())
                ->with(['product', 'variation'])
                ->get();
        }

        foreach ($cart as $val) {
            $product = $val->product;
            $variation = $val->variation;

            if ($val->product_qty > $variation->quantity) {
                Cart::where('cart_id', $val->cart_id)->update(['product_qty' => $variation->quantity]);
            }

            $item_total = $variation->price * $val->product_qty;

            $cart_arr[] = [
                'image' => $product->img,
                'product_name' => $product->name,
                'price' => $variation->price,
                'product_qty' => $product->quantity,
                'total' => $item_total,
                'remove' => route('cart.remove', ['id' => $val->cart_id])
            ];
        }

        return view('frontend.cart', compact('cart_arr'));
    }

    public function create(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_qty' => 'required|integer|min:1',
        ]);

        // Retrieve the product from the database
        $product = Product::findOrFail($validatedData['product_id']);

        // Check if the product is available
        if (!$product->available) {
            return response()->json([
                'status' => false,
                'message' => 'This product is not available.'
            ]);
        }

        // Check if the requested quantity is available
        $variation = $product->variation;
        if ($validatedData['product_qty'] > $variation->quantity) {
            return response()->json([
                'status' => false,
                'message' => 'Requested quantity is not available.'
            ]);
        }

        // Add the product to the cart
        $cartItem = new Cart([
            'product_id' => $product->id,
            'product_qty' => $validatedData['product_qty'],
            // Add any other necessary fields to the cart item
        ]);

        // Save the cart item
        $cartItem->save();

        // Return a success response
        return response()->json([
            'status' => true,
            'message' => 'Product added to cart successfully.',
            // Optionally, you can return any additional data such as the updated cart
        ]);
    }
}

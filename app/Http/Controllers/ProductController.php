<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Variation;
use App\Models\ProductMedia;
use App\Http\Requests\ProductForm;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // 1) Show all users data in index page
    public function index()
    {
        $products = Product::all();
        return view('backend.product.index', ['products' => $products]);
    }


    // 2) Show the form to create a new user
    public function create()
    {
        return view('backend.product.create');
    }

    // Store a newly created user in the database
    public function store(ProductForm $request)
    {

        if ($request->ajax()) {
            return true;
        }

        // store product sku
        $sku = str_replace(' ', '-', strtolower($request->name));
        $checkSKU = Product::select("*")
            ->where('sku', $sku)
            ->count();

        if ($checkSKU > 0) {
            $checkSKU = $checkSKU + 1;
            $sku = $sku . "-" . $checkSKU;
        }

        // Create a new user instance and save it to the database
        $product = new Product();
        $product->name = $request->input('name');
        $product->sku = $sku;
        $product->quantity = $request->input('quantity');
        $product->description = $request->input('description');

        // Handle image upload
        if ($request->hasFile('img')) {
            $img = $request->file('img');
            $extension = $img->getClientOriginalExtension();                  // Get the original extension of the uploaded file
            $imgName = rand() . '.' . $extension;
            $img->move('uploads/products', $imgName);
        } else {
            $imgName = null; // Or set a default image name
        }
        $product->img = $imgName;              // Assign the image name

        // save switch status in database
        if ($request->status == 'on') {
            $status = 1;
        } else {
            $status = 0;
        }
        $product->status = $status;
        $product->save();


        //  *********** Product Datails variation  *********** 

        // Create a user product details instance and save it to the database :
        $umo = $request->umo;          // Retrieve data from the request
        $value = $request->value;
        $price = $request->price;

        // Loop through the data and save each entry to the database
        foreach ($umo as $index => $col) {
            $variation = new Variation();
            $variation->id = $product->id;
            $variation->umo = $col;
            $variation->value = $value[$index];
            $variation->price = $price[$index];
            $variation->save();
        }

        // *********  add multipal imes ********

        $productThumbnails = $request->file('files');
        if ($request->hasFile('files')) {
            foreach ($productThumbnails as $index => $productThumbnail) {
                $images = new ProductMedia();

                // Save the record in the database
                $images->id = $product->id;
                $images->product_media_name = time() . '_' . $index . '.' . $productThumbnail->extension();
                // $images->created_by = $user->id;
                $images->save();
                $productThumbnail->move('uploads/products', $images->product_media_name);
            }
        }

        return redirect()->route('index')->with('success', 'create Product successfully');
    }



    // 3) Show the form to edit a user :
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $variation = Variation::where('id', $product->id)->get();     // Fetch product records related to the product's ID
        $images = ProductMedia::where('id', $product->id)->get();

        return view('backend.product.edit', [
            'product' => $product,              // it is use to fatch data from database
            'variation' => $variation,
            'images' => $images,
        ]);
    }

    // Update the specified product in the database
    public function update(ProductForm $request, $id)
    {
        // dd($request);
        if ($request->ajax()) {
            return true;
        }

        // update product sku
        $sku = str_replace(' ', '-', strtolower($request->name));
        $checkSKU = Product::select("*")
            ->where('sku', $sku)
            ->where('id', '!=', $id)
            ->count();


        if ($checkSKU > 0) {
            $checkSKU = $checkSKU + 1;
            $sku = $sku . "-" . $checkSKU;
        }


        // Find the product by its ID
        $product = Product::findOrFail($id);

        // Update the user data from the request
        $product->name = $request->input('name');
        $product->sku = $sku;
        $product->quantity = $request->input('quantity');
        $product->description = $request->input('description');

        // Handle image upload
        if ($request->hasFile('img')) {
            // Delete the previous image if it exists
            File::delete(public_path('uploads/products/' . $product->img));

            // Upload the new image
            $img = $request->file('img');
            $extension = $img->getClientOriginalExtension();
            $imgName = rand() . '.' . $extension;
            $img->move('uploads/products', $imgName);

            // Assign the new image name to the product
            $product->img = $imgName;
        }

        // save switch status in database
        if ($request->status == 'on') {
            $status = 1;
        } else {
            $status = 0;
        }
        $product->status = $status;
        $product->save();


        // Update the user product details instance and save it to the database :
        $umo = $request->umo;          // Retrieve data from the request
        $value = $request->value;
        $price = $request->price;

        if ($umo != "") {
            variation::where('id', $id)->delete();
            // Loop through the data and save each entry to the database
            foreach ($umo as $index => $col) {
                $variation = new Variation();
                $variation->id = $product->id;
                $variation->umo = $col;
                $variation->value = $value[$index];
                $variation->price = $price[$index];
                $variation->save();
            }
        }


        // edit multipal imges 
        if ($request->hasFile('files')) {
            $productThumbnails = $request->file('files');
            foreach ($productThumbnails as $index => $productThumbnail) {
                $images = new ProductMedia();

                // Save the record in the database
                $images->id = $product->id;
                $images->product_media_name = time() . '_' . $index . '.' . $productThumbnail->extension();
                $images->save();
                $productThumbnail->move('uploads/products', $images->product_media_name);
            }
        }

        // Redirect to the index page with a success message
        return redirect()->route('index')->with('success', 'Product details updated successfully');
    }

    public function delete_image($id)
    {
        $images = ProductMedia::find($id);
        $file = public_path('uploads/products/' . $images->product_media_name);
        if (file_exists($file)) {
            File::delete($file);
        }
        // Delete the media record from the database
        $images->delete();
        // dd($images);
        if ($images) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    // 4) delete the specified user from the database : 
    public function delete($id)
    {

        DB::beginTransaction();

        try {
            // Retrieve the product by its ID
            $product = Product::findOrFail($id);

            // Retrieve all variations associated with the product
            $variation = Variation::where('id', $product->id)->get();

            // Retrieve all media files associated with the product
            $images = ProductMedia::where('id', $product->id)->get();

            // Delete each media file
            foreach ($images as $media) {
                $file = public_path('uploads/products/' . $media->product_media_name);
                if (file_exists($file)) {
                    File::delete($file);
                }
                // Delete the media record from the database
                $media->delete();
            }

            // Delete all variations associated with the product
            foreach ($variation as $variations) {
                $variations->delete();
            }

            // Delete the main product image if it exists
            if ($product->img) {
                $imagesPath = public_path('uploads/products/' . $product->img);
                if (file_exists($imagesPath)) {
                    File::delete($imagesPath);
                }
            }

            // Delete the product record from the database
            $product->delete();

            DB::commit();

            return redirect()->route('index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Failed to delete the product.');
        }
    }
}

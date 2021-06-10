<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all()->toArray();
        return array_reverse($products);      
    }

    public function store(Request $request)
    {
        $image = $request->file('picture');

        // $path = $image->getRealPath();
        $filename = $image->getClientOriginalName();
        $extension = $image->getClientOriginalExtension(); // Get the extension
        // $image_name = $request->filename;

        $path = $image->store('public/images/subcategory');
        $filepath = str_replace("public/","storage/",$path);
        // $image->storeAs('public/images/subcategory', $image_name);
        
        $product = new Product([
            'name' => $request->input('name'),
            'detail' => $request->input('detail'),
            'file_name' => $filename,
            'file_path' => $filepath,
        ]);
        $product->save();

        return response()->json('Product created!');
    }

    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function update($id, Request $request)
    {
        return $request;
        $product = Product::find($id);
        $product->update($request->all());

        return response()->json('Product updated!');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json('Product deleted!');
    }

}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (isset($request->search) && !empty($request->search)) {
            $products = Product::where('name', 'like', '%'.$request->search.'%')->orWhere('description', 'like', '%'.$request->search.'%')->paginate(10);
        } else {
            $products = Product::paginate(10);
        }

        return response()->json([
            'status' => true,
            'products' => $products
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Product added successfully.',
            'product' => $product
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $product->increment('quantity', $data['quantity']);

        $product->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'quantity' => $product->quantity
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Product updated succesfully',
            'product' => $product
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product deleted.'
        ], 200);
    }
}

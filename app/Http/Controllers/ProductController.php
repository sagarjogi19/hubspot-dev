<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->get();

        return view('product.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:products',
            'price' => 'required|numeric'
        ]);
        
        $product = Product::create($request->all());

        Alert::success('Success', 'Product has been saved !');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('product.edit', [
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:products,name,' . $id . ',id',
            'price' => 'required|numeric',
            'description' => 'string'
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        Alert::info('Success', 'Product has been updated !');
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $deletedProduct = Product::findOrFail($id);

            $deletedProduct->delete();

            Alert::error('Success', 'Product has been deleted !');
            return redirect('/products');
        } catch (Exception $ex) {
            Alert::warning('Error', 'Cant deleted, Product already used !');
            return redirect('/products');
        }
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Services\HubSpotService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    protected $hubSpotService;

    public function __construct(HubSpotService $hubSpotService)
    {
        $this->hubSpotService = $hubSpotService;
    }

    public function index()
    {
        $products = $this->hubSpotService->getProducts();
        return response()->json($products);
    }

    public function show($productId)
    {
        $product = $this->hubSpotService->getProductById($productId);
        return response()->json($product);
    }

    public function store(Request $request)
    {
        $productData = $request->validate([
            'name' => 'required|string',
            'description' => 'string',
            'price' => 'numeric',
            // Add other validation rules as needed
        ]);

        $newProduct = $this->hubSpotService->createProduct($productData);
        return response()->json($newProduct, 201);
    }

    public function update(Request $request, $productId)
    {
        $productData = $request->validate([
            'name' => 'string',
            'description' => 'string',
            'price' => 'numeric',
            // Add other validation rules as needed
        ]);

        $updatedProduct = $this->hubSpotService->updateProduct($productId, $productData);
        return response()->json($updatedProduct);
    }

    public function destroy($productId)
    {
        $this->hubSpotService->deleteProduct($productId);
        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function create(Request $request)
        {
            $data = $request->validate([
                'name' => 'required',
                'description' => 'required',
                'price' => 'required|numeric',
                'image' => 'nullable|image|mimes:jpeg,png,jpg',
            ]);
    
            // upload the image.
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/products', $name);
    
                // replace the image by its path
                $data['image'] = $name;
            }
    
            $product = $this->productService->createProduct($data);
    
            // Attach the product to the selected categories.
            if ($request->has('category_ids')) {
                $this->productService->attachCategoriesToProduct($product, $request->get('category_ids'));
            }
    
            return response()->json([
                'data' => $product,
            ], Response::HTTP_CREATED);
        }

    public function index(Request $request)
    {
        $products = $this->productService->browseProducts($request);

        return response()->json([
            'data' => $products,
        ], Response::HTTP_OK);
    }
}

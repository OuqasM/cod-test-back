<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct(array $data)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }
        
        $product = new Product();
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->image = $data['image'] ?? null;
        $product->save();
    
        return $product;
    }

    public function browseProducts(Request $request)
    {
        $products = $this->productRepository->all();

        // sort the products by name/price
        if ($request->has('sort')) {
            $products = $products->sortBy($request->get('sort'));
        }

        // filter the products
        if ($request->has('category')) {
            $products = $products->where('category_id', $request->get('category'));
        }

        // Paginatiopn
        return $products->paginate(10);
    }

    public function attachCategoriesToProduct(Product $product, array $categoryIds)
    {
        $categories = $this->productRepository->findCategories($categoryIds);
        $product->categories()->sync($categories);
    }
}

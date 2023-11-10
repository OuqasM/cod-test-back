<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;

class ProductRepository
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function all()
    {
        return Product::query();
    }

    public function find($id)
    {
        return $this->product->find($id);
    }

    public function create(array $data)
    {
        return $this->product->create($data);
    }

    public function update($id, array $data)
    {
        return $this->product->find($id)->update($data);
    }

    public function delete($id)
    {
        return $this->product->find($id)->delete();
    }

    public function findByName($name)
    {
        return Product::where('name', $name)->first();
    }
    
    public function findCategories(array $categoryIds)
    {
        return Category::whereIn('id', $categoryIds)->get();
    }
}

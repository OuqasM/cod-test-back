<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function all()
    {
        return $this->category->all();
    }

    public function find($id)
    {
        return $this->category->find($id);
    }

    public function create(array $data)
    {
        return $this->category->create($data);
    }

    public function update($id, array $data)
    {
        return $this->category->find($id)->update($data);
    }

    public function delete($id)
    {
        return $this->category->find($id)->delete();
    }
    
    public function findByName($name)
    {
        return Category::where('name', $name)->first();
    }
}

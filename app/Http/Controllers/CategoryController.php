<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->browseCategories();

        return response()->json([
            'data' => $categories,
        ], Response::HTTP_OK);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCreationTest extends TestCase
{
    use RefreshDatabase;
    protected $productService;

    public function setUp(): void
    {
        parent::setUp();
        $this->productService = app(ProductService::class);
    }

    public function test_can_create_product()
    {

        $productData = [
            'name' => 'Product Name',
            'description' => 'Product description',
            'price' => 10.99,
        ];

        $product = $this->productService->createProduct($productData);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Product Name',
            'description' => 'Product description',
            'price' => 10.99,
        ]);
    }

    public function test_cannot_create_product_with_empty_name()
    {

        $productData = [
            'name' => '',
            'description' => 'Product description',
            'price' => 10.99,
        ];

        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $this->productService->createProduct($productData);
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\ProductRepository;

class DeleteProduct extends Command
{
    protected $signature = 'product:delete';

    protected $description = 'Delete a product';

    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        parent::__construct();

        $this->productRepository = $productRepository;
    }

    public function handle()
    {
        $products = $this->productRepository->all();

        if (!($products->count() > 0)) {
            $this->info('No products to delete.');

            return 0;
        }

        // Ask the user to choose a product to delete
        $productName = $this->choice('Select a product to delete:', $products->pluck('name')->toArray());

        // Find the product by name
        $product = $this->productRepository->findByName($productName);

        if (!$product) {
            $this->error('Product not found');

            return 1;
        }

        if ($this->confirm("Are you sure you want to delete the product: $productName?")) {
            // Delete the product
            $this->productRepository->delete($product->id);

            $this->info('Product deleted successfully.');
        } else {
            $this->info('Product deletion canceled.');
        }

        return 0;
    }
}

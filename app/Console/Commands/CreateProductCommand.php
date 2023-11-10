<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class CreateProductCommand extends Command
{

    use \Illuminate\Console\Concerns\InteractsWithIO;

    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        parent::__construct();
    }

     /**
     * The name and signature of the command.
     *
     * @var string
     */
    protected $signature = 'product:create';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Create a new product.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('Product name: ');
        $description = $this->ask('Product description: ');
        $price = $this->ask('Product price: ');

        $categories = $this->categoryRepository->all()->pluck('name')->toArray();
        $category =null;
        if (count($categories) > 0) {
            // display a list of existing categories
            $category = $this->choice('Product category: ', $categories);
            $category = $this->categoryRepository->find($category);

        } else {
            $this->info('No categpories to select.');
        }
        

        // cceate the new product
        $product = new Product();
        $product->name = $name;
        $product->description = $description;
        $product->price = $price;
        $product->save();

        // attach the product to the category
        $product->categories()->attach($category);

        $this->line('Product created successfully.');

        return 0;
    }
}

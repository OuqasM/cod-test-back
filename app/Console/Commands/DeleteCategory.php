<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\CategoryRepository;

class DeleteCategory extends Command
{
    protected $signature = 'category:delete';

    protected $description = 'Delete a category';

    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        parent::__construct();

        $this->categoryRepository = $categoryRepository;
    }

    public function handle()
    {
        $categories = $this->categoryRepository->all();

        // if there is a category to delete
        if ($categories->isEmpty()) {
            $this->info('No categories to delete.');

            return 0;
        }

        // Ask for the category to delete
        $categoryName = $this->choice('Select a category to delete:', $categories->pluck('name')->toArray());

        $category = $this->categoryRepository->findByName($categoryName);

        if (!$category) {
            $this->error('Category npt found ');

            return 1;
        }

        if ($this->confirm("Are you sure you want to delete the category: $categoryName?")) {
            // delete that category 
            $this->categoryRepository->delete($category->id);

            $this->info('Category deleted successfully.');
        } else {
            $this->info('Category deletion canceled.');
        }

        return 0;
    }
}

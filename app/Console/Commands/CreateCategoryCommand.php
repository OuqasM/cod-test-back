<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class CreateCategoryCommand extends Command
{
    /**
     * The name and signature of the command.
     *
     * @var string
     */
    protected $signature = 'category:create {name}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Create a new category.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');

        // create the new category.
        $category = new Category();
        $category->name = $name;
        $category->save();

        // display a success message 
        $this->info('Category created successfully.');

        return 0;
    }
}

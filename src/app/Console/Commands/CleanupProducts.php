<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class CleanupProducts extends Command
{
    protected $signature = 'products:cleanup';
    protected $description = 'Delete products with quantity less than 10';

    public function handle()
    {
        $count = Product::where('quantity', '<', 10)->update(['del_flag' => true]);
        $this->info("Marked $count products as deleted.");
    }
}
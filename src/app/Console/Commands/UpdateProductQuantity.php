<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class UpdateProductQuantity extends Command
{
    protected $signature = 'products:update-quantity {id} {quantity}';
    protected $description = 'Update product quantity';

    public function handle()
    {
        $product = Product::find($this->argument('id'));
        
        if (!$product) {
            $this->error('Product not found!');
            return;
        }

        $product->quantity = $this->argument('quantity');
        $product->save();

        $this->info("Product quantity updated successfully!");
    }
}
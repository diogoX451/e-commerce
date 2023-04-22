<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up():void
    {
        Schema::create('stock_variations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('variations_products_id')->constrained('variations_products');
            $table->foreignUuid('variations_products_category_items_id')->constrained('variations_products_category_items');
            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('stock_variations');
    }
};

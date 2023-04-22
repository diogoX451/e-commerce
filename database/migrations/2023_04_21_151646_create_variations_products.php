<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('variations_products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('qtd_stock');
            $table->string('price');
            $table->foreignUuid('product_id')->constrained('product');
            $table->foreignUuid('variations_products_category_items_id')->constrained('variations_products_category_items');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('variations_products');
    }
};

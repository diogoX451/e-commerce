<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('variations_products', function (Blueprint $table) {
            $table->dropColumn('variations_products_category_items_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('variationCatOption', function (Blueprint $table) {
            $table->uuid('variations_products_category_items_id');
        });
    }
};

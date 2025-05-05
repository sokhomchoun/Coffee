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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('product_cost');
            $table->unsignedBigInteger('stock_alert');
            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('category_id')->references('id')
                ->on('item_categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('brand_id')->references('id')
                ->on('brands')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('branch_id')->references('id')
                ->on('branches')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('unit_id')->references('id')
                ->on('units')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};

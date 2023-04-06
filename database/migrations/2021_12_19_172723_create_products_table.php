<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use app\Models\Product;

class CreateProductsTable extends Migration
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
            $table->String('name');
            $table->double('price')->default('0');
            $table->integer('views')->default('0');
            $table->text('description')->nullable();
            $table->Date('exp_data');
            $table->Text('img_url')->nullable();
            $table->integer('quantity')->default('1');
            $table->foreignId('category_id')->constrained('categories')->cascadeondelete();
            $table->foreignId('user_id')->constrained('users')->cascadeondelete();
            $table->timestamps();
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
}

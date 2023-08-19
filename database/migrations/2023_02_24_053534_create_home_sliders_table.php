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
        Schema::create('home_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('link')->nullable();
            $table->string('button_text')->nullable();
            $table->string('image');
            $table->integer('product_id')->unsigned();
            $table->boolean('trending')->default(false);
            $table->boolean('slider', 1)->default(false);
            $table->boolean('featured', 1)->default(false);
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
        Schema::dropIfExists('home_sliders');
    }
};

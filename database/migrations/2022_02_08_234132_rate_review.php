<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RateReview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rating_review', function (Blueprint $table) {
            $table->id();
            $table->integer('Id_order');
            $table->integer('Id_detail_order');
            $table->integer('Id_member');
            $table->integer('Rate');
            $table->longText('Review')->nullable();
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
        Schema::dropIfExists('rating_review');
    }
}

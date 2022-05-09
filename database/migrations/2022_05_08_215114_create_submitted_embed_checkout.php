<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmittedEmbedCheckout extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submitted_embed_checkout', function (Blueprint $table) {
            $table->id();
            $table->string('User_token');
            $table->string('Name');
            $table->string('Phone');
            $table->string('Email');
            $table->integer('Id_product');
            $table->integer('Id_variation');
            $table->integer('Qty');
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
        Schema::dropIfExists('submitted_embed_checkout');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SubmittedEmailEbook extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submitted_email_ebook', function (Blueprint $table) {
            $table->id();
            $table->integer('ebook_id');
            $table->string('user_token');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->date('date_request');
            $table->tinyInteger('status');
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
        Schema::dropIfExists('submitted_email_ebook');
    }
}

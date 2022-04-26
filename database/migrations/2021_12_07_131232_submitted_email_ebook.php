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
            $table->integer('Ebook_id');
            $table->string('User_token');
            $table->string('Name');
            $table->string('Phone');
            $table->string('Email');
            $table->date('Date_request');
            $table->tinyInteger('Status');
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

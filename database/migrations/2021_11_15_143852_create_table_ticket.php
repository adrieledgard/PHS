<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTicket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_ticket', function (Blueprint $table) {
            $table->id();
            $table->integer('Cs_id');
            $table->string('Nomor_ticket');
            $table->string('Title');
            $table->string('Email');
            $table->string('Phone');
            $table->longText('Platform_komunikasi');
            $table->longText('Bukti_chat');
            $table->longText('Description');
            $table->date('Date_request');
            $table->date('Date_solve')->nullable();
            $table->string('Status');
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
        Schema::dropIfExists('table_ticket');
    }
}

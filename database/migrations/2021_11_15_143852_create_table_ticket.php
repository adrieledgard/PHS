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
            $table->integer('cs_id');
            $table->string('title');
            $table->longText('platform_komunikasi');
            $table->longText('bukti_chat');
            $table->longText('description');
            $table->date('date_request');
            $table->date('date_solve')->nullable();
            $table->string('status');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TablePencatatEbookDidownload extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebook_member_downloaded', function (Blueprint $table) {
            $table->id();
            $table->integer('Id_member');
            $table->integer('Id_ebook');
            $table->integer('Total_didownload');
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
        Schema::dropIfExists('ebook_member_downloaded');
    }
}

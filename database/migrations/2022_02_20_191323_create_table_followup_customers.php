<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFollowupCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followup_customers', function (Blueprint $table) {
            $table->increments('Id_followup');
            $table->integer('Id_customer_service');
            $table->integer('Id_member');
            $table->dateTime('Followup_date');
            $table->dateTime('End_followup_date');
            $table->integer('Count_followup');
            $table->tinyInteger('Is_successful_followup');
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
        Schema::dropIfExists('followup_customers');
    }
}

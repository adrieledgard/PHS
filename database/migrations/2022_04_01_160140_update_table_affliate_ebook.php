<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableAffliateEbook extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('affiliate', function($table) {
            $table->integer('Total_diklik')->after('Poin')->nullable();
        });
        Schema::table('ebook', function($table) {
            $table->integer('Total_didownload')->after('Status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('affiliate', function($table) {
            $table->dropColumn('Total_diklik');
        });
        Schema::table('ebook', function($table) {
            $table->dropColumn('Total_didownload');
        });
    }
}

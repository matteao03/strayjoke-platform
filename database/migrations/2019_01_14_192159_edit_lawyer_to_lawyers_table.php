<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditLawyerToLawyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lawyers', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('mobile');
            $table->dropColumn('password');
            $table->dropColumn('remember_token');
            $table->text('org');
            $table->text('description');
            $table->string('tel');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lawyers', function (Blueprint $table) {
            $table->string('name');
            $table->string('mobile')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->dropColumn('org');
            $table->dropColumn('description');
            $table->dropColumn('tel');
        });
    }
}

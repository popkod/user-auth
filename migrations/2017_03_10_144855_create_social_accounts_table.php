<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true);
            $table->string('provider_user_id', 20);
            $table->string('provider', 20);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->index('provider_user_id');
        });

        Schema::table('users', function(Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social_accounts');

        Schema::table('users', function(Blueprint $table) {
            $table->string('email')->change();
            $table->string('password')->change();
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->default('');
            $table->smallInteger('sex')->nullable()->default(0); // 1 = male, 2 = female, 0 = not defined
            $table->boolean('is_looking')->nullable()->default(false);
            $table->dateTime('is_looking_date')->nullable();
            $table->float('rank', 3, 1)->nullable()->default(0);
            $table->integer('player_since')->nullable()->default(0);
            $table->text('about')->nullable();
            $table->smallInteger('access_level')->nullable()->default(0); // 1 - for admins
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'sex', 'is_looking', 'is_looking_date', 'rank', 'player_since', 'about']);
        });
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('avatar');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('status');
            $table->integer('points');
            $table->integer('gold');
            $table->boolean('admin');
            $table->rememberToken();
            $table->timestamps();
        });

        //添加一条前台管理员数据
        \Illuminate\Support\Facades\DB::table('users')->insert(
            [
                'name' => 'Admin',
                'avatar' => 'img/face.png',
                'email' => 'Admin@domain.com',
                'password' => bcrypt(123456),
                'gold' => 99999,
                'admin' => true,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}

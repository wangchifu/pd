<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('password');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('school_code')->nullable();
            $table->string('school_name')->nullable();
            $table->string('kind')->nullable();
            $table->string('title')->nullable();
            $table->text('edu_key')->nullable();
            $table->text('uid')->nullable();            
            $table->tinyInteger('admin')->nullable();//admin管理者
            $table->tinyInteger('review')->nullable();//review評審
            $table->string('login_type')->nullable();//local為本機登入,gsuite為gsuite登入
            $table->tinyInteger('disable')->nullable();//停用
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
        Schema::dropIfExists('users');
    }
};

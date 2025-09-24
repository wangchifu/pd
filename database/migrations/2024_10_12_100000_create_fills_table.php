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
        Schema::create('fills', function (Blueprint $table) {
            $table->id();
            $table->string('school_name');
            $table->string('school_code');
            $table->string('filename');                                    
            $table->unsignedInteger('upload_id');
            $table->unsignedInteger('report_id');
            $table->unsignedInteger('user_id');                      
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
        Schema::dropIfExists('fills');
    }
};

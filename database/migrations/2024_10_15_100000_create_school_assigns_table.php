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
        Schema::create('school_assigns', function (Blueprint $table) {
            $table->id();         
            $table->string('name');                          
            $table->unsignedInteger('report_id');
            $table->unsignedInteger('user_id')->nullable();//評審
            $table->text('schools_array')->nullable();                     
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
        Schema::dropIfExists('school_assigns');
    }
};

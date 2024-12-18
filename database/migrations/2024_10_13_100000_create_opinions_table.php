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
        Schema::create('opinions', function (Blueprint $table) {
            $table->id();
            $table->string('school_name');
            $table->string('school_code');
            $table->text('suggestion')->nullable();                                                
            $table->unsignedInteger('report_id');
            $table->unsignedInteger('user_id');
            $table->string('grade')->nullable();             
            $table->unsignedInteger('open')->nullable();         
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
        Schema::dropIfExists('opinions');
    }
};

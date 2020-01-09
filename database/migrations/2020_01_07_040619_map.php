<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Map extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('maps', function (Blueprint $table) { 
            $table->increments('id'); 
            $table->integer('user_id');
            $table->string('name');
            $table->decimal('lat', 11, 8); 
            $table->decimal('lng', 11, 8); 
            $table->text('description'); 
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
      Schema::drop('maps'); 
      
    }
}

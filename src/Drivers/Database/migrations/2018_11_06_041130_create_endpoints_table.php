<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEndpointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('endpoints', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('api_group_id');
            $table->string('endpoint');
            $table->string('method');
            $table->string('description')->nullable();
            $table->json('parameters')->nullable();
            $table->json('sample_response')->nullable();
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
        Schema::dropIfExists('api_groups');
        Schema::dropIfExists('endpoints');
    }
}

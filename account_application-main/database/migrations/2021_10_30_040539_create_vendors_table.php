<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
//            $table->unsignedBigInteger('slip_id')->nullable();
            $table->string('v_name');
            $table->integer('v_phone');
            $table->string('v_email');
            $table->string('v_type');
            $table->string('v_address')->nullable();
            $table->foreign('project_id')->references('id')->on('projects');
//            $table->foreign('slip_id')->references('id')->on('slips');
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
        Schema::dropIfExists('clients');
    }
}

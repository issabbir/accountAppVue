<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('head_id');
            $table->unsignedBigInteger('childhead_id');
            $table->string('slip_code');
            $table->string('company_name');
            $table->integer('slip_amount');
            $table->foreign('vendor_id')
                ->references('id')
                ->on('vendors')->onDelete('cascade');
            $table->foreign('head_id')
                ->references('id')
                ->on('heads')->onDelete('cascade');
            $table->foreign('childhead_id')
                ->references('id')
                ->on('heads')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('slips');
    }
}

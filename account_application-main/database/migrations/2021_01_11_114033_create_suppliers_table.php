<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('s_name');
            $table->string('s_company_name');
            $table->string('s_location');
            $table->string('s_email');
            $table->string('s_address')->nullable();
            $table->string('s_phone')->nullable();
            $table->string('s_type')->nullable();
            $table->string('s_slug')->nullable();
            $table->string('s_remarks')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
}

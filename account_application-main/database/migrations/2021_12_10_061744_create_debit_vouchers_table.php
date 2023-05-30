<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebitVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debit_vouchers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('slip_id');
//            $table->string('company_name');
            $table->integer('slip_amount');
            $table->integer('d_amount');
            $table->integer('due_amount');
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')->onDelete('cascade');
            $table->foreign('vendor_id')
                ->references('id')
                ->on('vendors')->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')->onDelete('cascade');
            $table->foreign('slip_id')
                ->references('id')
                ->on('slips')->onDelete('cascade');
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
        Schema::dropIfExists('debit_vouchers');
    }
}

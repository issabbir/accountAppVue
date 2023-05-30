<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_vouchers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('user_id');
//            $table->string('v_creditor');
            $table->integer('c_amount');
            $table->string('deposit_medium');
            $table->string('p_name')->nullable();
            $table->integer('p_phone')->nullable();
            $table->string('b_name')->nullable();
            $table->string('b_branch_name')->nullable();
            $table->string('b_acc_no')->nullable();
            $table->string('slug')->nullable();
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')->onDelete('cascade');
            $table->foreign('client_id')
                ->references('id')
                ->on('clients')->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('credit_vouchers');
    }
}

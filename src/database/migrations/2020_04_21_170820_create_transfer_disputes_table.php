<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferDisputesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_disputes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('transfer_id');
            $table->foreign('transfer_id')->references('id')->on('transfers');
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('dispute_reason');
            $table->boolean('resolved')->default(false);
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
        Schema::dropIfExists('transfer_disputes');
    }
}

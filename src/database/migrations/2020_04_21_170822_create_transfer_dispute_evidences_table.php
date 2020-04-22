<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferDisputeEvidencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_dispute_evidences', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('transfer_id');
            $table->foreign('transfer_id')->references('id')->on('transfers');
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->uuid('transfer_dispute_id');
            $table->foreign('transfer_dispute_id')->references('id')->on('transfer_disputes');
            $table->string('path');
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
        Schema::dropIfExists('transfer_dispute_evidences');
    }
}

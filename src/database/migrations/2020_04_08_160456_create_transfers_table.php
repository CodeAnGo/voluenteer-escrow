<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sending_party_id')->references('id')->on('users');
            $table->unsignedBigInteger('receiving_party_id')->nullable();
            $table->foreign('receiving_party_id')->references('id')->on('users');
            $table->unsignedBigInteger('charity_id')->nullable();
            $table->foreign('charity_id')->references('id')->on('charities');
            $table->string('delivery_first_name');
            $table->string('delivery_last_name');
            $table->string('delivery_email');
            $table->string('delivery_street');
            $table->string('delivery_city');
            $table->string('delivery_town');
            $table->string('delivery_postcode');
            $table->string('delivery_country');
            $table->decimal('transfer_amount', 6, 2);
            $table->string('transfer_reason');
            $table->string('transfer_note')->nullable();
            $table->tinyInteger('status');
            $table->string('stripe_id');
            $table->string('escrow_link');
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
        Schema::dropIfExists('transfers');
    }
}

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
            $table->uuid('id')->primary();
            $table->uuid('sending_party_id');
            $table->foreign('sending_party_id')->references('id')->on('users');
            $table->uuid('receiving_party_id')->nullable();
            $table->foreign('receiving_party_id')->references('id')->on('users');
            $table->uuid('charity_id')->nullable();
            $table->foreign('charity_id')->references('id')->on('charities');
            $table->string('delivery_first_name');
            $table->string('delivery_last_name');
            $table->string('delivery_email');
            $table->string('delivery_street');
            $table->string('delivery_city');
            $table->string('delivery_county')->nullable();
            $table->string('delivery_postcode');
            $table->string('delivery_country');
            $table->decimal('transfer_amount', 6, 2);
            $table->string('transfer_reason');
            $table->string('transfer_note')->nullable();
            $table->string('stripe_payment_intent')->nullable();
            $table->decimal('actual_amount', 6, 2)->nullable();
            $table->string('approval_note')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('stripe_id')->nullable();
            $table->string('freshdesk_id')->nullable();
            $table->string('transfer_group')->nullable();
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

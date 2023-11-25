<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        schema::create('payments', function(Blueprint $table){
            $table->id();
            $table->string('description');
            $table->enum('status', ['pending','failed','success'])->default('pending');
            $table->string('authority');
            $table->bigInteger('amount');
            $table->string('ref_id')->nullable();
            $table->string('card_hash')->nullable();
            $table->morphs('payable');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::drop('payments');
    }
};

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
        Schema::create('squad_members', function (Blueprint $table) {
            $table->unsignedBigInteger('squad_id')->index();
            $table->unsignedBigInteger('member_id')->index();
            $table->string('role')->default('member')->index();
            $table->timestamps();

            $table->unique(['squad_id', 'member_id']);
            $table->foreign('squad_id')->references('id')->on('squads')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('squad_members');
    }
};

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
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('organizer_id')->nullable();
            $table->integer('capacity')->nullable();
            $table->decimal('price', 8, 2)->default(0);
            $table->string('category')->nullable();
            $table->foreign('organizer_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['organizer_id']);
            $table->dropColumn(['organizer_id', 'capacity', 'price', 'category']);
        });
    }
};

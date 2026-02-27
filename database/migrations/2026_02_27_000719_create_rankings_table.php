<?php

use App\Models\User;
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
        Schema::create('rankings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->cascadeOnDelete();
            $table->integer('points')->default(0);
            $table->integer('position')->nullable();
            $table->integer('last_position')->default(1);
            $table->integer('best_full_points_streak')->nullable();
            $table->integer('current_full_points_streak')->default(1);
            $table->integer('best_non_points_streak')->nullable();
            $table->integer('current_non_points_streak')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rankings');
    }
};

<?php

use App\Enum\MatchGroupEnum;
use App\Enum\MatchStageEnum;
use App\Enum\MatchStatusEnum;
use App\Models\Team;
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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->integer('external_id')->unique();
            $table->foreignIdFor(Team::class, 'home_id')->cascadeOnDelete()->nullable();
            $table->foreignIdFor(Team::class, 'away_id')->cascadeOnDelete()->nullable();
            $table->string('matchday')->nullable();
            $table->enum('group_name', MatchGroupEnum::cases())->nullable();
            $table->enum('stage', MatchStageEnum::cases())->nullable();
            $table->enum('status', MatchStatusEnum::cases())->nullable();
            $table->timestamp('utc_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};

<?php

use App\Enum\MatchStatusEnum;
use App\Models\Bet;
use App\Models\Game;
use App\Models\Result;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

Artisan::command('play', function () {

    DB::transaction(function () {

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => Hash::make('Nao.Quero01'),
            'color' => "#14b8a6",
        ]);

        User::factory(3)->create();
        $users = User::all();

        $results = Result::factory(5)->create();

        $games = Game::where('status', MatchStatusEnum::FINISHED)->get();

        $bets = Bet::factory()
            ->count(100)
            ->make()
            ->each(function (Bet $bet) use ($games, $results, $users) {
                $user = $users->random(1)->values();
                $game = $games->random(1)->values();
                $result = $results->random(1)->values();

                $userId = $user[0]->id;
                $bet->user_id = $userId;
                $bet->game_id = $game[0]->id;
                $bet->result_id = $result[0]->id;

                $bet->save();
            });
    });
});

app(Schedule::class)->command('crazy:insert-teams')->twiceDaily(0, 12);

app(Schedule::class)->command('crazy:insert-matches')->dailyAt('00:00');

app(Schedule::class)->command('crazy:insert-matches-results')->everyFifteenMinutes();

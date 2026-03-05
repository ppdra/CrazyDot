<?php

namespace Database\Seeders;

use App\Models\Bet;
use App\Models\Game;
use App\Models\Result;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => Hash::make('Nao.Quero01'),
        ]);

        $users = User::factory(6)->create();

        $results = Result::factory(10)->create();

        $teams = Team::factory(16)->create();

        $games = Game::factory()
            ->count(100)
            ->make()
            ->each(function (Game $match) use ($teams) {
                $pair = $teams->random(2)->values();

                $match->home_id = $pair[0]->id;
                $match->away_id = $pair[1]->id;

                $match->save();
            });

        $bets = Bet::factory()
            ->count(200)
            ->make()
            ->each(function (Bet $bet) use ($games, $results, $users) {
                $user = $users->random(1)->values();
                $game = $games->random(1)->values();
                $result = $results->random(1)->values();

                $userId = $user[0]->id === 7 ? 1 : $user[0]->id;
                $bet->user_id = $userId ;
                $bet->game_id = $game[0]->id;
                $bet->result_id = $result[0]->id;

                $bet->save();
            });


    }
}

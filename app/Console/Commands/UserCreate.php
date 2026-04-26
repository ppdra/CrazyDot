<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\text;

class UserCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crazy:user-create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = text('User email:');
        $name = text('User name:');
        $password = text('User password:');
        $color  = fake()->unique()->hexColor();

        DB::transaction(function () use ($color, $email, $name, $password) {
            User::query()->create([
                'email' => $email,
                'color' => $color,
                'name' => $name,
                'password' => Hash::make($password),
            ]);
        });

        $this->info("✅ User '{$name}' created successfully with email {$email}.");
    }
}

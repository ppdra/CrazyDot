<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class UserChangePassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crazy:user-change-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change a user password';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = select(
            label: 'Which user would you like to change the password for?',
            options: User::pluck('name', 'id'),
            scroll: 10
        );
        $password = text('New user password:');

        DB::transaction(function () use ($userId, $password) {
            $user = User::query()->where('id', $userId)->firstOrFail();
            $user->update([
                'password' => Hash::make($password),
            ]);
        });

        $this->info("✅ Password for user with ID {$userId} changed successfully.");
    }
}

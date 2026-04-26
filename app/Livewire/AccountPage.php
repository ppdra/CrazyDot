<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AccountPage extends Component
{
    public User $user;

    public string $email;
    public string $color;
    public string $password;
    public string $passwordConfirmation;

    public function mount()
    {
        $this->user = Auth::user();
        $this->email = $this->user->email;
        $this->color = $this->user->color;
    }

    public function save()
    {
        $validated = $this->validate([
            'email' => ['required', 'email'],
            'color' => ['required', 'hex_color'],
            'password' => ['nullable', 'string', 'min:8', 'max:255', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\d\w]).{8,255}$/'],
            'passwordConfirmation' => ['nullable', 'string', 'min:8', 'max:255', 'same:password'],
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $this->user->email = $validated['email'];
                $this->user->color = $validated['color'];
                if ($validated['password']) {
                    $this->user->password = Hash::make($validated['password']);
                }
                $this->user->save();
            });

            $this->password = '';
            $this->passwordConfirmation = '';

            $this->dispatch(
                'notify',
                type: 'success',
                content: 'Account updated successfully',
                duration: 4000
            );
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify',
                type: 'error',
                content: 'An error occurred while updating the account',
                duration: 4000
            );
        }
    }

    public function render()
    {
        return view('livewire.account-page');
    }
}

<?php

namespace App\Livewire;

use App\Models\BetReaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EmojiPicker extends Component
{
    public int $selectedEmojiId = 0;
    public int $gameId;
    public int $betId;

    public array $userReactions;

    public function mount(int $gameId, int $betId)
    {
        $this->gameId = $gameId;
        $this->betId = $betId;

        $this->userReactions = $this->loadUserReactions();
    }

    public function loadUserReactions()
    {
        return BetReaction::where('bet_id', $this->betId)
            ->where('user_id', Auth::id())
            ->pluck('emoji_id')
            ->toArray();
    }

    public function toggleReaction(int $emojiId)
    {
        $this->selectedEmojiId = $emojiId;
        $userId = Auth::id();

        $reaction = BetReaction::where([
            'bet_id'   => $this->betId,
            'user_id'  => $userId,
            'emoji_id' => $emojiId,
        ])->first();

        if ($reaction) {
            $reaction->delete();
            $this->userReactions = $this->loadUserReactions();
            return;
        }

        BetReaction::create([
            'bet_id'   => $this->betId,
            'user_id'  => $userId,
            'emoji_id' => $emojiId,
        ]);

        $this->userReactions = $this->loadUserReactions();
    }

    public function render()
    {
        return view('livewire.emoji-picker');
    }
}

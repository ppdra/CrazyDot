@use('App\Enum\ReactionEmoji')

<div>
    <x-ui.popover>
        <x-ui.popover.trigger>
            <x-ui.button variant="ghost" size="sm">
                <span
                    class="inline-flex items-center gap-2 rounded-xl border border-(--color-border)/30
                   bg-(--color-surface) px-3 py-1 text-xs font-semibold text-(--color-primary)">
                    {{ $homeScore }} x {{ $awayScore }}
                </span>
            </x-ui.button>
        </x-ui.popover.trigger>

        <x-ui.popover.overlay position="top" :offset="8">
            <div class="p-3">

                <div class="grid grid-cols-6 gap-2">
                    @foreach (ReactionEmoji::picker() as $emoji)
                        @php
                            $active = in_array((int) $emoji['id'], $userReactions, true);
                        @endphp

                        <button wire:click="toggleReaction({{ $emoji['id'] }})"
                            class="flex items-center justify-center w-9 h-9 text-xl rounded-lg transition border hover:bg-(--color-surface)
                                {{ $active ? 'bg-(--color-accent)/40 border-(--color-border)/40' : 'border-transparent hover:border-(--color-border)/30' }}
                                    ">
                            {{ $emoji['emoji'] }}
                        </button>
                    @endforeach
                </div>

            </div>
        </x-ui.popover.overlay>
    </x-ui.popover>
</div>

@use('App\Enum\ReactionEmoji')

<div class="space-y-4">
    @forelse($bets as $b)
        <div class="flex items-start justify-between gap-4">
            {{-- Left: name + reactions --}}
            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-semibold text-(--color-primary)">
                    {{ $b->user->name }}
                </p>

                @php
                    $reactions = $b->reactionsSummary ?? [];
                @endphp

                @if (!empty($reactions))
                    <div class="mt-2 flex flex-wrap items-center gap-1.5">
                        @foreach ($reactions as $r)
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[11px] font-semibold leading-none
                                       border border-(--color-border)/30
                                       bg-(--color-surface)/60 text-(--color-primary)"
                            >
                                <span class="text-sm leading-none">
                                    {{ ReactionEmoji::emojiFromId($r['emoji_id']) }}
                                </span>

                                <span class="text-(--color-muted) leading-none">
                                    {{ $r['count'] }}
                                </span>
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Right: score badge + picker --}}
            <div class="flex items-center gap-2 shrink-0">
                <span
                    class="inline-flex items-center rounded-xl border px-3 py-1 text-xs font-semibold whitespace-nowrap"
                    style="border-color: color-mix(in oklab, var(--color-border) 45%, transparent);
                           background: color-mix(in oklab, var(--color-border) 14%, transparent);
                           color: var(--color-primary);"
                >
                    {{ $b->result->home_score }}–{{ $b->result->away_score }}
                </span>

                <livewire:emoji-picker :gameId="$gameId" :betId="$b->id" />
            </div>
        </div>
    @empty
        <p class="text-xs text-(--color-muted)">
            {{ __('live.no_recent_bets') }}
        </p>
    @endforelse
</div>
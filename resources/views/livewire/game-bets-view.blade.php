@use('App\Enum\ReactionEmoji')

<div class="border border-(--color-card-border) bg-(--color-background)">
    {{-- Header só no desktop --}}
    <div
        class="hidden sm:grid grid-cols-12 items-center px-5 py-3 bg-(--color-surface)
            text-[11px] font-semibold uppercase tracking-wide text-(--color-muted)">

        <div class="col-span-6">{{ __('bets.table.participant') }}</div>
        <div class="col-span-3 text-center">{{ __('bets.table.bet') }}</div>
        <div class="col-span-2 text-right">{{ __('bets.table.points') }}</div>
    </div>

    <div class="divide-y divide-(--color-border)/15">
        @foreach ($bets as $row)
            @php
                $pointsBadge = function (int $points) {
                    return match (true) {
                        $points >= 5 => 'bg-(--color-success)/12 text-(--color-success) border-(--color-success)/25',
                        $points >= 2 => 'bg-(--color-warning)/12 text-(--color-warning) border-(--color-warning)/25',
                        $points > 0 => 'bg-(--color-primary)/10 text-(--color-primary) border-(--color-primary)/20',
                        default => 'bg-(--color-surface) text-(--color-muted) border-(--color-border)/25',
                    };
                };
            @endphp
            <div class="px-4 sm:px-5 py-4 transition hover:bg-(--color-surface)/40">
                {{-- Linha 1: user | bet+points | action --}}
                <div class="grid grid-cols-12 items-center gap-2">

                    <!-- User -->
                    <div class="col-span-6 min-w-0">
                        <p class="truncate text-sm font-semibold text-(--color-primary) capitalize">
                            {{ $row['user']->name }}
                        </p>
                    </div>

                    <!-- Bet -->
                    <div class="col-span-3 flex justify-center">
                        <livewire:emoji-picker :betId="$row['id']" :gameId="$row['game_id']" :key="'emoji-picker-' . $row['id']" :homeScore="$row['result']->home_score" :awayScore="$row['result']->away_score" />
                        
                    </div>

                    <!-- Points -->
                    <div class="col-span-2 flex justify-end">
                        <span
                            class="inline-flex items-center justify-center min-w-[44px] rounded-xl border px-3 py-1
                     text-xs font-extrabold {{ $pointsBadge((int) $row['points']['points']) }}">
                            {{ (int) $row['points']['points'] }}
                        </span>
                    </div>


                </div>

                {{-- Linha 2 (SEMPRE a última): reactions, esquerda -> direita --}}
                <div class="mt-3 justify-between flex">
                    <div class="flex flex-wrap items-center gap-1.5">
                        @foreach ($row['reactionsSummary'] ?? [] as $r)
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[11px] font-semibold leading-none
                                       border border-(--color-border)/30 bg-(--color-surface)/60 text-(--color-primary)">
                                <span class="text-lg leading-none">{{ ReactionEmoji::emojiFromId($r['emoji_id']) }}</span>
                                <span class="text-(--color-muted) leading-none">{{ $r['count'] }}</span>
                            </span>
                        @endforeach
                            
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

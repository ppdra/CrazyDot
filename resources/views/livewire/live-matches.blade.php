<div wire:poll.300s>
    @if ($liveGames->isNotEmpty())
        <section class="rounded-2xl border border-(--color-card-border) bg-(--color-card) p-5 md:p-6">
            <!-- Header -->
            <div class="flex items-start justify-between gap-3">
                <div>
                    <div class="flex items-center gap-2">
                        <span
                            class="inline-grid h-8 w-8 place-items-center rounded-xl border border-(--color-card-border)">
                            🔴
                        </span>
                        <h2 class="text-base font-bold text-(--color-primary)">{{ __('live.title') }}</h2>
                    </div>
                    <p class="mt-1 text-sm text-(--color-muted)">{{ __('live.subtitle') }}</p>
                </div>
            </div>

            <div class="mt-5 grid gap-3 sm:grid-cols-1 md:grid-cols-2">
                @foreach ($liveGames as $game)
                    @php
                        $startLocal = $game->utc_date?->tz(session('tz'));
                        $startedAtLabel = $startLocal ? $startLocal->format('H:i') : '--:--';
                    @endphp

                    <div
                        class="rounded-2xl border border-(--color-card-border) bg-transparent p-4 transition
                            hover:-translate-y-0.5 hover:shadow-[0_20px_60px_-45px_rgba(0,0,0,0.85)]">

                        <!-- Top meta (live + start time) -->
                        <div class="flex items-center justify-between gap-3">
                            <span
                                class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-[11px] font-semibold"
                                style="border-color: color-mix(in oklab, var(--color-red-500) 35%, transparent);
                                     background: color-mix(in oklab, var(--color-red-500) 10%, transparent);
                                     color: color-mix(in oklab, var(--color-red-500) 85%, white 15%);">
                                <span class="inline-block h-2 w-2 rounded-full"
                                    style="background: var(--color-red-500)"></span>
                                {{ __('live.badge_live') }}
                            </span>

                            <div class="text-right text-xs text-(--color-muted)">
                                <div>
                                    <span
                                        class="font-semibold text-(--color-primary)">{{ \App\Support\Datetime::datetime($game->utc_date) }}</span>
                                </div>

                            </div>
                        </div>

                        <!-- Teams row -->
                        <div class="mt-4 grid grid-cols-12 items-center gap-3">
                            <!-- Home -->
                            <div class="col-span-5 flex min-w-0 items-center gap-3">
                                <img src="{{ $game->homeTeam->logo_url }}" alt="{{ $game->homeTeam->name }}"
                                    class="h-10 w-10 rounded-2xl object-cover" onerror="this.style.display='none';" />
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-(--color-primary)">
                                        {{ $game->homeTeam->slug }}
                                    </p>
                                </div>
                            </div>

                            <!-- VS -->
                            <div class="col-span-2 flex items-center justify-center">
                                <div
                                    class="rounded-2xl border border-(--color-card-border) px-3 py-2 text-xs font-bold text-(--color-muted)">
                                    VS
                                </div>
                            </div>

                            <!-- Away -->
                            <div class="col-span-5 flex min-w-0 items-center justify-end gap-3 text-right">
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-(--color-primary)">
                                        {{ $game->awayTeam->slug }}
                                    </p>
                                </div>
                                <img src="{{ $game->awayTeam->logo_url }}" alt="{{ $game->awayTeam->name }}"
                                    class="h-10 w-10 rounded-2xl object-cover" onerror="this.style.display='none';" />
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="mt-4 h-px w-full"
                            style="background: color-mix(in oklab, var(--color-border) 28%, transparent);"></div>


                        <!-- Recent -->
                        <div class="md:col-span-5 mt-5">
                            <p class="text-xs font-semibold text-(--color-muted) uppercase tracking-wide">
                                {{ __('live.bets') }}
                            </p>

                            <div class="mt-3 space-y-2">
                                @forelse($game->validatedPlacedBets as $b)
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="truncate text-sm font-semibold text-(--color-primary)">
                                            {{ $b->user->name }}
                                        </p>

                                        <span
                                            class="inline-flex items-center rounded-xl border px-3 py-1 text-xs font-semibold"
                                            style="border-color: color-mix(in oklab, var(--color-border) 45%, transparent);
                                                     background: color-mix(in oklab, var(--color-border) 14%, transparent);
                                                     color: var(--color-primary);">
                                            {{ $b->result->home_score }}–{{ $b->result->away_score }}
                                        </span>
                                    </div>
                                @empty
                                    <p class="text-xs text-(--color-muted)">
                                        {{ __('live.no_recent_bets') }}
                                    </p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 text-xs text-(--color-muted)">
                {{ __('live.last_update', ['time' => \App\Support\Datetime::datetime(now())]) }}
            </div>
        </section>
    @endif
</div>

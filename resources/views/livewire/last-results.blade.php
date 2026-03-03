@php
    $pointsStyle = function (int $pts) {
        return match (true) {
            $pts >= 5 => 'background: color-mix(in oklab, var(--color-success) 14%, transparent);
                         border-color: color-mix(in oklab, var(--color-success) 40%, transparent);
                         color: color-mix(in oklab, var(--color-success) 85%, white 15%);',
            $pts >= 2 => 'background: color-mix(in oklab, var(--color-warning) 14%, transparent);
                         border-color: color-mix(in oklab, var(--color-warning) 40%, transparent);
                         color: color-mix(in oklab, var(--color-warning) 85%, white 15%);',
            default => 'background: color-mix(in oklab, var(--color-border) 18%, transparent);
                        border-color: color-mix(in oklab, var(--color-border) 40%, transparent);
                        color: var(--color-muted);',
        };
    };

    $pointsLabel = fn(int $pts) => match (true) {
        $pts >= 2 => "+{$pts} pts",
        $pts === 1 => '+1 pt',
        default => '0 pt',
    };
@endphp

<section wire:poll.300s class="rounded-2xl border border-(--color-card-border) bg-(--color-card) p-5 md:p-6">
    <!-- Header -->
    <div class="flex items-start justify-between gap-3">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-grid h-8 w-8 place-items-center rounded-xl border border-(--color-card-border)">
                    🧾
                </span>
                <h2 class="text-base font-bold text-(--color-primary)">{{ __('last-results.title') }}</h2>
            </div>
            <p class="mt-1 text-sm text-(--color-muted)">{{ __('last-results.subtitle') }}</p>
        </div>

        <a href="#"
            class="inline-flex items-center justify-center rounded-xl border border-(--color-card-border)
                  bg-transparent px-4 py-2 text-sm font-semibold text-(--color-primary) transition hover:opacity-90">
            {{ __('last-results.see_history') }}
        </a>
    </div>

    <!-- List -->
    <div class="mt-5 space-y-3">
        @forelse ($lastResults as $r)
            <div
                class="rounded-2xl border border-(--color-card-border) bg-transparent p-4 transition
                        hover:-translate-y-0.5 hover:shadow-[0_20px_60px_-45px_rgba(0,0,0,0.85)]">
                <!-- top meta -->
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <div class="flex items-center gap-2 text-xs text-(--color-muted)">
                        <p class="truncate text-sm font-semibold text-(--color-primary)">
                            {{ $r->user->name }}
                        </p>
                    </div>

                    <span class="inline-flex items-center rounded-full border px-3 py-1 text-[11px] font-semibold"
                        style="{{ $pointsStyle((int) $r->points) }}">
                        {{ $pointsLabel((int) $r->points) }}
                    </span>
                </div>

                <!-- match row -->
                <div class="mt-3 flex flex-wrap items-center justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-(--color-primary)">
                            {{ $r->game->homeTeam->slug }} <span class="text-(--color-muted) font-bold">vs</span>
                            {{ $r->game->awayTeam->slug }}
                        </p>

                        <div class="mt-1 flex flex-wrap items-center gap-2 text-xs text-(--color-muted)">
                            <span class="rounded-lg border border-(--color-card-border) px-2 py-1">
                                {{ __('last-results.bet') }}: <span
                                    class="text-(--color-primary) font-semibold">{{ $r->bet->result->home_score }}–{{ $r->bet->result->away_score }}</span>
                            </span>

                            <span class="rounded-lg border border-(--color-card-border) px-2 py-1">
                                {{ __('last-results.final') }}: <span
                                    class="text-(--color-primary) font-semibold">{{ $r->gameResult->result->home_score }}–{{ $r->gameResult->result->away_score }}</span>
                            </span>
                        </div>
                    </div>


                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-(--color-card-border) bg-transparent p-8 text-center">
                <div class="flex flex-col items-center gap-3">
                    <div
                        class="inline-grid h-12 w-12 place-items-center rounded-2xl border border-(--color-card-border)">
                        🧾
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-(--color-primary)">
                            {{ __('last-results.empty.title') }}
                        </p>
                        <p class="mt-1 text-xs text-(--color-muted)">
                            {{ __('last-results.empty.subtitle') }}
                        </p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Footer -->
    <div class="mt-4 flex items-center justify-between gap-3">
        <p class="text-xs text-(--color-muted)">
            {{ __('last-results.footer') }}
        </p>

    </div>
    <div>
        <p class="text-xs text-(--color-muted)">
            {{ __('last-results.last_update', ['time' => \App\Support\Datetime::datetime(now())]) }}

        </p>
    </div>
</section>

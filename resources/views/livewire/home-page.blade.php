@php
    $accuracy = $this->totalPoints > 0 ? ($this->rankingFirstPlace->points ?? 0 / $this->totalPoints) * 100 : 0;
@endphp

<div>

    <section class="relative overflow-hidden rounded-3xl border border-(--color-card-border) bg-(--color-card)">
        <!-- Background glows + overlay -->
        <div class="absolute inset-0">
            <div class="absolute inset-0"
                style="background:
                radial-gradient(circle at 30% 20%, var(--color-hero-glow-1), transparent 55%),
                radial-gradient(circle at 80% 30%, var(--color-hero-glow-2), transparent 55%);
             ">
            </div>
            <div class="absolute inset-0 bg-(--color-overlay)"></div>
        </div>

        <div class="relative p-6 md:p-10">
            <div class="grid gap-6 md:grid-cols-12 md:items-center">

                <!-- Left: Welcome -->
                <div class="md:col-span-7">
                    <p class="text-sm text-(--color-muted)">
                        {{ __('home.hello') }} <span
                            class="text-(--color-primary) font-semibold capitalize">{{ Auth::user()->name }}</span> 👋
                    </p>

                    <h1 class="mt-2 text-3xl md:text-4xl font-extrabold tracking-tight text-(--color-primary)">
                        {{ __('home.welcome_title') }} <span class="opacity-90">{{ config('app.name') }}</span>!
                    </h1>

                    <p class="mt-2 max-w-xl text-(--color-muted)">
                        {{ __('home.welcome_subtitle') }}
                    </p>

                    <div class="mt-5 flex flex-wrap items-center gap-3">
                        <a href="{{ route('matches') }}"
                            class="inline-flex items-center justify-center rounded-xl px-5 py-3 text-sm font-semibold
                              bg-(--color-btn) text-(--color-btn-fg)
                              shadow-lg transition"
                            style="box-shadow: 0 18px 40px -25px var(--color-ring);"
                            onmouseover="this.style.backgroundColor='var(--color-btn-hover)'"
                            onmouseout="this.style.backgroundColor='var(--color-btn)'">
                        {{ __('home.cta_bet') }}
                        </a>

                        <a href="{{ route('ranking') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-(--color-card-border)
                              bg-transparent px-5 py-3 text-sm font-semibold text-(--color-primary)
                              transition hover:opacity-90">
                            {{ __('home.cta_ranking') }}
                        </a>
                    </div>
                </div>

                @if ($this->rankingFirstPlace)
                    <!-- Right: Leader card -->
                    <div class="md:col-span-5">
                        <div class="rounded-2xl border border-(--color-card-border) bg-(--color-card) p-5 backdrop-blur-xl"
                            style="box-shadow: 0 30px 80px -40px color-mix(in oklab, black 80%, transparent);">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-xs font-semibold tracking-wide text-(--color-muted) uppercase">
                                        {{ __('home.leader.label') }}
                                    </p>
                                    <p class="mt-1 text-lg font-bold text-(--color-primary)">
                                        #1 {{ $this->rankingFirstPlace->user->name ?? '' }}
                                    </p>
                                </div>

                                <span
                                    class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-semibold"
                                    style="border: 1px solid color-mix(in oklab, var(--color-warning) 35%, transparent);
                                     background: color-mix(in oklab, var(--color-warning) 12%, transparent);
                                     color: color-mix(in oklab, var(--color-warning) 85%, white 15%);">
                                    {{ __('home.leader.mvp') }}
                                </span>
                            </div>

                            <div class="mt-4 flex items-center gap-4">
                                <div class="relative">
                                    <img src="{{ $this->rankingFirstPlace->user->avatar ?? '' }}" alt="Avatar do líder"
                                        class="h-14 w-14 rounded-2xl object-cover"
                                        style="box-shadow: 0 0 0 2px var(--color-card-border);"
                                        onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($this->rankingFirstPlace->user->name ?? '') }}&background=111827&color=fff';" />
                                    <span
                                        class="absolute -bottom-1 -right-1 grid h-6 w-6 place-items-center rounded-full text-xs font-bold"
                                        style="background: var(--color-btn); color: var(--color-btn-fg); box-shadow: 0 0 0 2px var(--color-background);">
                                        1
                                    </span>
                                </div>


                                <div class="min-w-0 flex-1">
                                    <div class="flex items-baseline justify-between gap-3">
                                        <p class="text-sm font-semibold text-(--color-primary)">
                                            {{ number_format($this->rankingFirstPlace->points, 0, ',', '.') }}
                                            <span class="text-(--color-muted) font-medium">{{ __('home.leader.points') }}</span>
                                        </p>
                                        <p class="text-sm font-semibold text-(--color-primary)">
                                            {{ (int) $accuracy }}%
                                            <span class="text-(--color-muted) font-medium">{{ __('home.leader.accuracy') }}</span>
                                        </p>
                                    </div>


                                    <div class="mt-2 h-2 w-full overflow-hidden rounded-full"
                                        style="background: color-mix(in oklab, var(--color-border) 35%, transparent);">
                                        <div class="h-full rounded-full"
                                            style="width: {{ (int) $accuracy }}%; background: var(--color-btn);">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="mt-5 grid grid-cols-3 gap-3">
                                <div class="rounded-xl border border-(--color-card-border) bg-transparent p-3">
                                    <p class="text-[11px] text-(--color-muted)">{{ __('home.leader.streak_full') }}</p>
                                    <p class="mt-1 text-sm font-bold text-(--color-primary)">🔥
                                        {{ $this->rankingFirstPlace->best_full_points_streak }}</p>
                                </div>

                                <div class="rounded-xl border border-(--color-card-border) bg-transparent p-3">
                                    <p class="text-[11px] text-(--color-muted)">{{ __('home.leader.streak_non_points') }}</p>
                                    <p class="mt-1 text-sm font-bold text-(--color-primary)">
                                        {{ $this->rankingFirstPlace->best_non_points_streak }}</p>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif


            </div>
        </div>
    </section>

    <div class="mt-4">
        <livewire:live-matches />
    </div>



    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-2 mt-4 ">

        <livewire:next-games />

        <div class="gap-2 space-x-1 space-y-2 ">

            <livewire:home-page-ranking />

            <livewire:last-results />

        </div>

    </div>


</div>

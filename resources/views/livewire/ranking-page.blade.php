@use('App\Enum\MatchStageEnum')

<div>
    <div class="rounded-2xl border border-(--color-card-border) bg-(--color-card) overflow-hidden mt-4">
        <!-- Header -->
        <div class="px-4 py-4 border-b border-(--color-card-border)">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-base font-bold text-(--color-primary)">{{ __('ranking-page.title') }}</h2>
                    <p class="mt-1 text-sm text-(--color-muted)">{{ __('ranking-page.subtitle') }}</p>
                </div>

               
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <!-- Head -->
                <thead class="text-(--color-muted) text-xs uppercase tracking-wide">
                    <tr style="background: color-mix(in oklab, var(--color-border) 18%, transparent);">
                        <th class="px-4 py-3 text-left">{{ __('ranking-page.table.index') }}</th>
                        <th class="px-4 py-3 text-left">{{ __('ranking-page.table.position') }}</th>
                        <th class="px-4 py-3 text-left">{{ __('ranking-page.table.name') }}</th>
                        <th class="px-4 py-3 text-center">{{ __('ranking-page.table.points') }}</th>
                        <th class="px-4 py-3 text-center">{{ __('ranking-page.table.best_streak_full') }}</th>
                        <th class="px-4 py-3 text-center">{{ __('ranking-page.table.best_streak_zero') }}</th>
                        <th class="px-4 py-3 text-center">{{ __('ranking-page.table.accuracy') }}</th>
                    </tr>
                </thead>

                <!-- Body -->
                <tbody class="divide-y" style="--tw-divide-opacity: 1; border-color: var(--color-card-border);">
                    @foreach ($rankings as $index => $ranking)
                        @php
                            $isMe = $ranking->user_id === Auth::id();
                            $accuracy = $totalPoints > 0 ? ($ranking->points / $totalPoints) * 100 : 0;

                            $medal = match ($index) {
                                0 => '🥇',
                                1 => '🥈',
                                2 => '🥉',
                                default => (string) ($index + 1),
                            };
                        @endphp

                        <tr class="transition"
                            style="
                            {{ $isMe ? 'background: color-mix(in oklab, var(--color-btn) 14%, transparent);' : '' }}
                        "
                            onmouseover="this.style.backgroundColor='{{ $isMe ? 'color-mix(in oklab, var(--color-btn) 18%, transparent)' : 'color-mix(in oklab, var(--color-border) 16%, transparent)' }}'"
                            onmouseout="this.style.backgroundColor='{{ $isMe ? 'color-mix(in oklab, var(--color-btn) 14%, transparent)' : 'transparent' }}'">
                            <!-- posição -->
                            <td class="px-4 py-3 font-semibold text-(--color-primary)">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-4 py-3 font-semibold flex items-center gap-2 text-xl text-(--color-primary)">
                                <span class="text-2xl">{{ $medal }}</span>

                                @if ($ranking->last_position < $ranking->position)
                                    <x-ui.icon name="chevron-double-down" class="size-3 font-bold"
                                        style="color: color-mix(in oklab, var(--color-warning) 80%, white 20%);" />
                                @elseif ($ranking->last_position > $ranking->position)
                                    <x-ui.icon name="chevron-double-up" class="size-3 font-bold"
                                        style="color: color-mix(in oklab, var(--color-success) 80%, white 20%);" />
                                @else
                                    <x-ui.icon name="minus" class="text-(--color-muted) size-3 font-bold" />
                                @endif
                            </td>

                            <!-- nome -->
                            <td class="px-4 py-3 font-medium text-(--color-primary) capitalize">
                                {{ $ranking->user->name }}
                                @if ($isMe)
                                    <span
                                        class="ml-2 inline-flex items-center rounded-full border px-2 py-0.5 text-[11px] font-semibold"
                                        style="border-color: color-mix(in oklab, var(--color-btn) 35%, transparent);
                                             background: color-mix(in oklab, var(--color-btn) 12%, transparent);
                                             color: color-mix(in oklab, var(--color-btn) 85%, white 15%);">
                                        {{ __('ranking-page.table.you') }}
                                    </span>
                                @endif
                            </td>

                            <!-- pontos -->
                            <td class="px-4 py-3 text-center font-bold"
                                style="color: color-mix(in oklab, var(--color-btn) 85%, white 15%);">
                                {{ $ranking->points }}
                            </td>

                            <!-- melhor sequência -->
                            <td class="px-4 py-3 text-center text-(--color-primary)">
                                {{ $ranking->best_full_points_streak }}
                            </td>

                            <!-- melhor seq sem zerar -->
                            <td class="px-4 py-3 text-center text-(--color-primary)">
                                {{ $ranking->best_non_points_streak }}
                            </td>

                            <!-- aproveitamento -->
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <div class="w-16 h-2 rounded-full overflow-hidden"
                                        style="background: color-mix(in oklab, var(--color-border) 35%, transparent);">
                                        <div class="h-full rounded-full"
                                            style="width: {{ (int) $accuracy }}%; background: var(--color-btn);">
                                        </div>
                                    </div>
                                    <span class="text-xs text-(--color-muted)">
                                        {{ (int) $accuracy }}%
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>


</div>

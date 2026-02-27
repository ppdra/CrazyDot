@use('App\Enum\MatchStageEnum')

<div>
    <div class="w-full bg-(--color-background) rounded-2xl p-4">
        <x-ui.heading level="h2" size="md">Filters</x-ui.heading>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-2 mt-4 ">

            <x-ui.select placeholder="Select by stage..." wire:model="selectedStage">
                @foreach (MatchStageEnum::cases() as $stage)
                    <x-ui.select.option value="{{ $stage->value }}">
                        {{ str_replace('_', ' ', $stage->value) }}
                    </x-ui.select.option>
                @endforeach
            </x-ui.select>
        </div>
    </div>



    <div class="bg-(--color-background) border border-(--color-border) rounded-2xl overflow-visible mt-4">

        <!-- Header -->
        <div class="px-4 py-3 border-b border-(--color-border)]">
            <h2 class="text-lg font-semibold text-(--color-primary)]">
                Ranking Geral
            </h2>

        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <!-- Head -->
                <thead
                    class="bg-[color-mix(in_srgb,var(--color-border)_20%,transparent) text-(--color-muted) text-xs uppercase tracking-wide">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Posição</th>
                        <th class="px-4 py-3 text-left">Nome</th>
                        <th class="px-4 py-3 text-center">Pontos</th>
                        <th class="px-4 py-3 text-center ">Melhor seq 7 pts</th>
                        <th class="px-4 py-3 text-center ">Melhor seq. 0 pts</th>
                        <th class="px-4 py-3 text-center">Aproveitamento</th>
                    </tr>
                </thead>

                <!-- Body -->
                <tbody class="divide-y divide-(--color-border)]">
                    @foreach ($rankings as $index => $ranking)
                        @php
                            $isMe = $ranking->user_id === Auth::id();
                            $accuracy = $totalPoints > 0 ? ($ranking->points / $totalPoints) * 100 : 0;

                            $medal = match ($index) {
                                0 => '🥇',
                                1 => '🥈',
                                2 => '🥉',
                                4 => 'Petista Do Job',
                                default => (string) ($index + 1),
                            };
                        @endphp

                        <tr
                            class="
                        transition
                        hover:bg-(--color-surface)
                        {{ $isMe ? 'bg-(--color-accent)' : '' }}
                    ">
                            <!-- posição -->
                            <td class="px-4 py-3 font-semibold">
                                <div class="relative group w-8 h-8">
                                    <img src="{{ asset('images/position-' . $ranking->position . '.jpeg') }}"
                                        alt="Avatar"
                                        class="w-8 h-8 rounded-full object-cover
                   transition-all duration-300 ease-in-out
                   group-hover:scale-550
                   group-hover:z-50
                   relative">
                                </div>
                            </td>

                            <td class="px-4 py-3 font-semibold flex text-2xl">
                                {{ $medal }}

                                @if ($ranking->last_position < $ranking->position)
                                    <x-ui.icon name="chevron-double-down" class="text-red-500 size-3 font-bold" />
                                @elseif ($ranking->last_position > $ranking->position)
                                    <x-ui.icon name="chevron-double-up" class="text-green-500 size-3 font-bold" />
                                @else
                                    <x-ui.icon name="minus" class="text-(--color-muted) size-3 font-bold" />
                                @endif

                            </td>

                            <!-- nome -->
                            <td class="px-4 py-3 font-medium text-(--color-primary)]">
                                {{ $ranking->user->name }}
                            </td>

                            <!-- pontos -->
                            <td class="px-4 py-3 text-center font-bold text-(--color-accent)]">
                                {{ $ranking->points }}
                            </td>

                            <!-- melhor sequência -->
                            <td class="px-4 py-3 text-center  text-(--color-primary)]">
                                {{ $ranking->best_full_points_streak }}
                            </td>

                            <!-- melhor seq sem zerar -->
                            <td class="px-4 py-3 text-center  text-(--color-primary)]">
                                {{ $ranking->best_non_points_streak }}
                            </td>

                            <!-- aproveitamento -->
                            <td class="px-4 py-3 text-center">

                                <div class="flex items-center justify-center gap-2">
                                    <div class="w-16 h-2 rounded-full bg-(--color-border) overflow-hidden">
                                        <div class="h-full bg-(--color-muted)" style="width: 50%">
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

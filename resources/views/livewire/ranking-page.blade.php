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

    {{-- @php
        // Mock de ranking (dados falsos)
        $ranking = collect([
            (object) [
                'id' => 1,
                'name' => 'João Silva',
                'points' => 86,
                'best_streak' => 7,
                'best_streak_without_zero' => 12,
                'accuracy' => 68,
            ],
            (object) [
                'id' => 2,
                'name' => 'Maria Souza',
                'points' => 82,
                'best_streak' => 6,
                'best_streak_without_zero' => 10,
                'accuracy' => 64,
            ],
            (object) [
                'id' => 3,
                'name' => 'Você',
                'points' => 79,
                'best_streak' => 5,
                'best_streak_without_zero' => 9,
                'accuracy' => 61,
            ],
            (object) [
                'id' => 4,
                'name' => 'Pedro Lima',
                'points' => 73,
                'best_streak' => 4,
                'best_streak_without_zero' => 8,
                'accuracy' => 57,
            ],
            (object) [
                'id' => 5,
                'name' => 'Ana Martins',
                'points' => 69,
                'best_streak' => 4,
                'best_streak_without_zero' => 7,
                'accuracy' => 55,
            ],
            (object) [
                'id' => 6,
                'name' => 'Rafa Costa',
                'points' => 65,
                'best_streak' => 3,
                'best_streak_without_zero' => 6,
                'accuracy' => 52,
            ],
            (object) [
                'id' => 7,
                'name' => 'Bruno Alves',
                'points' => 61,
                'best_streak' => 3,
                'best_streak_without_zero' => 5,
                'accuracy' => 49,
            ],
            (object) [
                'id' => 8,
                'name' => 'Camila Rocha',
                'points' => 58,
                'best_streak' => 2,
                'best_streak_without_zero' => 4,
                'accuracy' => 46,
            ],
            (object) [
                'id' => 9,
                'name' => 'Diego Nunes',
                'points' => 54,
                'best_streak' => 2,
                'best_streak_without_zero' => 3,
                'accuracy' => 43,
            ],
            (object) [
                'id' => 10,
                'name' => 'Lia Ferreira',
                'points' => 50,
                'best_streak' => 2,
                'best_streak_without_zero' => 3,
                'accuracy' => 41,
            ],
        ]);

        // “Usuário atual” fake (pra destacar a linha)
        $currentUserId = 3;
    @endphp --}}

    <div class="bg-(--color-background) border border-(--color-border) rounded-2xl overflow-hidden mt-4">

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
                            <td class="px-4 py-3 font-semibold flex">
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

@use('App\Enum\MatchStatusEnum')
@use('App\Enum\MatchStageEnum')

<div class="rounded-2xl backdrop-blur-md border border-(--color-border) bg-(--color-background)">

    <div class="p-3 sm:p-4 space-y-3">

        <!-- Top row: badge + datetime -->
        <div class="flex items-start justify-between gap-3">
            <div class="shrink-0" @if ($this->shouldPoll()) wire:poll.30s @endif>
                <x-match-badge-status :match="$match" />
            </div>

            <div class="flex space-x-2 ">
                <x-ui.icon name="calendar-days" class="text-(--color-muted) size-5" />

                <span
                    class="text-xs sm:text-sm text-(--color-muted)] text-right leading-tight truncate max-w-[60%] sm:max-w-none">
                    {{ $match->utc_date->tz(session('tz')) }}
                </span>
            </div>
        </div>

        <!-- Secondary info -->
        <div class="flex items-start justify-between gap-3">
            <div>
                @if ($match->stage === MatchStageEnum::GROUP_STAGE)
                    <x-ui.badge size='sm'>{{ $match->group_name->label() }}</x-ui.badge>
                    <x-ui.badge size='sm'>Matchday {{ $match->matchday }}</x-ui.badge>
                @else
                    <x-ui.badge size='sm'>{{ str_replace('_', ' ', $match->stage->name) }}</x-ui.badge>
                @endif
            </div>

            <div>
                @if ($betIsPlaced)
                    <x-ui.icon name="check-badge" class="text-green-500 size-5" />
                @endif

            </div>
        </div>
    </div>

    <x-ui.separator class="my-2 bg-(--color-border)" />


    <x-ui.accordion>
        <x-ui.accordion.item>
            <x-ui.accordion.trigger>
                <div class="w-full min-w-0">
                    <div class="grid grid-cols-3 items-center gap-2 sm:gap-4">

                        <!-- Home Team -->
                        <div class="flex flex-col items-center gap-1 sm:gap-2 min-w-0">
                            <img src="{{ $match->homeTeam?->logo_url ?? 'https://media.istockphoto.com/id/2212375124/vector/tba-to-be-announced-sign-sticker-icon-symbol-vector.jpg?s=612x612&w=0&k=20&c=2-s3i4olILrA7mcLTFrpdPGSXfSUFDYLD1A8NKhnmQI=' }}"
                                class="w-10 h-10 sm:w-14 sm:h-14 object-contain"
                                alt="{{ $match->homeTeam?->name ?? 'TBA' }}" />

                            <span class="font-semibold text-center truncate max-w-full text-sm sm:text-lg">
                                <span class="sm:hidden">{{ $match->homeTeam?->slug ?? 'TBA' }}</span>
                                <span class="hidden sm:inline">{{ $match->homeTeam?->name ?? 'TBA' }}</span>
                            </span>
                        </div>

                        <!-- Score -->
                        <div class="flex items-center justify-center gap-2 sm:gap-4 font-extrabold shrink-0">
                            <span class="text-2xl sm:text-4xl leading-none">0</span>
                            <span class="text-(--color-primary)] text-lg sm:text-2xl font-medium leading-none">x</span>
                            <span class="text-2xl sm:text-4xl leading-none">0</span>
                        </div>

                        <!-- Away Team -->
                        <div class="flex flex-col items-center gap-1 sm:gap-2 min-w-0">
                            <img src="{{ $match->awayTeam?->logo_url ?? 'https://media.istockphoto.com/id/2212375124/vector/tba-to-be-announced-sign-sticker-icon-symbol-vector.jpg?s=612x612&w=0&k=20&c=2-s3i4olILrA7mcLTFrpdPGSXfSUFDYLD1A8NKhnmQI=' }}"
                                class="w-10 h-10 sm:w-14 sm:h-14 object-contain"
                                alt="{{ $match->awayTeam?->name ?? 'TBA' }}" />

                            <span class="font-semibold text-center truncate max-w-full text-sm sm:text-lg">
                                <span class="sm:hidden">{{ $match->awayTeam?->slug ?? 'TBA' }}</span>
                                <span class="hidden sm:inline">{{ $match->awayTeam?->name ?? 'TBA' }}</span>
                            </span>
                        </div>

                    </div>
                </div>
            </x-ui.accordion.trigger>

            <x-ui.accordion.content>

                <x-ui.separator class="my-2 bg-(--color-border)" />
                <x-ui.tabs activeTab="bet">
                    <x-ui.tab.group class="justify-start">
                        <x-ui.tab label="Bet" name="bet" icon="pencil" />
                        @if ($match->utc_date->isPast())
                            <x-ui.tab label="Results" name="results" icon="document-chart-bar" />
                        @endif
                        <x-ui.tab label="Joker" name="joker" icon="cog-6-tooth" />
                    </x-ui.tab.group>

                    <x-ui.tab.panel name="bet">
                        <div class="flex items-center justify-center gap-8">

                            <div class="flex flex-col items-center gap-3">
                                <div class="flex items-center gap-2">

                                    <x-ui.button color='red' icon='minus' variant="outline" size="sm"
                                        wire:click="decrementScore('home')">

                                    </x-ui.button>

                                    <x-ui.input class="w-16 text-center" wire:model="homeScore" type="text"
                                        min="0" disabled>
                                    </x-ui.input>

                                    <x-ui.button color='emerald' icon='plus' variant="outline" size="sm"
                                        wire:click="incrementScore('home')">
                                    </x-ui.button>
                                </div>
                            </div>

                            <span class="text-2xl font-bold text-(--color-primary)">x</span>

                            <div class="flex flex-col items-center gap-3">
                                <div class="flex items-center gap-2">

                                    <x-ui.button color='red' icon='minus' variant="outline" size="sm"
                                        wire:click="decrementScore('away')">
                                    </x-ui.button>

                                    <x-ui.input class="w-16 text-center" wire:model="awayScore" type="text"
                                        min="0" disabled>

                                    </x-ui.input>

                                    <x-ui.button color='emerald' icon='plus' variant="outline" size="sm"
                                        wire:click="incrementScore('away')">
                                    </x-ui.button>

                                </div>

                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 sm:grid-cols-1 md:gap-3 sm:gap-1">
                            @if ($match->utc_date->isFuture())
                                <x-ui.button variant="outline" icon='bookmark-square' color="blue" class="w-full mt-6"
                                    wire:click="saveUserBet">
                                    Save
                                </x-ui.button>

                                <div wire:ignore x-data="{ placed: @entangle('betIsPlaced') }">
                                    <template x-if="placed">
                                        <x-ui.button variant="outline" icon='trash' color="red" class="w-full mt-6"
                                            wire:click="removeUserBet">
                                            Remove Bet
                                        </x-ui.button></template>
                                </div>
                            @endif



                        </div>

                    </x-ui.tab.panel>

                    @if ($match->utc_date->isPast())
                        <x-ui.tab.panel name='results'>
                            <div
                                class="bg-(--color-background) border border-(--color-border)/10 rounded-2xl overflow-hidden">

                                <!-- Cabeçalho -->
                                <div
                                    class="grid grid-cols-3 px-6 py-3 bg-(--color-surface) text-sm font-semibold text-(--color-primary)">
                                    <span>Participante</span>
                                    <span class="text-center">Palpite</span>
                                    <span class="text-right">Pontos</span>
                                </div>

                                <!-- Linhas -->
                                @foreach ($match->validatedPlacedBets as $bet)
                                    <div
                                        class="grid grid-cols-3 px-6 py-4 items-center border-t border-(--color-border) hover:bg-(--color-accent) hover:text-(--color-surface) transition">

                                        <!-- Nome -->
                                        <span class="font-medium">
                                            {{ $bet->user->name }}
                                        </span>

                                        <!-- Resultado -->
                                        <span class="text-center font-semibold">
                                            {{ $bet->result->home_score }}
                                            x
                                            {{ $bet->result->away_score }}
                                        </span>

                                        <!-- Pontos -->
                                        <span class="text-right font-bold }}">
                                            {{ $bet['points'] }}
                                        </span>

                                    </div>
                                @endforeach

                            </div>
                        </x-ui.tab.panel>
                    @endif
                    <x-ui.tab.panel>
                        <h3 class="text-lg font-semibold mb-2">Third Tab</h3>
                        <p>This is the third tab content.</p>
                    </x-ui.tab.panel>
                </x-ui.tabs>
            </x-ui.accordion.content>
        </x-ui.accordion.item>

    </x-ui.accordion>
</div>

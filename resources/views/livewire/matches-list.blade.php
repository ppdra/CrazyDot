@use('App\Enum\MatchStageEnum')
<div class="p-2">

    <div class="w-full bg-(--color-background) rounded-2xl p-4">
        <x-ui.heading level="h2" size="md">Filtros</x-ui.heading>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-2 mt-4 ">

            <x-ui.select placeholder="{{ __('matches-list.placeholders.status') }}" wire:model.live="selectedStatus"
                multiple clearable>
                @foreach ($statusOptsList as $opt)
                    <x-ui.select.option value="{{ $opt->value }}">{{ $opt->label() }}</x-ui.select.option>
                @endforeach
            </x-ui.select>

            <x-ui.select placeholder="{{ __('matches-list.placeholders.group') }}" wire:model.live="selectedGroup"
                multiple clearable :disabled="$selectedStage !== null && $selectedStage !== MatchStageEnum::GROUP_STAGE->value">
                @foreach ($groupOptsList as $group)
                    <x-ui.select.option value="{{ $group }}">
                        {{ $group->label() }}
                    </x-ui.select.option>
                @endforeach
            </x-ui.select>

            <x-ui.select placeholder="{{ __('matches-list.placeholders.stage') }}" wire:model.live="selectedStage"
                clearable :disabled="!empty($selectedGroup)">
                @foreach ($stageOptsList as $stage)
                    <x-ui.select.option value="{{ $stage }}">
                        {{ $stage->label() }}
                    </x-ui.select.option>
                @endforeach
            </x-ui.select>

            <x-ui.select placeholder="{{ __('matches-list.placeholders.countries') }}" multiple searchable clearable
                wire:model.live="selectedCountry">
                @foreach ($countryOptsList as $id => $country)
                    <x-ui.select.option value="{{ $id }}">{{ $country }}</x-ui.select.option>
                @endforeach
            </x-ui.select>

            <x-ui.select placeholder="{{ __('matches-list.placeholders.bet_status') }}"
                wire:model.live="selectedBetIsPlaced" clearable>
                <x-ui.select.option value="true">
                    {{ __('matches-list.bet.placed') }}
                </x-ui.select.option>
                <x-ui.select.option value="false">
                    {{ __('matches-list.bet.not_placed') }}
                </x-ui.select.option>
            </x-ui.select>


        </div>
    </div>

    <x-slot:loading>
        loading...
    </x-slot>
    <div class="mt-5 grid sm:grid-cols-1 md:grid-cols-2  gap-4 place-items-center h-full">

        @foreach ($gamesList as $match)
            <div wire:key="match-{{ $match->id }}" class="w-full self-start">
                <livewire:match-component :match="$match" :key="'match-' . $match->id" />
            </div>
        @endforeach
    </div>

    

</div>

<div>
    @php
        $sections = [
            [
                'id' => '1',
                'title' => __('instructions.sections.account.title'),
                'description' => __('instructions.sections.account.description'),
                'emoji' => '👤',
            ],

            [
                'id' => '2',
                'title' => __('instructions.sections.how_to_play.title'),
                'description' => __('instructions.sections.how_to_play.description'),
                'emoji' => '🎮',
            ],
            [
                'id' => '3',
                'title' => __('instructions.sections.ranking.title'),
                'description' => __('instructions.sections.ranking.description'),
                'emoji' => '🏆',
            ],
        ];
    @endphp


    <div class="fixed bottom-6 right-6 z-50">
        <x-ui.modal.trigger id="slideover-demo">
            <x-ui.button icon="book-open" class="px-5 py-3 shadow-xl rounded-full">
                {{ __('instructions.ui.guide_button') }}
            </x-ui.button>
        </x-ui.modal.trigger>
    </div>

    <x-ui.modal id="slideover-demo" heading="{{ __('instructions.ui.slideover.heading') }}"
        description="{{ __('instructions.ui.slideover.description') }}" slideover>
        <div class="space-y-6 mt-4">

            @foreach ($sections as $section)
                @php
                    $isActive = $activeSectionId === (int) $section['id'];
                @endphp
                <a href="#{{ $section['id'] }}" wire:click="$set('activeSectionId', {{ $section['id'] }})"
                    class="block rounded-xl border p-3 transition
                    {{ $isActive
                        ? 'border-(--color-btn) bg-(--color-background) shadow-md'
                        : 'border-(--color-card-border) bg-(--color-card)' }}">

                    <div class="flex items-center gap-3">
                        <div class="">
                            {{ $section['emoji'] }}
                        </div>

                        <div class="min-w-0">
                            <h3 class="text-sm font-semibold text-(--color-primary)">
                                {{ $section['title'] }}
                            </h3>
                            <p class="text-xs text-(--color-muted) truncate">
                                {{ $section['description'] }}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach

        </div>

    </x-ui.modal>



    <div class="space-y-5">
        {{-- <div class="w-full overflow-hidden rounded-xl">
            <img src="{{ asset('images/how-to/chipa-pagapix.png') }}" alt="Chimpanzé pagando com Pix"
                class="w-full h-40 sm:h-56 md:h-90 object-cover" />
        </div> --}}

        @include('components.partials.how-to-play.account-section', ['id' => '1'])
        @include('components.partials.how-to-play.how-to-play-section', ['id' => '2'])
        @include('components.partials.how-to-play.ranking-section', ['id' => '3'])


    </div>



</div>

@php
    $sections = [
        [
            'id' => 'account',
            'title' => __('instructions.sections.account.title'),
            'description' => __('instructions.sections.account.description'),
            'emoji' => '👤',
        ],
        [
            'id' => 'how-to-play',
            'title' => __('instructions.sections.how_to_play.title'),
            'description' => __('instructions.sections.how_to_play.description'),
            'emoji' => '🎮',
        ],
        // ['title' => __('instructions.sections.scoring.title'), 'description' => __('instructions.sections.scoring.description'), 'emoji' => '🏅'],
        // ['title' => __('instructions.sections.ranking.title'), 'description' => __('instructions.sections.ranking.description'), 'emoji' => '🏆'],
    ];
@endphp

<x-layouts.app>

    <x-ui.modal.trigger id="slideover-demo" class="w-full">
    <x-ui.button 
        icon="book-open" 
        variant="outline" 
        class="w-full py-3 text-base font-semibold justify-center">
        Guia Completo
    </x-ui.button>
</x-ui.modal.trigger>

    <x-ui.modal id="slideover-demo" heading="How to Play" description="Sections with instructions on how to play the game."
        slideover>

        <div class="space-y-6 mt-4">

            @foreach ($sections as $section)
                <a href="#{{ $section['id'] }}"
                    class="block rounded-xl border border-(--color-card-border) bg-(--color-card)
              p-3 transition hover:bg-(--color-background) hover:-translate-y-0.5
              hover:shadow-[0_10px_30px_-20px_rgba(0,0,0,0.6)]">

                    <div class="flex items-center gap-3">
                        <div
                            class="h-9 w-9 rounded-lg border border-(--color-card-border)
                        bg-(--color-background) grid place-items-center text-base">
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

        @include('components.partials.how-to-play.account-section')
        @include('components.partials.how-to-play.how-to-play-section')
        @include('components.partials.how-to-play.ranking-section')


    </div>


</x-layouts.app>

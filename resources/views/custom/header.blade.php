@use('App\Enum\ReactionEmoji')
@php
    $langs = [
        ['locale' => 'pt_BR', 'flag' => '🇧🇷', 'label' => 'PT'],
        ['locale' => 'en', 'flag' => '🇺🇸', 'label' => 'EN'],
    ];
@endphp
<x-ui.layout.header>
    <x-ui.sidebar.toggle class="md:hidden" />

    @if (auth()->user()->mostReceivedEmojiId())
        <div class="overflow-hidden">
            <div class="whitespace-nowrap animate-[emoji-scroll_20s_linear_infinite] inline-block">
                @for ($a = 0; $a < 120; $a++)
                    <span class="mx-2 text-xl">
                        {{ ReactionEmoji::emojiFromId(auth()->user()->mostReceivedEmojiId()) ?? '' }}
                    </span>
                @endfor
            </div>
        </div>
    @endif


    <div class="flex ml-auto gap-x-3 items-center">
        <x-ui.dropdown position="bottom-end">
            <x-slot:button class="justify-center">
                {{-- <x-ui.avatar size="sm" src="{{ asset('images/position-' . Auth::user()->ranking->position . '.jpeg') }}" circle alt="Profile Picture" /> --}}

                <x-ui.avatar size="sm" src="{{ asset('images/logo.png') }}" circle alt="Profile Picture" />
            </x-slot:button>

            <x-slot:menu class="w-56">
                <x-ui.dropdown.group label="{{ __('header.signed_in_as') }}">
                    <x-ui.dropdown.item>
                        {{ Auth::user()->email }}
                    </x-ui.dropdown.item>
                </x-ui.dropdown.group>

                <x-ui.dropdown.group label="{{ __('header.language') }}">
                    @foreach ($langs as $lang)
                        <x-ui.dropdown.item
                            class="{{ App::getLocale() === $lang['locale'] ? 'bg-(--color-accent)/20' : '' }}"
                            href="{{ route('lang.switch', ['locale' => $lang['locale']]) }}">
                            {{ $lang['flag'] }} {{ $lang['label'] }}
                        </x-ui.dropdown.item>
                    @endforeach


                </x-ui.dropdown.group>

                <x-ui.dropdown.separator />

                <x-ui.dropdown.item href="{{ route('account') }}" wire:navigate.live>
                    {{ __('header.account') }}
                </x-ui.dropdown.item>

                <x-ui.dropdown.separator />

                <x-ui.dropdown.item as="button" href="{{ route('logout') }}">
                    {{ __('header.sign_out') }}
                </x-ui.dropdown.item>

            </x-slot:menu>
        </x-ui.dropdown>

        <x-ui.theme-switcher variant="inline" />
    </div>
</x-ui.layout.header>

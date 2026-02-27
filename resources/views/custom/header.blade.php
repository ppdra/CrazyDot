<x-ui.layout.header>
    <x-ui.sidebar.toggle class="md:hidden" />

    <div class="flex ml-auto gap-x-3 items-center">
        <x-ui.dropdown position="bottom-end">
            <x-slot:button class="justify-center">
                <x-ui.avatar size="sm" src="{{ asset('images/position-' . Auth::user()->ranking->position . '.jpeg') }}" circle alt="Profile Picture" />
            </x-slot:button>

            <x-slot:menu class="w-56">
                <x-ui.dropdown.group label="signed in as">
                    <x-ui.dropdown.item>
                        {{ Auth::user()->email }}
                    </x-ui.dropdown.item>
                </x-ui.dropdown.group>

                <x-ui.dropdown.separator />

                <x-ui.dropdown.item href="{{ route('account') }}" wire:navigate.live>
                    Account
                </x-ui.dropdown.item>

                <x-ui.dropdown.separator />

                    <x-ui.dropdown.item as="button" href="{{ route('logout') }}">
                        Sign Out
                    </x-ui.dropdown.item>

            </x-slot:menu>
        </x-ui.dropdown>

        <x-ui.theme-switcher variant="inline" />
    </div>
</x-ui.layout.header>

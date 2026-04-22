@php
    $menu = [
        ['label' => 'sidebar.home', 'icon' => 'home', 'route' => '/'],
        ['label' => 'sidebar.matches', 'icon' => 'globe-americas', 'route' => '/matches'],
        ['label' => 'sidebar.ranking', 'icon' => 'trophy', 'route' => '/ranking'],
        ['label' => 'sidebar.stats', 'icon' => 'chart-bar', 'route' => '/stats'],
        ['label' => 'sidebar.rules', 'icon' => 'book-open', 'route' => '/how-to-play'],
    ];
@endphp




<x-ui.sidebar>
    <x-slot:brand>
        <x-ui.brand href="/"
            logo="{{ asset('images/logo.png') }}"
            name="Crazy Dot" alt="Crazy Dot" logoClass="rounded-full size-12" />
    </x-slot:brand>
    <x-ui.navlist class="mt-5">

        @foreach ($menu as $item)
            @if (!isset($item['subItems']))
                <x-ui.navlist.item :label="__($item['label'])" :icon="$item['icon']" :href="$item['route']" />
            @else
                <x-ui.navlist.group :label="__($item['subItems']['label'])" :collapsable="true">
                    @foreach ($item['subItems']['items'] as $subItem)
                        <x-ui.navlist.item :label="__($subItem['label'])" :href="$subItem['route']" />
                    @endforeach
                </x-ui.navlist.group>
            @endif
        @endforeach


    </x-ui.navlist>

    <x-ui.sidebar.push />


</x-ui.sidebar>

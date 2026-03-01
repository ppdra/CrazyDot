@php
    $menu = [
        ['label' => 'Home', 'icon' => 'home', 'route' => '/'],
        ['label' => 'Partidas', 'icon' => 'globe-americas', 'route' => '/matches'],
        ['label' => 'Ranking', 'icon' => 'trophy', 'route' => '/ranking'],
        // ['label' => 'Estatísticas', 'icon' => 'chart-bar', 'route' => '/stats'],
        ['label' => 'Regras', 'icon' => 'newspaper', 'route' => '/rules'],
    ];
@endphp




<x-ui.sidebar>
    <x-slot:brand>
        <x-ui.brand href="/"
            logo="https://img.elo7.com.br/product/685x685/2B54CD8/big-poster-filme-joker-coringa-joaquin-phoenix-lo06-90x60-cm-filme-joker.jpg"
            name="Crazy Dot" alt="Crazy Dot" logoClass="rounded-full size-12" />
    </x-slot:brand>
    <x-ui.navlist class="mt-5">

        @foreach ($menu as $item)
            @if (!isset($item['subItems']))
                <x-ui.navlist.item :label="$item['label']" :icon="$item['icon']" :href="$item['route']" />
            @else
                <x-ui.navlist.group :label="$item['subItems']['label']" :collapsable="true">
                    @foreach ($item['subItems']['items'] as $subItem)
                        <x-ui.navlist.item :label="$subItem['label']" :href="$subItem['route']" />
                    @endforeach
                </x-ui.navlist.group>
            @endif
        @endforeach


    </x-ui.navlist>

    <x-ui.sidebar.push />


</x-ui.sidebar>

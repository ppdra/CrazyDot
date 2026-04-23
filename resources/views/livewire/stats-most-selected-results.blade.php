<div class="rounded-2xl p-4 backdrop-blur-md border border-(--color-border) bg-(--color-background)">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-sm font-medium text-zinc-400">
            {{ __('stats.stats_most_selected_results.header') }}
        </h3>
    </div>

    <!-- SELECT -->
    <div class="mb-4">
        <x-ui.select placeholder="{{ __('stats.stats_most_selected_results.filter_placeholder') }}" wire:model.live="selectedResult" searchable>
            @foreach ($results as $opt)
                <x-ui.select.option value="{{ $opt['id'] }}">
                    {{ $opt['home_score'] }}x{{ $opt['away_score'] }}
                </x-ui.select.option>
            @endforeach
        </x-ui.select>
    </div>

    <div class="flex-1 flex items-center justify-center">

        @if ($selectedResult && count($data))
            <div wire:ignore wire:key="pie-chart-{{ $selectedResult }}" class="w-full max-w-xs mx-auto"
                x-data="pieChartComponent(
                    @entangle('labels'),
                    @entangle('data'),
                    @entangle('colors')
                )" x-init="init()">
                <canvas x-ref="canvas"></canvas>
            </div>
        @else
            <x-ui.empty class="w-full border border-neutral-800 rounded-box">
                <div class="py-6 text-center text-sm text-zinc-500">
                    {{ __('stats.stats_most_selected_results.info') }}
                </div>
            </x-ui.empty>
        @endif


    </div>
    
    <div class="flex items-center justify-between mb-4">
        @if ($selectedResult && count($data))
            <span class="text-xs text-zinc-500">
                Total: <span class="text-zinc-200 font-medium">
                    {{ $this->total }}
                </span>
            </span>
        @endif
    </div>

</div>


<script>
   function pieChartComponent(labels, data, colors) {
    return {
        chart: null,
        labels,
        data,
        colors,

        init() {
            this.$nextTick(() => {
                this.renderChart()
            })

            this.$watch('labels', () => this.updateChart())
            this.$watch('data', () => this.updateChart())
            this.$watch('colors', () => this.updateChart())
        },

        renderChart() {
            if (!this.$refs.canvas) return

            const ctx = this.$refs.canvas.getContext('2d')
            if (!ctx) return

            if (this.chart) {
                this.chart.destroy()
            }

            this.chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: this.labels,
                    datasets: [{
                        data: this.data,
                        backgroundColor: this.colors, 
                        borderColor: '#18181b',
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#a1a1aa',
                                padding: 12
                            }
                        },
                        tooltip: {
                            backgroundColor: '#18181b',
                            titleColor: '#fff',
                            bodyColor: '#d4d4d8',
                            borderColor: '#27272a',
                            borderWidth: 1
                        }
                    }
                }
            })
        },

        updateChart() {
            if (!this.chart) return
            this.chart.destroy()
            this.renderChart()
        }
    }
}
</script>

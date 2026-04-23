<div class="rounded-2xl p-4 backdrop-blur-md border border-(--color-border) bg-(--color-background)">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-sm font-medium text-zinc-400">
            {{ __('stats.stats-chart-points-evolution-per-day.header') }}
        </h3>
    </div>

    <div class="flex-1 flex items-center justify-center">

        @if ($labels && $datasets)
            <div wire:ignore x-data="lineChart(@js($labels), @js($datasets))" x-init="init()" class="h-[300px]">

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



</div>
<script>
    function lineChart(labels, datasets) {
        return {
            chart: null,
            labels,
            datasets,

            init() {
                this.$nextTick(() => {
                    this.render()
                })

                Livewire.on('refreshChart', () => {
                    this.update()
                })
            },

            render() {
                const ctx = this.$refs.canvas.getContext('2d')

                this.chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: this.labels,
                        datasets: this.datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,

                        plugins: {
                            legend: {
                                labels: {
                                    color: '#a1a1aa'
                                }
                            },
                            tooltip: {
                                backgroundColor: '#18181b',
                                titleColor: '#fff',
                                bodyColor: '#d4d4d8',
                                borderColor: '#27272a',
                                borderWidth: 1
                            }
                        },

                        scales: {
                            x: {
                                ticks: {
                                    color: '#71717a'
                                },
                                grid: {
                                    color: '#27272a'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: '#71717a'
                                },
                                grid: {
                                    color: '#27272a'
                                }
                            }
                        }
                    }
                })
            },

            update() {
                if (!this.chart) return

                this.chart.data.labels = this.labels
                this.chart.data.datasets = this.datasets
                this.chart.update()
            }
        }
    }
</script>

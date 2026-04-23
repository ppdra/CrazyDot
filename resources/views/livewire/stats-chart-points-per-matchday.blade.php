<div class="rounded-2xl p-4 backdrop-blur-md border border-(--color-border) bg-(--color-background)">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-sm font-medium text-zinc-400">
            {{ __('stats.stats-chart-points-per-day.header') }}
        </h3>
    </div>

    <div class="overflow-x-auto">
        <div wire:ignore x-data="barChart(@js($labels), @js($datasets))" x-init="init()">
            <canvas x-ref="canvas"></canvas>
        </div>
    </div>

</div>

<script>
    function barChart(labels, datasets) {
        return {
            chart: null,
            labels,
            datasets,

            init() {
                this.$nextTick(() => {

                    const canvas = this.$refs.canvas

                    const widthPerLabel = 100
                    const height = 300

                    canvas.style.width = (this.labels.length * widthPerLabel) + 'px'
                    canvas.style.height = height + 'px'

                    const ctx = canvas.getContext('2d')

                    this.chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: this.labels,
                            datasets: this.datasets
                        },
                        options: {
                            responsive: false,
                            maintainAspectRatio: false,

                            plugins: {
                                legend: {
                                    labels: {
                                        color: '#a1a1aa'
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    ticks: {
                                        color: '#71717a'
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        color: '#71717a'
                                    }
                                }
                            }
                        }
                    })
                })
            }
        }
    }
</script>

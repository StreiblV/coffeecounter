<x-layout.drawer>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="flex flex-row flex-wrap w-full pe-2 md:pe-0 gap-y-2">
        <div class="w-full md:w-6/12">
            <div class="card">
                <div class="text-center">
                    <h4 class="mb-8">Today</h4>
                    <livewire:analytics.chart-today />
                </div>
            </div>
        </div>

        <div class="w-full md:w-6/12">
            <div class="card">
                <div class="text-center">
                    <h4 class="mb-8">Last 30 days</h4>
                    <livewire:analytics.chart-thirty-days />
                </div>
            </div>
        </div>

        <div class="w-full md:w-6/12">
            <div class="card">
                <div class="text-center">
                    <h4 class="mb-8">All time consumed</h4>
                    <livewire:analytics.chart-total />
                    Energy Levels
                </div>
            </div>
        </div>

        <div class="w-full md:w-6/12">
            <div class="card">
                <div class="text-center">
                    <h4 class="mb-8">Ratio</h4>
                    <livewire:analytics.chart-ratio />
                </div>
            </div>
        </div>
    </div>

</x-layout.drawer>
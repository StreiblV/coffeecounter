<x-layout.drawer>

<div class="flex flex-row flex-wrap w-full pe-2 md:pe-0">
    <div class="card w-full">
        <div class="text-center">
            <h4 class="mb-8">Todays consumption</h4>
            <h4 class="text-green font-bold">
                {{ $energyLevels }}            
            </h4>
            Energy Levels
        </div>
    </div>

    <div class="card w-full">
        <h4 class="mb-8 text-center">Consume</h4>
        <livewire:dashboard.consume></wire:dashboard.consume>
    </div>

    <div class="card w-full">
        <h4 class="mb-8 text-center">Todays entries</h4>
        <table class="w-full table-fixed">
            <thead>
                <tr class="hidden md:table-row">
                    <th class="text-start">
                        Entry
                    </th>
                    <th class="text-start">
                        Time
                    </th>
                    <th class="text-end hidden md:table-cell">
                    </th>
                </tr>
                <tr class="table-row md:hidden">
                    <th class="text-start">
                        Entry
                    </th>
                    <th class="text-end hidden md:table-cell">
                    </th>
                </tr>
            </thead>
            <livewire:dashboard.entry-table :entries="$entries"/>
        </table>
    </div>

    <div class="card w-full">
        <div class="text-center">
            <h4 class="mb-8">✨ AI Overview ✨</h4>
            <div id="ai-overview" class="text-center">
                <button class="button button-primary">Generate</button>
            </div>
        </div>
    </div>
</div>

</x-layout.drawer>
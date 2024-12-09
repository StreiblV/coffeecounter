<x-layout.drawer>

<div class="flex flex-row flex-wrap w-full pe-2 md:pe-0">
    <div class="card w-full">
        <div class="text-center">
            <h4 class="mb-8">Todays consumption</h4>
            <h4 class="text-green font-bold">12</h4>
            Energy Levels
        </div>
    </div>

    <div class="card w-full">
        <h4 class="mb-8 text-center">Consume</h4>
        <div class="text-center">
            <button class="button">Coffee</button>
            <button class="button">Cola</button>
            <button class="button">Energy drink</button>
            <button class="button">Widlkraut</button>
        </div>        
    </div>

    <div class="card w-full">
        <h4 class="mb-8 text-center">Todays entries</h4>
        <table class="w-full table-fixed">
            <thead>
                <tr>
                    <th class="text-start">
                        Name
                    </th>
                    <th class="text-start">
                        Time
                    </th>
                    <th class="text-end">
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-start">
                        Coffee
                    </td>
                    <td class="text-start">
                        10:00
                    </td>
                    <td class="text-end">
                        <a class="button">Remove</a>
                    </td>
                </tr>
                <tr>
                    <td class="text-start">
                        Coffee
                    </td>
                    <td class="text-start">
                        12:00
                    </td>
                    <td class="text-end">
                        <a class="button">Remove</a>
                    </td>
                </tr>
            </tbody>
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
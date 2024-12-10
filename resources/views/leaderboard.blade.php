<x-layout.drawer>
    <div class="flex flex-row flex-wrap w-full pe-2 md:pe-0">
        <div class="w-full md:w-6/12">
            <div class="card">
                <div class="text-center">
                    <h4 class="mb-8">All time top consumers</h4>
                    <table class="w-full table-fixed">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Leader</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Coffee</td>
                                <td>{{ $top["coffee"]->name }}</td>
                            </tr>
                            <tr>
                                <td>Wildkraut</td>
                                <td>{{ $top["wildkraut"]->name }}</td>
                            </tr>
                            <tr>
                                <td>Energy Drinks</td>
                                <td>{{ $top["energydrink"]->name }}</td>
                            </tr>
                            <tr>
                                <td>Coke</td>
                                <td>{{ $top["coke"]->name }}</td>
                            </tr>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</x-layout.drawer>
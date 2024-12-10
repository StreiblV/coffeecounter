<x-layout.drawer>
    <div class="flex flex-row flex-wrap w-full">
        <div class="w-full">
            <div class="card">
                <div class="text-center">
                    <h4 class="mb-8">Today's top consumers</h4>
                    <table class="w-full table-fixed">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Leader</th>
                                <th>Count</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach (['coffee', 'wildkraut', 'energydrink', 'coke'] as $type)
                            <tr>
                                <td>{{ ucfirst($type) }}</td>
                                <td>{{ $topToday[$type]['username'] ?? 'Nobody' }}</td>
                                <td>{{ $topToday[$type]['points'] ?? 0 }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="text-center">
                    <h4 class="mb-8">Monthly top consumers</h4>
                    <table class="w-full table-fixed">
                        <thead>
                        <tr>
                            <th>Category</th>
                            <th>Leader</th>
                            <th>Count</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach (['coffee', 'wildkraut', 'energydrink', 'coke'] as $type)
                            <tr>
                                <td>{{ ucfirst($type) }}</td>
                                <td>{{ $topMonth[$type]['username'] ?? 'Nobody' }}</td>
                                <td>{{ $topMonth[$type]['points'] ?? 0 }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="text-center">
                    <h4 class="mb-8">Total top consumers</h4>
                    <table class="w-full table-fixed">
                        <thead>
                        <tr>
                            <th>Category</th>
                            <th>Leader</th>
                            <th>Count</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach (['coffee', 'wildkraut', 'energydrink', 'coke'] as $type)
                            <tr>
                                <td>{{ ucfirst($type) }}</td>
                                <td>{{ $topTotal[$type]['username'] ?? 'Nobody' }}</td>
                                <td>{{ $topTotal[$type]['points'] ?? 0 }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout.drawer>

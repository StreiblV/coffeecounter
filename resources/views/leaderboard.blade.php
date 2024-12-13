<x-layout.drawer>
    <div class="flex flex-row flex-wrap w-full">
        <div class="w-full">

            <div class="card">
                <div class="text-center">
                    <h4 class="mb-8">Today's Top Energy Level</h4>
                    <table class="w-full table-fixed border-collapse">
                        <thead>
                        <tr>
                            <th>Rank</th>
                            <th>User</th>
                            <th>Energy Level</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($top10EnergyToday as $index => $entry)
                            <tr>
                                <td>{{ $entry->rank }}</td>
                                <td>{{ $entry->user }}</td>
                                <td>{{ $entry->energy_level }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="text-center">
                    <h4 class="mb-8">Top Energy Level</h4>
                    <table class="w-full table-fixed border-collapse">
                        <thead>
                        <tr>
                            <th>Period</th>
                            <th>User</th>
                            <th>Energy Level</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Today</td>
                            <td>{{ $topEnergyToday['user'] }}</td>
                            <td>{{ $topEnergyToday['energy_level'] }}</td>
                        </tr>
                        <tr>
                            <td>Average Monthly</td>
                            <td>{{ $topEnergyMonthly['user'] }}</td>
                            <td>{{ $topEnergyMonthly['avg_energy_level'] }}</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>{{ $topEnergyTotal['user'] }}</td>
                            <td>{{ $topEnergyTotal['total_energy_level'] }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="text-center">
                    <h4 class="mb-8">Top Consumer</h4>
                    <!-- Table for Large Screens -->
                    <div class="hidden md:block">
                        <table class="w-full table-fixed">
                            <thead>
                            <tr>
                                <th>Category</th>
                                <th>Today</th>
                                <th>Monthly</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Coffee</td>
                                <td>
                                    {{ $topToday['coffee']['username'] ?? 'Nobody' }}<br>
                                    {{ $topToday['coffee']['points'] ?? 0 }}
                                </td>
                                <td>
                                    {{ $topMonth['coffee']['username'] ?? 'Nobody' }}<br>
                                    {{ $topMonth['coffee']['points'] ?? 0 }}
                                </td>
                                <td>
                                    {{ $topTotal['coffee']['username'] ?? 'Nobody' }}<br>
                                    {{ $topTotal['coffee']['points'] ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <td>Wildkraut</td>
                                <td>
                                    {{ $topToday['wildkraut']['username'] ?? 'Nobody' }}<br>
                                    {{ $topToday['wildkraut']['points'] ?? 0 }}
                                </td>
                                <td>
                                    {{ $topMonth['wildkraut']['username'] ?? 'Nobody' }}<br>
                                    {{ $topMonth['wildkraut']['points'] ?? 0 }}
                                </td>
                                <td>
                                    {{ $topTotal['wildkraut']['username'] ?? 'Nobody' }}<br>
                                    {{ $topTotal['wildkraut']['points'] ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <td>Energy Drink</td>
                                <td>
                                    {{ $topToday['energydrink']['username'] ?? 'Nobody' }}<br>
                                    {{ $topToday['energydrink']['points'] ?? 0 }}
                                </td>
                                <td>
                                    {{ $topMonth['energydrink']['username'] ?? 'Nobody' }}<br>
                                    {{ $topMonth['energydrink']['points'] ?? 0 }}
                                </td>
                                <td>
                                    {{ $topTotal['energydrink']['username'] ?? 'Nobody' }}<br>
                                    {{ $topTotal['energydrink']['points'] ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <td>Coke</td>
                                <td>
                                    {{ $topToday['coke']['username'] ?? 'Nobody' }}<br>
                                    {{ $topToday['coke']['points'] ?? 0 }}
                                </td>
                                <td>
                                    {{ $topMonth['coke']['username'] ?? 'Nobody' }}<br>
                                    {{ $topMonth['coke']['points'] ?? 0 }}
                                </td>
                                <td>
                                    {{ $topTotal['coke']['username'] ?? 'Nobody' }}<br>
                                    {{ $topTotal['coke']['points'] ?? 0 }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Responsive Cards for Small Screens -->
                    <div class="block sm:hidden">
                        @foreach (['coffee', 'wildkraut', 'energydrink', 'coke'] as $type)
                            <div class="category-section mb-6">
                                <h5 class="font-bold text-lg">{{ ucfirst($type) }}</h5>
                                <table class="w-full table-fixed">
                                    <tbody>
                                    <tr>
                                        <td><b>Today</b></td>
                                        <td class="break-words max-w-[150px] px-2">{{ $topToday[$type]['username'] ?? 'Nobody' }}</td>
                                        <td>{{ $topToday[$type]['points'] ?? 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Monthly</b></td>
                                        <td class="break-words max-w-[150px] px-2">{{ $topMonth[$type]['username'] ?? 'Nobody' }}</td>
                                        <td>{{ $topMonth[$type]['points'] ?? 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Total</b></td>
                                        <td class="break-words max-w-[150px] px-2">{{ $topTotal[$type]['username'] ?? 'Nobody' }}</td>
                                        <td>{{ $topTotal[$type]['points'] ?? 0 }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layout.drawer>

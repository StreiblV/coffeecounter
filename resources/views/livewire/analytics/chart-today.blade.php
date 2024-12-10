<div>
    <canvas id="chart-today" class="w-full h-full"></canvas>

    <script>
        (() => {
            const style = getComputedStyle(document.body);
            const data = {
                labels: @json($data->map(fn($data) => $data->date)),
                datasets: [{
                    label: 'Consumed today',
                    backgroundColor: style.getPropertyValue("--color-background"),
                    borderColor: style.getPropertyValue("--color-background-primary"),
                    data: @json($data->map(fn($data) => $data->aggregate)),
                }]
            };
            const config = {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            };

            const chartToday = new Chart(
                document.getElementById('chart-today'),
                config // We'll add the configuration details later.
            );
        })();
    </script>
</div>
<div>
    <canvas id="chart-thirty-days" class="w-full h-full"></canvas>

    <script>
        ( () => {
            const style = getComputedStyle(document.body);
            const data = {
                labels: @json($data->map(fn($data) => $data->date)),
                datasets: [{
                    label: 'Consumed during the last 30 days',
                    backgroundColor: style.getPropertyValue("--color-background"),
                    borderColor: style.getPropertyValue("--color-background-primary"),
                    data: @json($data->map(fn($data) => $data->aggregate)),
                }],             
            };
            const config = {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            };

            const chartToday = new Chart(
                document.getElementById('chart-thirty-days'),
                config // We'll add the configuration details later.
            );
        })();
    </script>
</div>

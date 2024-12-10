<div>
    <canvas id="chart-ratio" class="w-full h-full"></canvas>

    <script>
        (() => {
            const style = getComputedStyle(document.body);
            const data = {
                labels: @json($data->map(fn($data) => $data->type)),
                datasets: [{
                    label: 'Consumed today',
                    backgroundColor: [
                        style.getPropertyValue("--color-brown-light"),
                        style.getPropertyValue("--color-brown"),
                        style.getPropertyValue("--color-brown-dark"),
                        style.getPropertyValue("--color-beige"),
                        style.getPropertyValue("--color-beige-dark"),
                    ],
                    borderColor: style.getPropertyValue("--color-background-primary"),
                    data: @json($data->map(fn($data) => $data->aggregate)),
                }]
            };
            const config = {
                type: 'pie',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            };

            const chartToday = new Chart(
                document.getElementById('chart-ratio'),
                config // We'll add the configuration details later.
            );
        })();
    </script>
</div>
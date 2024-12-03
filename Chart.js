options: {
    responsive: true,
    maintainAspectRatio: false, // Allow the chart to use the container's height
    scales: {
        x: {
            title: {
                display: true,
                text: 'Time (HH:mm)'
            },
            ticks: {
                autoSkip: true,
                maxTicksLimit: 10 // Limit number of labels for readability
            }
        },
        y: {
            title: {
                display: true,
                text: 'Number of Cups'
            },
            beginAtZero: true
        }
    }
}
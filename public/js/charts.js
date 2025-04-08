// Function to initialize a doughnut chart
function initDoughnutChart(chartId, labels, data, colors) {
    const ctx = document.getElementById(chartId).getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: colors,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
            },
        }
    });
}

// Function to initialize a bar chart
function initBarChart(chartId, labels, data, colors) {
    const ctx = document.getElementById(chartId).getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Events Created',
                data: data,
                backgroundColor: colors,
                borderColor: '#ffffff',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: {
                            size: 14,
                        },
                    },
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.raw} events`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Organizers',
                        font: {
                            size: 16,
                        },
                    },
                    ticks: {
                        font: {
                            size: 12,
                        },
                    },
                    grid: {
                        display: false, // Hide grid lines on the x-axis
                    },
                },
                y: {
                    title: {
                        display: true,
                        text: 'Number of Events',
                        font: {
                            size: 16,
                        },
                    },
                    ticks: {
                        stepSize: 1, // Ensure the y-axis increments by 1
                        font: {
                            size: 12,
                        },
                    },
                    grid: {
                        color: '#e9ecef', // Light grid lines for better readability
                    },
                },
            },
        }
    });
}
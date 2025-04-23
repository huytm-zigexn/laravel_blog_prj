<div>
    <h2 class="text-center">Post Views</h2>
    @include('partials.adminWeekMonthYearFilter', ['prefix' => 'postView'])
    <canvas style="width: 1200px; max-width: 1200px; max-height: 300px; margin: auto; display: flex; justify-content: center" id="postViewsChart"></canvas>    
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let postViewsChart;
    
    document.addEventListener('livewire:init', () => {
        Livewire.on('updatePostViewsChart', ({labels, data}) => {
            const ctx = document.getElementById('postViewsChart').getContext('2d');
            // Delete old chart if exists
            if (postViewsChart) {
                postViewsChart.destroy();
            }
            
            postViewsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Post Views',
                        data: data,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    });
</script>




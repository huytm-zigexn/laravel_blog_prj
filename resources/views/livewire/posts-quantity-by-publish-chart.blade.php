<div style="margin-bottom: 100px" class="row">
    <h2 style="font-weight: 500" class="text-center">Posts quantity by publish date</h2>
    @include('partials.adminWeekMonthYearFilter', ['prefix' => 'postPublish'])
    <canvas id="postPublishChart" width="400" height="100"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let postPublishChart;
    
    document.addEventListener('livewire:init', () => {
        Livewire.on('updatePostPublishChart', ({labels, data}) => {
            const ctx = document.getElementById('postPublishChart').getContext('2d');
            // Delete old chart if exists
            if (postPublishChart) {
                postPublishChart.destroy();
            }
            
            postPublishChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Post Quantity by Publish Date',
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
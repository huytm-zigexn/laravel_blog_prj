<div style="margin-bottom: 100px" class="row" wire:poll.100s>
    <h2 style="font-weight: 500" class="text-center mb-4">Top 10 Posts by Likes and Comments</h2>
    <canvas id="engagementChart" height="250"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const postEngagement = document.getElementById('engagementChart').getContext('2d');
    document.addEventListener('livewire:init', () => {
        Livewire.on('updateTop10PostsChart', ({titles, comments, likes}) => {
            const postEngagementChart = new Chart(postEngagement, {
                type: 'bar',
                data: {
                    labels: titles,
                    datasets: [
                        {
                            label: 'Comments',
                            data: comments,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)'
                        },
                        {
                            label: 'Likes',
                            data: likes,
                            backgroundColor: 'rgba(255, 99, 132, 0.6)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    });
</script>
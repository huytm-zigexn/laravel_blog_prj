<div style="margin-bottom: 100px" class="row">
    <h2 style="font-weight: 500" class="text-center">Users quantity</h2>

    <div wire:poll.100s style="display: none" id="userQuantityPoller"></div>
    
    <canvas style="margin: auto; max-width: 500px; max-height: 500px; min-width: 500px; min-height: 500px" id="usersPieChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let usersPieChart;

    document.addEventListener('livewire:init', () => {
        Livewire.on('updateUsersQuantityChart', ({labels, data}) => {
            const ctx = document.getElementById('usersPieChart').getContext('2d');
            if (usersPieChart) {
                usersPieChart.destroy();
            }
            usersPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'users quantity',
                        data: data,
                        backgroundColor: [
                            '#ff6384', '#36a2eb', '#cc65fe', '#ffce56', '#4bc0c0',
                            '#9966ff', '#ff9f40', '#e7e9ed'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true
                }
            });
        });
    });
</script>
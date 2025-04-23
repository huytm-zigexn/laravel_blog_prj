<div>
    <h2 class="text-center">Users Quantity by Filter</h2>
    @include('partials.adminWeekMonthYearFilter', ['prefix' => 'userQuantity'])
    <canvas style="width: 1200px; max-width: 1200px; max-height: 300px; margin: auto; display: flex; justify-content: center" id="usersQuantityChart"></canvas>    
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let usersQuantityChart;
    
    document.addEventListener('livewire:init', () => {
        Livewire.on('updateUsersQuantityFilterChart', ({labels, data}) => {
            const ctx = document.getElementById('usersQuantityChart').getContext('2d');
            // Delete old chart if exists
            if (usersQuantityChart) {
                usersQuantityChart.destroy();
            }
            
            usersQuantityChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Users Quantity',
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




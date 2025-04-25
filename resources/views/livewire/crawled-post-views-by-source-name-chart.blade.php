<div>
    <h2 class="text-center">Crawled Post Views</h2>
    @include('partials.adminWeekMonthYearFilter', ['prefix' => 'crawledPostView'])
    <canvas style="width: 1200px; max-width: 1200px; max-height: 300px; margin: auto; display: flex; justify-content: center" id="crawledPostViewsChart"></canvas>    
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let crawledPostViewsChart;
    
    window.addEventListener('updateCrawledPostViewsChart', event => {
        const rawData = event.detail.chartData;
        
        const labels = Object.keys(rawData);
        
        const sources = Array.from(new Set(
            labels.flatMap(date => Object.keys(rawData[date]))
        ));

        const datasets = sources.map(source => {
            return {
                label: source,
                data: labels.map(date => rawData[date][source] || 0),
                backgroundColor: getRandomColor(),
                stack: 'stack1',
            };
        });

        const ctx = document.getElementById('crawledPostViewsChart').getContext('2d');

        if (crawledPostViewsChart) {
            crawledPostViewsChart.destroy();
        }

        crawledPostViewsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: datasets,
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                    },
                },
            },
        });
    });

    function getRandomColor() {
        const colors = [
            '#4e79a7', '#f28e2c', '#e15759', '#76b7b2', '#59a14f',
            '#edc949', '#af7aa1', '#ff9da7', '#9c755f', '#bab0ab'
        ];
        return colors[Math.floor(Math.random() * colors.length)];
    }
</script>




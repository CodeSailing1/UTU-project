document.addEventListener('DOMContentLoaded', (event) => {
    const ctx = document.getElementById('productosVendidos');
    const URL_RANKING_USUARIOS = '/UTU-project/logica/empresas/rankingProductosMasVendidosEmpresas.php';
    let chart;

    const getData = async (url) => {
        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Fetch error:', error);
        }
    }

    const createChart = (data) => {
        if (chart) {
            chart.destroy(); // Destruye el gráfico anterior
        }
        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(row => row.nombreProducto),
                datasets: [{
                    label: 'Ventas',
                    data: data.map(row => row.ventasProducto),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    const updateChart = async () => {
        let result = await getData(URL_RANKING_USUARIOS);
        if (result) {
            console.log(result);
            createChart(result);
        }
    }

    updateChart(); // Llama a la función una vez al cargar la página
    setInterval(updateChart, 30000); // Actualiza cada 30 segundos
});

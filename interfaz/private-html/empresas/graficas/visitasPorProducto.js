document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('visitasPorProductos');
    const URL_RANKING_MENOS = '/UTU-project/logica/empresas/visitasPorProducto.php';

    const getData = async (url) => {
        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return await response.json();
        } catch (error) {
            console.error('Fetch error:', error);
        }
    };

    const chart = async () => {
        const result = await getData(URL_RANKING_MENOS);

        if (result) {
            console.log(result);
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: result.map(row => row.nombreProducto),
                    datasets: [{
                        label: 'Visitas',
                        data: result.map(row => row.visitasProducto),
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'], // Colores opcionales
                    }]
                }
            });
        }
    };

    // Carga inicial del gráfico
    chart();

    // Actualiza el gráfico cada 30 segundos
    setInterval(chart, 30000); // Cambia el intervalo si es necesario
});

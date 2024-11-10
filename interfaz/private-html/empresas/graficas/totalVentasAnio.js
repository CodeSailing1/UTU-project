document.addEventListener('DOMContentLoaded', (event) => {
    const ctx = document.getElementById('ventasPorAnio');
    console.log(ctx);
    const URL_RANKING_MENOS = '/UTU-project/logica/empresas/totalVentasAnio.php';

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
                type: 'line',
                data: {
                    labels: result.map(row => row.mes),
                    datasets: [{
                        label: 'Ventas',
                        data: result.map(row => row.totalVentas),
                        borderColor: '#36A2EB', // Color de la línea
                        fill: false // No llenar debajo de la línea
                    }]
                },
                options: {
                    responsive: true,

                }
            });
        }
    };

    // Carga inicial del gráfico
    chart();

    // Actualiza el gráfico cada 30 segundos
    setInterval(chart, 30000); // Cambia el intervalo si es necesario
});

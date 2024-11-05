document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('personasFieles');
    const URL_RANKING_USUARIOS = '/UTU-project/logica/empresas/personasMasFieles.php';

    const getData = async () => {
        try {
            const response = await fetch(URL_RANKING_USUARIOS);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return await response.json();
        } catch (error) {
            console.error('Fetch error:', error);
        }
    };

    const updateChart = async () => {
        const result = await getData();
        if (result) {
            const data = {
                labels: result.map(row => row.nombreUsuario),
                datasets: [{
                    label: 'Visitas',
                    data: result.map(row => row.visitas),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                }]
            };

            // Dibuja el gráfico
            new Chart(ctx, {
                type: 'doughnut',
                data: data,
            });
        }
    };

    // Carga inicial del gráfico
    updateChart();

    // Actualiza el gráfico cada 30 segundos
    setInterval(updateChart, 30000); // Cambia el intervalo según necesites
});

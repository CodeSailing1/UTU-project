document.addEventListener('DOMContentLoaded', (event) => {
    const ctx = document.getElementById('ventasMes');
    const URL_VENTAS_EMPRESAS_MES = '/UTU-project/logica/backoffice/ventasEmpresasMes.php';

    const getDataMes = async (url) => {
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

    const chart = async () => {
        let resultMes = await getDataMes(URL_VENTAS_EMPRESAS_MES);

        if (resultMes) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: resultMes.map(row => row.nombreEmpresa),
                    datasets: [
                        {
                            label: 'Ventas por mes',
                            data: resultMes.map(row => row.totalVentas)
                        }
                    ]
                }
            }


            );
        }
    }

    chart();
});

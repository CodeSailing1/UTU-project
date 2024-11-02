document.addEventListener('DOMContentLoaded', (event) => {
    const ctx = document.getElementById('myChart');
    const URL_VENTAS_EMPRESAS = '/UTU-project/logica/backoffice/ventasEmpresasAnio.php';
    const URL_VENTAS_EMPRESAS_MES = '/UTU-project/logica/backoffice/ventasEmpresasMes.php';

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
        let result = await getData(URL_VENTAS_EMPRESAS);
        let resultMes = await getDataMes(URL_VENTAS_EMPRESAS_MES);

        if (result) {
            console.log(result);
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: result.map(row => row.nombreEmpresa),
                    datasets: [
                        {
                            label: 'Acquisitions by year',
                            data: result.map(row => row.totalVentas)
                        },
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

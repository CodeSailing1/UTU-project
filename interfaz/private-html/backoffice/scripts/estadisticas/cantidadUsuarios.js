document.addEventListener('DOMContentLoaded', (event) => {
    const ctx = document.getElementById('usuariosChart');
    const URL_CANTIDAD_USUARIOS = '/UTU-project/logica/backoffice/cantidadUsuarios.php';

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

    const chart = async () => {
        let result = await getData(URL_CANTIDAD_USUARIOS);

        if (result) {
            console.log(result);
            new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: result.map(row => row.tipo),
                        datasets: [
                            {
                                label: 'Activos',
                                data: result.map(row => row.Activo)
                            },
                            {
                                label: 'Inactivos',
                                data: result.map(row => row.Inactivo)
                            },
                            {
                                label: 'Totales',
                                data: result.map(row => row.Total)
                            }
                        ],

                    }
                }


            );
        }
    }

    chart();


});

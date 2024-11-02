document.addEventListener('DOMContentLoaded', (event) => {
    const ctx = document.getElementById('comprasUsuario');
    const URL_RANKING_USUARIOS = '/UTU-project/logica/backoffice/rankingComprasUsuario.php';

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
        let result = await getData(URL_RANKING_USUARIOS);

        if (result) {
            console.log(result);
            new Chart(ctx, {
                type: 'bar',
                    data: {

                        labels:  result.map(row => row.nombreUsuario),
                        datasets: [{
                            label: 'Bar Dataset',
                            data: result.map(row => row.cantidad),

                        }]
                    }

                }


            );
        }
    }

    chart();
});

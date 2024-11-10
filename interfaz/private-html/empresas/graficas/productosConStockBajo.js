document.addEventListener('DOMContentLoaded', () => {
    const URL_SHOW_HISTORIAL = '/UTU-project/logica/empresas/productosConMenosStock.php';
    const historial = document.getElementById('stock');

    const fetchData = async () => {
        try {
            const response = await fetch(URL_SHOW_HISTORIAL);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const data = await response.json();
            // Limpiar la tabla antes de agregar nuevos datos
            historial.innerHTML = '';
            data.forEach(element => {
                const murkUp = `
                    <tr class="py-5 border-bottom">
                        <td>${element.nombreProducto}</td>
                        <td>${element.idProducto}</td>
                        <td>${element.stock == null ? 0 : element.stock}</td>
                    </tr>
                `;
                historial.insertAdjacentHTML('beforeend', murkUp);
            });
        } catch (error) {
            console.error('Fetch error:', error);
            historial.innerHTML = '<tr><td colspan="3">Error al cargar los datos.</td></tr>';
        }
    };

    // Fetch initial data
    fetchData();

    // Update data every 30 seconds (30000 milliseconds)
    setInterval(fetchData, 30000); // Cambia 30000 a cualquier intervalo en milisegundos que desees
});

document.addEventListener('DOMContentLoaded', () => {
    const URL_SHOW_HISTORIAL = '/UTU-project/logica/empresas/comentariosMasRecientes.php';
    const historial = document.getElementById('comentariosRecientes');

    const fetchStockData = async () => {
        try {
            const response = await fetch(URL_SHOW_HISTORIAL);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const data = await response.json();
            updateStockDisplay(data);
        } catch (error) {
            console.error('Fetch error:', error);
        }
    };

    const updateStockDisplay = (data) => {
        historial.innerHTML = ''; // Limpiar contenido anterior
        data.forEach(comment => {
            const murkUp = `
                <article class="bg-body-tertiary rounded-2 p-2 my-2 " heigth="1000px" width="100px">
                <a href="/UTU-project/interfaz/public-html/producto.php?id=${comment.idProducto}" style="text-decoration: none "><h2>${comment.nombreProducto}</h2></a>
                <h5>${comment.nombreUsuario}</h5>
                    <p class="text-break">${comment.textoComentario}</p>
                    <span>${comment.fechaComentario}</span>
                </article>
            `;
            historial.insertAdjacentHTML('beforeend', murkUp);
        });
    };

    // Cargar datos inicialmente
    fetchStockData();

    // Actualizar los datos cada 30 segundos
    setInterval(fetchStockData, 30000); // Cambia el intervalo si es necesario
});

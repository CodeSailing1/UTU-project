document.addEventListener('DOMContentLoaded', () => {
    const URL_SHOW_HISTORIAL = '/UTU-project/logica/historial/showHistorial.php';
    const historial = document.getElementById('history');
    fetch(URL_SHOW_HISTORIAL)
        .then(response => response.json())
        .then(data => {
            data.forEach(element => {
                const murkUp = `
                    <tr class="py-5 border-bottom">
                        <td><a href="#" class="imgClickeable" id="${element.idProducto}"><img src="/UTU-project/persistencia/assets/${element.imagenProducto}" height="100px" "></a></td>
                        <td>${element.nombreProducto}</td>
                        <td>${element.cantidad == null ? 1 : element.cantidad}</td>
                        <td>${element.precioCompra == null ? 0 : element.precioCompra}</td>
                        <td>${element.productoHistorial}</td>
                        <td>${element.tipo}</td>

                    </tr>
            `;
                historial.insertAdjacentHTML('beforeend', murkUp);
            });
        })
})
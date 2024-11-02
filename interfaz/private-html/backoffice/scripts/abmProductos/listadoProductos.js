
document.addEventListener('DOMContentLoaded', () => {
    fetch('/UTU-project/logica/productos/showAllProducts.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            const productsContainer = document.getElementById("listado");

            data.forEach(element => {

                const template = `
            <tr class="py-5 border-bottom border rounded m-5">
                        <td><a href="#" class="imgClickeable" id="${element.idProducto}"><img src="/UTU-project/persistencia/assets/${element.imagenProducto}" height="100px" "></a></td>
                        <td>${element.idProducto}</td>
                        <td>${element.nombreProducto}</td>
                        <td>${element.stock == null || element.stock === 0 ? 1 : element.stock}</td>
                        <td>${element.precioProducto == null ? 0 : element.precioProducto}</td>
                        <td>${element.categoriaProducto}</td>
                        <td>${element.fechaProducto}</td>
                        <td>${element.valoracionProducto}</td>
                        <td>${element.visitasProducto}</td>
                        <td>${element.ventasProducto}</td>
                        <td>${element.inactivoProducto == 0 ? 'false' : 'true'}</td>
                        <td>${element.nombreEmpresa}</td>

                    </tr>
            `;
                productsContainer.insertAdjacentHTML('beforeend', template);

            });
        })
})
document.addEventListener('DOMContentLoaded', () => {
    const URL_API_SHOW = '/UTU-project/logica/inventario/showInventario.php';
    fetch(URL_API_SHOW)
    .then(response=> response.json())
    .then(data => {
        data.forEach(product => {
            const productsContainer = document.getElementById('productsContainer');
            const item = document.createElement("div");
                item.classList.add("contenedor");
                item.classList.add("col");
                const template = `
                <div class="swiper-slide product col gap-2" id="${product.idProducto}">
                <div class="card" style="width: 16rem;">
            <a href="#" class="imgClickeable" id="${product.idProducto}" >
                    <img src="/UTU-project/persistencia/assets/${product.imagenProducto}" class="card-img-top "  " style="height:200px;" alt="...">
            </a>
                <div class="card-body">
                        <h4>${product.nombreProducto}</h2>
                        <h5>${product.precioProducto}</h4>
                        <p class="card-text">${product.descripcionProducto}</p>
                        <button class="btn btn-outline-success me-2 addCart" id="${product.idProducto}">Add to Cart</button>
                    </div>
                </div>
            </div> `;
                item.innerHTML = template;
                productsContainer.appendChild(item);
        });
    })
})
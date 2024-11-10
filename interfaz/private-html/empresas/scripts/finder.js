document.addEventListener('DOMContentLoaded', () => {

    let params = new URLSearchParams(location.search);

    let query = params.get('searchTerm');

    const url = new URL('/UTU-project/logica/productos/finderEmpresas.php', location.origin);
    url.searchParams.set('searchTerm', query);
    const observer = new MutationObserver(() => {
        if (window.location.href !== "http://localhost/UTU-project/interfaz/private-html/inventario.php"){
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const productsContainer = document.getElementById("productContainer");
                    productsContainer.innerHTML = '';
                    data.forEach(product => {
                        const item = document.createElement("div");
                        item.classList.add("contenedor");
                        item.classList.add("col");
                        item.innerHTML = `
                            <div class="swiper-slide product col gap-2" id="${product.idProducto}">
                <div class="card" style="width: 16rem;">
            <a href="#" class="imgClickeable" id="${product.idProducto}" >
                    <img src="/UTU-project/persistencia/assets/${product.imagenProducto}" class="card-img-top "  style="height:200px;" alt="...">
            </a>
                <div class="card-body">
                        <h4>${product.nombreProducto}</h2>
                        <h5>${product.precioProducto}</h4>
                        <p class="card-text">${product.descripcionProducto}</p>
                        <div class="d-flex justify-content-between">
                            <a type="button" href="./abm/modificarEmpresas.php?idProducto=${product.idProducto}" class="btn btn-outline-success me-2 addCart" >Modify</a>
                            ${
                            product.inactivoProducto == 1 ?
                                `<a type="button" href="./abm/activarEmpresas.php?idProducto=${product.idProducto}" id="${product.idProducto}" class="btn btn-outline-success me-2 addCart ">Activate</a>` :
                                `<a type="button" href="./abm/eliminarEmpresas.php?idProducto=${product.idProducto}" class="btn btn-outline-success me-2 addCart ">Delete</a>`
                        }
                        </div>
                    </div>
                </div>
            </div>`;
                        productsContainer.appendChild(item);
                    });
                })
        }
        observer.disconnect();
    })
    observer.observe(document.body, { childList: true, subtree: true });

})
document.addEventListener('DOMContentLoaded', () => {

    let params = new URLSearchParams(location.search);
    
    let query = params.get('idProducto');
    
    const url = new URL('/UTU-project/logica/productos/finderById.php', location.origin);
    url.searchParams.set('idProducto', query);
    let searchTerm = url.searchParams.get('idProducto');
    if(searchTerm == null || searchTerm === '') {
        window.location.href = `../abm/modificarEmpresas.php`;
        return;
    }
console.log( url.searchParams.get('idProducto'));
        if(window.location.href != 'http://localhost/UTU-project/interfaz/private-html/empresas/abm/modificarEmpresas.php'){
            fetch(url)
        .then(response => response.json())
        .then(data => {
            const productsContainer = document.getElementById("products");
            productsContainer.innerHTML = '';
                const item = document.createElement("div");
                item.classList.add("contenedor");
                item.classList.add("col");
                const template = `
                <div class="card product col m-1" style="width: 18rem;" id="${data.idProducto}">
                    <img src="/UTU-project/persistencia/assets/${data.imagenProducto}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h2>${data.nombreProducto}</h2>
                                                <p class="card-text">${product.descripcionProducto}</p>

                        <button class="btn btn-outline-success me-2 modificar" id="${data.idProducto}" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Modify product</button>
                    </div>
                </div> `;
                item.innerHTML = template;
                productsContainer.appendChild(item);
        });
        } else {
        fetch('/UTU-project/logica/inventario/showInventario.php')
        .then(response => response.json())
        .then(data => {
            const productsContainer = document.getElementById("products");
            productsContainer.innerHTML = '';
            data.forEach(product => {
                const item = document.createElement("div");
                item.classList.add("contenedor");
                item.classList.add("col");
                const template = `
                <div class="card product col m-1" style="width: 18rem;" id="${product.idProducto}">
                    <img src="/UTU-project/persistencia/assets/${product.imagenProducto}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h2>${product.nombreProducto}</h2>
                                                <p class="card-text">${product.descripcionProducto}</p>

                        <button class="btn btn-outline-success me-2 modificar" id="${product.idProducto}" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Modify product</button>
                    </div>
                </div> `;
                item.innerHTML = template;
                productsContainer.appendChild(item);
            });
        });
    }

})
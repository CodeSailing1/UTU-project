    document.addEventListener('DOMContentLoaded', () => {

        let params = new URLSearchParams(location.search);
        
        let query = params.get('searchTerm');
        
        const url = new URL('/UTU-project/logica/productos/finder.php', location.origin);
        url.searchParams.set('searchTerm', query);
        const observer = new MutationObserver(() => {
            if (window.location.href !== "http://localhost/UTU-project/interfaz/public-html/finder.php"){
                fetch(url)
                .then(response => response.json())
                .then(data => {
                    const productsContainer = document.getElementById("products");
                    productsContainer.innerHTML = '';
                    data.forEach(product => {
                        const item = document.createElement("div");
                        item.classList.add("contenedor");
                        item.classList.add("col");
                        item.innerHTML = `
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
            </div>`;
                        productsContainer.appendChild(item);
                    });
                })
            }
            else{
                const urlAll = '/UTU-project/logica/productos/showProducts.php';
                fetch(urlAll)
                .then(response => response.json())
                .then(data => {
                    const productsContainer = document.getElementById("products");
                    productsContainer.innerHTML = '';
                    data.forEach(product => {
                        const item = document.createElement("div");
                        item.classList.add("contenedor");
                        item.classList.add("col");
                        item.innerHTML = `
                        <div class="card product" style="width: 18rem;" id="${product.idProducto}">
                            <a href="#" class="imgClickeable" id="${product.idProducto}">
                    <img src="/UTU-project/persistencia/assets/${product.imagenProducto}" class="card-img-top "  style="height:200px;" alt="imagen del producto">
            </a>
                            <div class="card-body">
                                <h2>${product.nombreProducto}</h2>
                                <h4>${product.precioProducto}</h4>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <button class="btn btn-outline-success me-2 addCart" id="${product.idProducto}">Add to Cart</button>
                            </div>
                        </div> `;
                        productsContainer.appendChild(item);
                    });
                })
            }
            observer.disconnect();
        })
    observer.observe(document.body, { childList: true, subtree: true });

    })
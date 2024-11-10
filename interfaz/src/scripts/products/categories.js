document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(location.search);
    const query = params.get('category');
  
    const url = new URL('/UTU-project/logica/productos/categoriaProductos.php', location.origin);
    url.searchParams.set('category', query);
  
    const productsContainer = document.getElementById("products");
  
    const fetchProducts = () => {
        fetch(url)
        .then(response => response.json())
        .then(data => {
          productsContainer.innerHTML = '';
  
          data.forEach(product => {
            const template = `
              <div class="swiper-slide product col gap-2" id="${product.idProducto}">
                <div class="card" style="width: 16rem;">
                    <a href="#" class="imgClickeable" id="${product.idProducto}">
                    <img src="/UTU-project/persistencia/assets/${product.imagenProducto}" class="card-img-top "  " style="height:200px;" alt="...">
            </a>
                    <div class="card-body">
                        <h4>${product.nombreProducto}</h2>
                        <h5>${product.precioProducto}</h4>
                        <p class="card-text">${product.descripcionProducto}</p>
                        <button class="btn btn-outline-success me-2 addCart" id="${product.idProducto}">Add to Cart</button>
                    </div>
                </div>
            </div>
            `;
            productsContainer.innerHTML += template;
          });
        });

    };
  
    const observer = new MutationObserver(() => {
      fetchProducts();
      observer.disconnect();
    });
    observer.observe(document.body, { childList: true, subtree: true });
  });
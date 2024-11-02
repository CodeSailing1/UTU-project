document.addEventListener('DOMContentLoaded', () => {
    const formulario = document.getElementById('finder');
    const inputField = document.getElementById('finderResult');

    let params = new URLSearchParams(location.search);
    
    let query = params.get('searchTerm');
    
    const url = new URL('/UTU-project/logica/finder.php', location.origin);
    url.searchParams.set('searchTerm', query);
    
    if (window.location.href != "http://localhost/UTU-project/interfaz/public-html/finder.php"){
        fetch(url)
        .then(response => response.json())
        .then(data => {
            const productsContainer = document.getElementById("products");
            productsContainer.innerHTML = '';
            data.forEach(product => {
                const item = document.createElement("div");
                item.classList.add("contenedor");
                const template = `
                <div class="product-image">
                    <h2>${product.nombreProducto}</h2>
                </div>
                <button id="${product.idProducto}">Add to Cart</button>
                `;
                item.innerHTML = template;
                productsContainer.appendChild(item);
            });
        })
    }
})
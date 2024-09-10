document.addEventListener('DOMContentLoaded', () => {
    fetch('/UTU-project/logica/showProducts.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    }) 
    .then(response => response.json())
    .then(data => {
        const productsContainer = document.getElementById("products");
            productsContainer.innerHTML = '';
            data.forEach(product => {
                const item = document.createElement("div");
                item.classList.add("contenedor");
                const template = `
                <div class="product-image product product">
                    <h2>${product.nombreProducto}</h2>
                </div>
                <button data-id="${product.idProducto}">Add to Cart</button>
                `;
                item.innerHTML = template;
                productsContainer.appendChild(item);
            });
    })

})
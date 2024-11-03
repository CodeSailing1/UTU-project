import { getPrice } from './showTotalPriceCarrito.js';
function getCart() {
    fetch('/UTU-project/logica/carritoDeCompras/showCart.php', {
        method: "GET",
    })
    .then(response => response.json())
    .then(cartProducts => {
        const cart = document.getElementById("productsCarrito");
        cart.innerHTML = '';
        cartProducts.forEach(product => {
            const markUp = `
                <div class="row justify-content-between align-items-center my-3">
                    <span class="d-none">${product.precioCompra}</span>
                    <img src="/UTU-project/persistencia/assets/${product.imagenProducto}" class="col" style="height:40px;">
                    <p class="col m-0">${product.nombreProducto}</p> 
                    <p class="col m-0">${product.precioProducto}</p>
                    <div class="col d-flex justify-content-center align-items-center p-0">
                        <a class="col btn btn-outline-success addCart" id="${product.idProducto}"><img src="/UTU-project/interfaz/src/img/svgs/plus-large-svgrepo-com.svg" style="height: 10px"></a>
                            <p class="col m-0" style="padding:10px">${product.cantidad}</p> 
                        <a class="col btn btn-outline-success removeCart" id="${product.idProducto}"><img src="/UTU-project/interfaz/src/img/svgs/minus-svgrepo-com.svg" style="height: 10px"></a>
                    </div>
                </div>
            `;
            cart.innerHTML += markUp;
        });
        getPrice();
    })
    .catch(error => {
        console.error('Error updating cart:', error);
        const cart = document.getElementById("productsCarrito");
        cart.innerHTML = '<li>Error loading cart. Please try again later.</li>';
    });
}

document.addEventListener("DOMContentLoaded", () => {
    getCart(); 
});

export { getCart };
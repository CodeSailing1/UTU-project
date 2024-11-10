import { getCart } from './showProductCarrito.js';
document.addEventListener("DOMContentLoaded", () => {
  const observer = new MutationObserver(() => {
    const products = document.querySelectorAll(".removeCart");
    const URL_API = '/UTU-project/logica/carritoDeCompras/deleteProductCarrito.php';

    if (products.length > 0) {
      products.forEach(product => {
        if (!product.hasAttribute('listener')) {
          let productId = product.getAttribute('id');
          product.setAttribute('listener', 'true');
          
          product.addEventListener('click', () => {
            fetch(URL_API, {
              method: "PUT",
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ idProducto: productId })
            })
            .then(response => response.json())
            .then(data => {
              if(data.success)
              {
                getCart();
              }
            })
            .catch(error => {
              console.error(error);
            });
          });
        }
      });
    }
  });
  observer.observe(document.body, { childList: true, subtree: true });
});
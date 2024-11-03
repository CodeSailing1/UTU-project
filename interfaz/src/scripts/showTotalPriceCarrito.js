
const price = document.getElementById('totalPrice');
function getPrice(){
    const URL_PRICE = '/UTU-project/logica/carritoDeCompras/costoTotalCarrito.php';
    fetch(URL_PRICE)
    .then(response => response.json())
    .then(data => {
        if(data.success){
            price.textContent = data.total;
        }        
            
    })
    .catch(error => {
        console.error(['error: ' + error]);
    })
}

export { getPrice };
function viewedProduct(idProducto){
    const URL_HISTORIAL = '/UTU-project/logica/historial/insertIntoHistorialVista.php';
    fetch(URL_HISTORIAL, {
        method: 'POST',
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            idProducto: idProducto
        })
    })
    .then(response=> response.json())
    .catch(error => {
        console.error(error);
    })
}
export { viewedProduct };
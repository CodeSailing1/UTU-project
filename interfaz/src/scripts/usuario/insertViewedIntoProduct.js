function viewedIntoProduct(idProducto){
    const URL_HISTORIAL = '/UTU-project/logica/historial/insertViewedIntoProducto.php';
    fetch(URL_HISTORIAL, {
        method: 'PUT',
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
export { viewedIntoProduct };
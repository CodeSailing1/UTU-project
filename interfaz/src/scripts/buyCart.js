document.addEventListener('DOMContentLoaded', () => {

    const button = document.getElementById("buyCart");
    const URL_PAYPAL = "/UTU-project/logica/paypal/paypalExecute.php";

    button.addEventListener("click", () => {
        const priceElement = document.getElementById("totalPrice");
        console.log(priceElement);
        const content = Math.round(parseInt(priceElement.textContent)/42.25);
        console.log(content);
        fetch(URL_PAYPAL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                amount: content, // Use the dynamic amount
                currency: 'USD', // Currency
                description: 'Compra de prueba' // Description
            })
        })
        .then(response => {
            // Check if the response is OK (status in the range 200-299)
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return response.json(); // Get the response as text
        })
        .then(data => {
            if (data.approvalUrl) {
                // Redirigir al usuario a PayPal para completar el pago
                window.location.href = data.approvalUrl;
            } else {
                console.error('Error al generar el pago:', data.error);
            }
        })
        .catch(error => console.error('Error in the request:', error));
    });
});
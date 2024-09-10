document.addEventListener('DOMContentLoaded', () => {
    const formulario = document.getElementById('finder');
    const inputField = document.getElementById('finderResult');

    formulario.addEventListener('submit', (e) => {
        e.preventDefault();
        const searchTerm = inputField.value.trim();

        if (!searchTerm) {
            console.log("Please enter a search term.");
            return;
        }

        fetch('/UTU-project/logica/finder.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ 
                nombre: searchTerm 
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(data => {
            
            try {
                const products = JSON.parse(data);
                const productsContainer = document.getElementById("products");
                productsContainer.innerHTML = '';
                for (let i = 0; i < products.length; i++) {
                    const product = products[i];
                    const item = document.createElement("div");
                    const template = `
                    <div class="product-image">
                        <h2>${product.nombre}</h2>
                    </div>
                    <button data-id="${product.id}">Add to Cart</button>
                    `;
                    item.innerHTML = template;
                    document.getElementById("products").appendChild(item);
                }
                
            } catch (error) {
                console.error("Error parsing data:", error);
            }
        })
        .catch(error => {
            console.error("Error fetching data:", error);
        })
    });
});
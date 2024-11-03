document.addEventListener('DOMContentLoaded', () => {
    const formulario = document.getElementById('finder');
    const inputField = document.getElementById('finderResult');

    formulario.addEventListener('submit', (e) => {
        e.preventDefault();
        const searchTerm = inputField.value.trim().toLowerCase();
        const url = new URL( window.location.href, window.location.href);
        url.searchParams.set('idProducto', searchTerm);
        window.location.href = url.href;
    });
});
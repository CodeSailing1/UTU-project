document.addEventListener('DOMContentLoaded', () => {
    const formulario = document.getElementById('finder');
    const inputField = document.getElementById('finderResult');

    formulario.addEventListener('submit', (e) => {
        e.preventDefault();

        const searchTerm = inputField.value.trim().toLowerCase();

            const url = new URL('/UTU-project/interfaz/private-html/empresas/inventario.php', window.location.href);
            url.searchParams.set('searchTerm', searchTerm);
            window.location.href = url.href;
    });
});
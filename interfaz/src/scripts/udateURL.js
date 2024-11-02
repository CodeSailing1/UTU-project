document.addEventListener('DOMContentLoaded', () => {
    const formulario = document.getElementById('finder');
    const inputField = document.getElementById('finderResult');

    formulario.addEventListener('submit', (e) => {
        e.preventDefault();
        const searchTerm = inputField.value.trim().toLowerCase();

        if (!searchTerm) {
            console.log("Please enter a search term.");
            return;
        }

        const url = '/UTU-project/interfaz/public-html/finder.php';
        const params = `?searchTerm=${searchTerm}`;
        window.location.href = `${url}${params}`;
    });
});
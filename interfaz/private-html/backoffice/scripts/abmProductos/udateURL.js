document.addEventListener('DOMContentLoaded', () => {
    const formulario = document.getElementById('finder');
    const inputField = document.getElementById('finderResult');
    const categories = document.querySelectorAll('body aside .list-group .category');
    let params = new URLSearchParams(location.search);
    let query = params.get('category');

    formulario.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const searchTerm = inputField.value.trim().toLowerCase();

        const currentUrl = new URL(window.location.href);
        if (query) {
            currentUrl.searchParams.set('searchTerm', searchTerm);
        } else {
            const url = new URL('/UTU-project/interfaz/public-html/finder.php', window.location.href);
            url.searchParams.set('searchTerm', searchTerm);
            window.location.href = url.href;
            return;
        }
        window.location.href = currentUrl.href;
    });

    categories.forEach(category => {
        category.addEventListener('click', () => {
            const categoryItem = category.textContent.trim().toLowerCase();
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('category', categoryItem);
            window.location.href = currentUrl.href;
        });
    });
});
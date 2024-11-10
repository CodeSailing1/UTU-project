const logout = document.getElementById('logout');
const URL_API = '/UTU-project/logica/empresas/logout.php';

if (logout) {
    logout.addEventListener('click', () => {
        fetch(URL_API)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    console.error('Logout failed:', data.error || 'Unknown error');
                }
            })
            .catch(error => {
                console.error('Error:', error.message || 'Unknown error');
            });
    });
}
const logout = document.getElementById('logout');
const PATH_URL = '/UTU-project/logica/logout.php';

if (logout) {
    logout.addEventListener('click', () => {
        fetch(PATH_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({login: true}) // Send an empty JSON object
        })
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
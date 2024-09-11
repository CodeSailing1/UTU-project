document.getElementById('file-input').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file && file.size <= 800 * 1024) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('user-avatar').src = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        alert('El archivo es demasiado grande o no es válido.');
    }
});

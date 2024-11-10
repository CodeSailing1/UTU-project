function showImage(){
    let uploadButton = document.getElementById('imagenEmpresas');
    uploadButton.addEventListener('change', (e)=>{
    const currFiles = e.target.files;
    if(currFiles.length > 0){
            let src = URL.createObjectURL(currFiles[0])
            let svg = document.getElementById('svg');
            let imagePreview = document.getElementById('file-preview')
            svg.style.display = "none";
            imagePreview.src = src
            imagePreview.style.display = "block"
        }
    })
}
export { showImage };
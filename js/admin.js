function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').style.display = 'flex';
        };
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    document.getElementById('image').value = ""; 
    document.getElementById('image-preview').style.display = 'none'; 
}
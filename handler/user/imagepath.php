<?php
    require_once '../../classes/userClass.php'; // Adjust path as needed
function getImagePath(imagePath) {
    // Check if the image path is valid; otherwise, return a default image
    return imagePath && imagePath.trim() !== '' 
        ? imagePath 
        : '../../assets/updates/default-image.jpg';
}


?>
<?php
require_once '../../tools/function.php';
require_once '../../classes/userClass.php';

session_start();

$username = $password = '';
$userObj = new User(); // Use the User class instead of Admin
$programs = $userObj->fetchProgram(); // Fetch programs using User class
$first_name = $last_name = $middle_name = $year = $section = $program = $cor_file = $contact = $email = '';
$first_nameErr = $last_nameErr = $yearErr = $sectionErr = $programErr = $imageErr = $contactErr = $emailErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = clean_input($_POST['firstname']);
    $last_name = clean_input($_POST['lastname']);
    $middle_name = clean_input($_POST['middlename']);
    $year = clean_input($_POST['year']);
    $section = clean_input($_POST['section']);
    $contact = clean_input($_POST['contact']);
    $email = clean_input($_POST['email']);
    $program = clean_input($_POST['program']);

    if (empty($first_name)) {
        $first_nameErr = "First name is required!";
    }
    if (empty($last_name)) {
        $last_nameErr = "Last name is required!";
    }
    if (empty($program)) {
        $programErr = "Please enter course!";
    }
    if (empty($year)) {
        $yearErr = "Please enter year!";
    }
    if (empty($section)) {
        $sectionErr = "Please enter section!";
    }
    if (empty($contact)) {
        $contactErr = "Please enter contact number!";
    }
    if (empty($email)) {
        $emailErr = "Please enter email!";
    }

    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../../assets/cors/";
        
        if (!is_dir($target_dir) && !mkdir($target_dir, 0777, true)) {
            $imageErr = "Failed to create upload directory.";
        } else {
            $image_name = time() . "_" . basename($_FILES['image']['name']);
            $target_file = $target_dir . $image_name;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowed_types = ['jpg', 'jpeg', 'png'];
            $maxFileSize = 2 * 1024 * 1024; 
    
            if (!in_array($imageFileType, $allowed_types)) {
                $imageErr = "Only JPG, JPEG, & PNG files are allowed.";
            } elseif ($_FILES['image']['size'] > $maxFileSize) {
                $imageErr = "File size should not exceed 2MB.";
            } else {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $cor_file = $image_name; 
                } else {
                    $imageErr = "There was an error uploading your file.";
                }
            }
        }
    } elseif (isset($_POST['existing_image']) && !empty($_POST['existing_image'])) {
        $cor_file = $_POST['existing_image']; 
    } else {
        $imageErr = "Please upload your COR screenshot!";
    }
    
    if (empty($first_nameErr) && empty($last_nameErr) && empty($contactErr) && empty($emailErr) && empty($sectionErr) && empty($programErr) && empty($yearErr) && empty($imageErr)) {
        $userObj->first_name = $first_name;
        $userObj->last_name = $last_name;
        $userObj->middle_name = $middle_name;
        $userObj->year = $year;
        $userObj->section = $section;
        $userObj->program = $program;
        $userObj->contact = $contact;
        $userObj->email = $email;
        $userObj->cor_file = $cor_file;

        $userObj->addVolunteer(); // Use the User class method
        $_SESSION['registration_success'] = true; // Set success flag
        header("Location: volunteer.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Registration</title>
    <script src="../../js/admin.js"></script>
    <link rel="stylesheet" href="../../css/RegVolunteer.css">
    <?php include '../../includes/header.php'; ?>
</head>
<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" placeholder="First Name" value="<?= $first_name ?>">
        <span><p><?= $first_nameErr ?></p></span>
        <br>

        <label for="middlename">Middle Name:</label>
        <input type="text" id="middlename" name="middlename" placeholder="Middle Name" value="<?= $middle_name ?>">
        <br>

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" placeholder="Last Name" value="<?= $last_name ?>">
        <span><p><?= $last_nameErr ?></p></span>
        <br>

        <label for="program">Course:</label>
        <select id="program" name="program">
            <option value="">Select Program</option>
            <?php foreach ($programs as $prog): ?>
                <option value="<?= $prog['program_id'] ?>" <?= ($program == $prog['program_id']) ? 'selected' : '' ?>>
                    <?= clean_input($prog['program_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <span><p><?= $programErr ?></p></span>
        <br>

        <label for="year">Year Level:</label>
        <select id="year" name="year">
            <option value="">Select Year Level</option>
            <option value="1st Year" <?= ($year == "1st Year") ? 'selected' : '' ?>>1st Year</option>
            <option value="2nd Year" <?= ($year == "2nd Year") ? 'selected' : '' ?>>2nd Year</option>
            <option value="3rd Year" <?= ($year == "3rd Year") ? 'selected' : '' ?>>3rd Year</option>
            <option value="4th Year" <?= ($year == "4th Year") ? 'selected' : '' ?>>4th Year</option>
        </select>
        <span><p><?= $yearErr ?></p></span>
        <br>

        <label for="section">Section:</label>
        <input type="text" id="section" name="section" placeholder="Section" value="<?= $section ?>">
        <span><p><?= $sectionErr ?></p></span>
        <br>

        <label for="contact">Contact Number:</label>
        <input type="text" id="contact" name="contact" placeholder="Contact Number" value="<?= $contact ?>">
        <span><p><?= $contactErr ?></p></span>
        <br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Email" value="<?= $email ?>">
        <span><p><?= $emailErr ?></p></span>
        <br>
            <label for="image">Upload Picture:</label>
    <div class="upload-container">
        <div class="upload-area" id="upload-area" onclick="document.getElementById('image').click()">
            <div class="upload-placeholder" id="upload-placeholder">
                <img src="../../assets/icons/upload-icon.png" alt="Upload Icon" class="upload-icon">
                <p>Click to upload your COR screenshot</p>
                <p class="upload-hint">(Only JPG, JPEG, or PNG, max 2MB)</p>
            </div>
            <div class="image-preview" id="image-preview" style="display: none;">
                <img id="preview-img" src="#" alt="Image Preview">
                <button type="button" class="remove-image" onclick="removeImage()">x</button>
            </div>
        </div>
        <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)" style="display: none;">
        <input type="hidden" name="existing_image" value="<?= $cor_file ?>">
        <span><p><?= $imageErr ?></p></span>
    </div>

        <div class="button-container">
            <button type="button" class="back-button" onclick="window.location.href='volunteer.php'">Back</button>
            <button type="submit" class="sign-up-button">Sign Up</button>
        </div>
    </form>
    <?php include '../../includes/footer.php'; ?>
    <script src="../../js/regVolunteer.js"></script>
</body>
</html>
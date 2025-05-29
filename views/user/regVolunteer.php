<?php
require_once '../../tools/function.php';
require_once '../../classes/userClass.php';

// Debug code to check database connection
$diagnosis = [];
try {
    $userObj = new User();
    $diagnosis['connection'] = 'Database connection successful';
    
    // Test fetching colleges
    $colleges = $userObj->fetchColleges();
    $diagnosis['colleges_count'] = count($colleges);
    $diagnosis['first_college'] = !empty($colleges) ? $colleges[0]['college_name'] : 'No colleges found';
    
    // Test fetching programs for a specific college (e.g., College of Computing Studies, ID 3)
    $testCollegeId = 3;
    $programs = $userObj->fetchProgramsByCollege($testCollegeId);
    $diagnosis['programs_count'] = count($programs);
    $diagnosis['first_program'] = !empty($programs) ? $programs[0]['program_name'] : 'No programs found';
    
    $diagnosis['status'] = 'OK';
} catch (Exception $e) {
    $diagnosis['status'] = 'ERROR';
    $diagnosis['error'] = $e->getMessage();
}

// Only display diagnostics if requested via query parameter
if (isset($_GET['debug']) && $_GET['debug'] === 'true') {
    echo '<pre>';
    print_r($diagnosis);
    echo '</pre>';
}

session_start();

$userObj = new User();
$colleges = $userObj->fetchColleges();
$programs = $userObj->fetchProgram();

// Debug - see structure of program data
// echo '<pre>'; print_r($programs); echo '</pre>';

$first_name = $last_name = $middle_name = $year = $program = $cor_file = $contact = $email = '';
$college_id = '';
$first_nameErr = $last_nameErr = $yearErr = $programErr = $imageErr = $contactErr = $emailErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = clean_input($_POST['firstname']);
    $last_name = clean_input($_POST['lastname']);
    $middle_name = clean_input($_POST['middlename']);
    $year = clean_input($_POST['year']);
    $contact = clean_input($_POST['contact']);
    $email = clean_input($_POST['email']);
    $program = clean_input($_POST['program']);
    $college_id = isset($_POST['college']) ? clean_input($_POST['college']) : '';

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
    if (empty($contact)) {
        $contactErr = "Please enter contact number!";
    }
    if (empty($email)) {
        $emailErr = "Please enter email!";
    }

    // Validate that program belongs to selected college
    if (!empty($program) && !empty($college_id)) {
        $programValid = false;
        foreach ($programs as $prog) {
            if ($prog['program_id'] == $program && $prog['college_id'] == $college_id) {
                $programValid = true;
                break;
            }
        }
        if (!$programValid) {
            $programErr = "Selected program does not belong to the selected college.";
        }
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
    
    if (empty($first_nameErr) && empty($last_nameErr) && empty($contactErr) && empty($emailErr) && empty($programErr) && empty($yearErr) && empty($imageErr)) {
        // Use parameters instead of properties
        $section = ''; // Add empty section since we removed the field
        $result = $userObj->addVolunteer($first_name, $last_name, $middle_name, $year, $section, $program, $contact, $email, $cor_file);
        
        if ($result) {
            // Ensure session is started
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            // Set session variables
            $_SESSION['volunteer_registration_success'] = true;
            $_SESSION['registration_type'] = 'volunteer';
            
            // Make sure session is written before redirect
            session_write_close();
            
            // Redirect with session in URL as a fallback
            header("Location: volunteer?registration_success=1");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Registration</title>
    <link rel="stylesheet" href="../../css/regVolunteer.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap" rel="stylesheet">
    <style>
        /* Updated validation error styling to match Registermadrasaform.php */
        .error-message {
            color: #b33a3a !important;
            font-size: 13px !important;
            display: block !important;
            margin-top: 5px !important;
            margin-bottom: 10px !important;
            font-style: italic !important;
            font-family: 'Noto Naskh Arabic', serif !important;
        }

        /* Style for invalid form elements */
        input.invalid, select.invalid {
            border: 1px solid #b33a3a !important;
            background-color: #fff !important;
        }

        /* Ensure consistent font family throughout the form */
        form, input, select, button, label {
            font-family: 'Noto Naskh Arabic', serif !important;
        }
    </style>
</head>
<body>
    <?php 
    // Include header content
    include '../../includes/header.php'; 
    ?>
    
    <form action="regVolunteer" method="POST" enctype="multipart/form-data" autocomplete="on" id="volunteerForm">
        <h2>Volunteer Registration Form</h2>
        <div class="form-columns">
            <!-- Left Column -->
            <div class="form-col">
                <div class="form-section">
                    <label for="firstname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" placeholder="First Name" value="<?= $first_name ?>" autocomplete="given-name">
                    <span class="error-message" id="firstname-error"></span>

                    <label for="middlename">Middle Name:</label>
                    <input type="text" id="middlename" name="middlename" placeholder="Middle Name" value="<?= $middle_name ?>" autocomplete="additional-name">
                    <span class="error-message" id="middlename-error"></span>

                    <label for="lastname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" placeholder="Last Name" value="<?= $last_name ?>" autocomplete="family-name">
                    <span class="error-message" id="lastname-error"></span>

                    <label for="college">College:</label>
                    <select id="college" name="college" autocomplete="organization" onchange="loadProgramsByCollege(this.value)">
                        <option value="">Select College</option>
                        <?php foreach ($colleges as $college): ?>
                            <option value="<?= $college['college_id'] ?>" <?= ($college_id == $college['college_id']) ? 'selected' : '' ?>>
                                <?= clean_input($college['college_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <span class="error-message" id="college-error"></span>

                    <label for="program">Program:</label>
                    <select id="program" name="program" autocomplete="off">
                        <option value="">Select College First</option>
                    </select>
                    <span class="error-message" id="program-error"></span>
                </div>
            </div>
            <!-- Right Column -->
            <div class="form-col">
                <div class="form-section">
                    <label for="year">Year Level:</label>
                    <select id="year" name="year" autocomplete="off">
                        <option value="">Select Year Level</option>
                        <option value="1st Year" <?= ($year == "1st Year") ? 'selected' : '' ?>>1st Year</option>
                        <option value="2nd Year" <?= ($year == "2nd Year") ? 'selected' : '' ?>>2nd Year</option>
                        <option value="3rd Year" <?= ($year == "3rd Year") ? 'selected' : '' ?>>3rd Year</option>
                        <option value="4th Year" <?= ($year == "4th Year") ? 'selected' : '' ?>>4th Year</option>
                    </select>
                    <span class="error-message" id="year-error"></span>

                    <label for="contact">Contact Number:</label>
                    <input type="text" id="contact" name="contact" placeholder="Contact Number" value="<?= $contact ?>" autocomplete="tel">
                    <span class="error-message" id="contact-error"></span>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Email" value="<?= $email ?>" autocomplete="email">
                    <span class="error-message" id="email-error"></span>
                </div>
                
                <!-- COR upload -->
                <div class="cor-row">
                    <label for="image">Upload COR Picture:</label>
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
                        <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)" style="display: none;" autocomplete="off">
                        <span class="error-message" id="image-error"></span>
                        <input type="hidden" name="existing_image" value="<?= $cor_file ?>" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Button Container - Fixed styling to match Madrasa form -->
        <div class="button-container" style="display: flex; gap: 15px; justify-content: space-between; margin-top: 20px;">
            <button type="button" class="back-button" onclick="window.location.href='volunteer'" style="flex: 1; width: 50%; height: 50px; font-size: 17px; font-weight: 700; padding: 14px 20px; border-radius: 10px; background-color: #1a541c; color: white; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;">Back</button>
            <button type="submit" class="sign-up-button" style="flex: 1; width: 50%; height: 50px; font-size: 17px; font-weight: 700; padding: 14px 20px; border-radius: 10px; background-color: #d72f2f; color: white; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;">Sign Up</button>
        </div>
    </form>

    <?php include '../../includes/footer.php'; ?>
    <script src="../../js/regVolunteer.js"></script>
    <script>
        // Initialize everything when the document is ready
        document.addEventListener('DOMContentLoaded', function() {
            const collegeSelect = document.getElementById('college');
            
            // Re-attach event listener to ensure it's working
            if (collegeSelect) {
                collegeSelect.addEventListener('change', function() {
                    console.log('College selected:', this.value);
                    loadProgramsByCollege(this.value);
                });
                
                // Load programs if a college is already selected
                if (collegeSelect.value) {
                    console.log('Initial college value:', collegeSelect.value);
                    loadProgramsByCollege(collegeSelect.value);
                }
            } else {
                console.error('College select element not found!');
            }
            
            // Debug program field
            const programSelect = document.getElementById('program');
            if (!programSelect) {
                console.error('Program select element not found!');
            }
        });
    </script>
</body>
</html>
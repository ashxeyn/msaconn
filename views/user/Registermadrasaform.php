<?php
require_once '../../tools/function.php';
require_once '../../classes/accountClass.php';
require_once '../../classes/adminClass.php';

session_start();

$adminObj = new Admin();
$programs = $adminObj->fetchProgram();
$colleges = $adminObj->fetchColleges();

// Initialize all possible variables
$registration_type = '';
$first_name = $middle_name = $last_name = $address = $program = $year_level = $school = $college = $cor_file = '';
$first_nameErr = $last_nameErr = $addressErr = $programErr = $collegeErr = $imageErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle the registration type selection
    if (isset($_POST['registration_type'])) {
        $registration_type = clean_input($_POST['registration_type']);
        $_SESSION['registration_type'] = $registration_type;
    }
    
    // If form is submitted (not just type selection)
    if (isset($_POST['submit_form'])) {
        $registration_type = $_SESSION['registration_type'];
        
        // Name fields validation
        $first_name = clean_input($_POST['first_name']);
        $middle_name = clean_input($_POST['middle_name']);
        $last_name = clean_input($_POST['last_name']);
        
        if (empty($first_name)) {
            $first_nameErr = "First name is required!";
        }
        if (empty($last_name)) {
            $last_nameErr = "Last name is required!";
        }

        // Online-specific fields
        if ($registration_type == 'online') {
            $address = clean_input($_POST['address']);
            if (empty($address)) {
                $addressErr = "Address is required!";
            }
            $program = clean_input($_POST['program']);
            $year_level = clean_input($_POST['year_level']);
            $school = clean_input($_POST['school']);
        }
        
        // Onsite-specific fields
        if ($registration_type == 'onsite') {
            $college = clean_input($_POST['college']);
            $program = clean_input($_POST['program']);
            if (empty($college)) {
                $collegeErr = "Please enter your college!";
            }
            if (empty($program)) {
                $programErr = "Please select your program/course!";
            }
        }

        // Handle file upload (common for both)
        if (!empty($_FILES['image']['name'])) {
            $target_dir = "../../assets/enrollment/";
            
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
        
        // Final validation and processing
        if ($registration_type == 'online') {
            $valid = empty($first_nameErr) && empty($last_nameErr) && empty($addressErr);
        } else {
            $valid = empty($first_nameErr) && empty($last_nameErr) && empty($programErr) && empty($collegeErr) && empty($imageErr);
        }
        
        if ($valid) {
            try {
                // Prepare data for database insertion
                $data = [
                    'first_name' => $first_name,
                    'middle_name' => $middle_name,
                    'last_name' => $last_name,
                    'classification' => ($registration_type == 'online') ? 'Online' : 'On-site',
                    'address' => ($registration_type == 'online') ? $address : null,
                    'college_id' => ($registration_type == 'onsite') ? $college : null,
                    'program_id' => $program ?: null,
                    'year_level' => $year_level ?: null,
                    'school' => $school ?: null,
                    'cor_path' => $cor_file ?: null
                ];
                
                // Insert into database
                $enrollmentId = $adminObj->addMadrasaEnrollment($data);
                
                // Set success flag and redirect
                $_SESSION['registration_success'] = true;
                header("Location: ".$_SERVER['PHP_SELF']);
                exit();
                
            } catch (Exception $e) {
                $imageErr = "Registration failed. Please try again.";
                error_log("Registration error: " . $e->getMessage());
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Madrasa Registration</title>
    <link rel="stylesheet" href="../../css/registermadrasa.css">
    <?php include '../../includes/header.php'; ?>
</head>
<body>
    <?php 
    // Show success modal if registration was successful
    if (isset($_SESSION['registration_success'])) {
        $modalPath = dirname(dirname(dirname(__FILE__))) . '/userModals/registrationSuccessModal.php';
        if (file_exists($modalPath)) {
            include $modalPath;
        } else {
            // Fallback modal if file not found
            echo '<div id="successModal" class="modal" style="display: block;">
                    <div class="modal-content">
                        <span class="close-button" onclick="this.parentElement.parentElement.style.display=\'none\'">&times;</span>
                        <h2>Registration Successful!</h2>
                        <p>You have successfully registered for Madrasa.</p>
                    </div>
                  </div>';
        }
        unset($_SESSION['registration_success']);
    }
    ?>

    <?php if (empty($registration_type)): ?>
        <!-- Registration Type Selection -->
        <div class="registration-type-container">
            <h2>Select Registration Type</h2>
            <form method="POST">
                <div class="type-options">
                    <div class="type-option">
                        <input type="radio" id="onsite" name="registration_type" value="onsite">
                        <label for="onsite">
                            <h3>Onsite Registration</h3>
                            <p>For students who will attend in-person classes</p>
                        </label>
                    </div>
                    <div class="type-option">
                        <input type="radio" id="online" name="registration_type" value="online" required>
                        <label for="online">
                            <h3>Online Registration</h3>
                            <p>For students who will attend classes remotely</p>
                        </label>
                    </div>
                </div>
                <button type="submit" class="submit-button">Continue</button>
            </form>
        </div>
    <?php else: ?>
        <!-- Actual Registration Form -->
        <form action="" method="POST" enctype="<?= $registration_type == 'onsite' ? 'multipart/form-data' : 'application/x-www-form-urlencoded' ?>">
            <input type="hidden" name="registration_type" value="<?= $registration_type ?>">
            
            <!-- Common Fields -->
            <div class="form-section">
                <div class="name-fields">
                    <div class="name-field">
                        <label for="first_name">First Name:</label>
                        <input type="text" id="first_name" name="first_name" placeholder="First Name" value="<?= $first_name ?>" required>
                        <span class="error"><?= $first_nameErr ?></span>
                    </div>
                    <div class="name-field">
                        <label for="middle_name">Middle Name:</label>
                        <input type="text" id="middle_name" name="middle_name" placeholder="Middle Name" value="<?= $middle_name ?>">
                    </div>
                    <div class="name-field">
                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" placeholder="Last Name" value="<?= $last_name ?>" required>
                        <span class="error"><?= $last_nameErr ?></span>
                    </div>
                </div>
            </div>

            <?php if ($registration_type == 'online'): ?>
                <!-- Online Specific Fields -->
                <div class="form-section">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" placeholder="Your Complete Address" value="<?= $address ?>" required>
                    <span class="error"><?= $addressErr ?></span>
                </div>
                
                <div class="form-section optional-section">
                    <h3>Optional Information (For Students)</h3>
                    
                    <label for="program">Program:</label>
                    <select id="program" name="program">
                        <option value="">Select Program (Optional)</option>
                        <?php foreach ($programs as $prog): ?>
                            <option value="<?= $prog['program_id'] ?>" <?= ($program == $prog['program_id']) ? 'selected' : '' ?>>
                                <?= clean_input($prog['program_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <label for="year_level">Year Level:</label>
                    <select id="year_level" name="year_level">
                        <option value="">Select Year Level (Optional)</option>
                        <option value="1st Year" <?= ($year_level == "1st Year") ? 'selected' : '' ?>>1st Year</option>
                        <option value="2nd Year" <?= ($year_level == "2nd Year") ? 'selected' : '' ?>>2nd Year</option>
                        <option value="3rd Year" <?= ($year_level == "3rd Year") ? 'selected' : '' ?>>3rd Year</option>
                        <option value="4th Year" <?= ($year_level == "4th Year") ? 'selected' : '' ?>>4th Year</option>
                    </select>
                    
                    <label for="school">School:</label>
                    <input type="text" id="school" name="school" placeholder="Your School (Optional)" value="<?= $school ?>">
                </div>
            <?php else: ?>
                <!-- Onsite Registration Section -->
                <div class="form-section">
                    <label for="college">College:</label>
                    <select id="college" name="college" required onchange="loadPrograms(this.value)">
                        <option value="">Select College</option>
                        <?php foreach ($colleges as $col): ?>
                            <option value="<?= htmlspecialchars($col['college_id']) ?>">
                                <?= htmlspecialchars($col['college_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-section">
                    <label for="program">Program/Course:</label>
                    <select id="program" name="program" required disabled>
                        <option value="">Select College First</option>
                    </select>
                </div>

                <!-- COR Upload (ONLY for onsite registration) -->
                <div class="form-section">
                    <label for="image">Upload COR (Certificate of Registration):</label>
                    <div class="upload-container">
                        <div class="upload-area" id="upload-area" onclick="document.getElementById('image').click()">
                            <div class="upload-placeholder" id="upload-placeholder">
                                <img src="../../assets/icons/upload-icon.png" alt="Upload Icon" class="upload-icon">
                                <p>Click to upload your COR screenshot</p>
                                <p class="upload-hint">(Only JPG, JPEG, or PNG, max 2MB)</p>
                            </div>
                            <div class="image-preview" id="image-preview" style="display: none;">
                                <img id="preview-img" src="#" alt="Image Preview">
                                <button type="button" class="remove-image" onclick="removeImage()">×</button>
                            </div>
                        </div>
                        <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)" style="display: none;">
                        <input type="hidden" name="existing_image" value="<?= $cor_file ?>">
                        <span class="error"><?= $imageErr ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <div class="button-container">
                <button type="button" class="back-button" onclick="window.location.href='?reset=1'">Back</button>
                <button type="submit" name="submit_form" class="submit-button">Submit Registration</button>
            </div>
        </form>
    <?php endif; ?>

    <?php include '../../includes/footer.php'; ?>
    
    <script src="../../js/registermadrasaform.js"></script>
</body>
</html>
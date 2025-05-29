<?php
// Start output buffering to ensure headers can be sent
ob_start();

require_once '../../tools/function.php';
require_once '../../classes/userClass.php';

session_start();

// Enable error reporting for debugging
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

// Initialize User class
$userObj = new User();
$programs = $userObj->fetchProgram();
$colleges = $userObj->fetchColleges();

// Initialize variables
$registration_type = '';
$first_name = $middle_name = $last_name = $address = $program = $year_level = $school = $college = $cor_file = '';
$email = $contact_number = '';
$first_nameErr = $last_nameErr = $addressErr = $programErr = $collegeErr = $imageErr = '';
$emailErr = $contactNumberErr = $yearErr = '';
$college_id = $program_id = ''; // Initialize variables to avoid undefined variable warnings
?>
<!-- Inline style for fixing sticky header -->
<style>
body {
    margin: 0 !important;
    padding: 0 !important;
}
header {
    position: fixed !important;
    top: 0 !important;
    z-index: 999999 !important;
    width: 100% !important;
    left: 0 !important;
    background-color: #ffffff !important;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2) !important;
}
.header-top, .navbar {
    width: 100% !important;
}
main {
    margin-top: 0 !important;
    padding-top: 0 !important;
}
/* Add padding to the form container to prevent it from being hidden behind the header */
.container {
    padding-top: 150px !important;
}
</style>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle the registration type selection
    if (isset($_POST['registration_type'])) {
        $registration_type = clean_input($_POST['registration_type']);
        $_SESSION['registration_type'] = $registration_type;
    }

    // If form is submitted
    if (isset($_POST['submit_registration'])) {
        // Basic validation
        if (empty($_POST['first_name'])) {
            $first_nameErr = "First name is required";
        } else {
            $first_name = clean_input($_POST['first_name']);
        }
        
        if (empty($_POST['last_name'])) {
            $last_nameErr = "Last name is required";
        } else {
            $last_name = clean_input($_POST['last_name']);
        }
        
        $middle_name = clean_input($_POST['middle_name']);
        
        if (empty($_POST['email'])) {
            $emailErr = "Email is required";
        } else {
            $email = clean_input($_POST['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }
        
        if (empty($_POST['contact_number'])) {
            $contactNumberErr = "Contact number is required";
        } else {
            $contact_number = clean_input($_POST['contact_number']);
        }
        
        $classification = clean_input($_POST['registration_type']);
        
        // Address fields (required for all)
        $region = isset($_POST['region']) ? clean_input($_POST['region']) : '';
        $province = isset($_POST['province']) ? clean_input($_POST['province']) : '';
        $city = isset($_POST['city']) ? clean_input($_POST['city']) : '';
        $barangay = isset($_POST['barangay']) ? clean_input($_POST['barangay']) : '';
        $street = isset($_POST['street']) ? clean_input($_POST['street']) : '';
        $zip_code = isset($_POST['zip_code']) ? clean_input($_POST['zip_code']) : '';
        
        // For On-site classification
        if ($classification == 'On-site') {
            if (empty($_POST['college_id'])) {
                $collegeErr = "College is required for On-site registration";
            } else {
                $college_id = clean_input($_POST['college_id']);
            }
            
            if (empty($_POST['program_id'])) {
                $programErr = "Program is required for On-site registration";
            } else {
                $program_id = clean_input($_POST['program_id']);
            }
            
            if (empty($_POST['year_level'])) {
                $yearErr = "Year level is required for On-site registration";
            } else {
                $year_level = clean_input($_POST['year_level']);
            }
            
            // Address fields are from online fields but should still be required for on-site
            if (empty($region) || empty($province) || empty($city) || empty($barangay) || empty($street) || empty($zip_code)) {
                $addressErr = "Address information is required";
            }
        } else {
            // For Online, these are optional
            $college_id = !empty($_POST['college_id']) ? clean_input($_POST['college_id']) : null;
            $program_id = !empty($_POST['program_id']) ? clean_input($_POST['program_id']) : null;
            $year_level = !empty($_POST['year_level']) ? clean_input($_POST['year_level']) : null;
            $school = !empty($_POST['school']) ? clean_input($_POST['school']) : null;
            
            // Check address for online since they are shown for this mode
            if (empty($region) || empty($province) || empty($city) || empty($barangay) || empty($street) || empty($zip_code)) {
                $addressErr = "Address information is required for online registration";
            }
        }

        // Handle file upload
        if (!empty($_FILES['cor_file']['name'])) {
            $target_dir = "../../assets/enrollment/";
            
            if (!is_dir($target_dir)) {
                if (!mkdir($target_dir, 0777, true)) {
                    $imageErr = "Failed to create upload directory.";
                }
            }
            
            if (empty($imageErr)) {
                $image_name = time() . "_" . basename($_FILES['cor_file']['name']);
                $target_file = $target_dir . $image_name;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $allowed_types = ['jpg', 'jpeg', 'png'];
                $maxFileSize = 2 * 1024 * 1024;

                if (!in_array($imageFileType, $allowed_types)) {
                    $imageErr = "Only JPG, JPEG, & PNG files are allowed.";
                } elseif ($_FILES['cor_file']['size'] > $maxFileSize) {
                    $imageErr = "File size should not exceed 2MB.";
                } else {
                    if (move_uploaded_file($_FILES['cor_file']['tmp_name'], $target_file)) {
                        $cor_file = $image_name;
                    } else {
                        $imageErr = "There was an error uploading your file.";
                    }
                }
            }
        } else if ($classification == 'On-site') {
            // COR is required for On-site
            $imageErr = "Please upload your COR screenshot!";
        } else {
            // For Online, COR is optional
            $cor_file = "";
        }

        // Final validation and processing
        $valid = empty($first_nameErr) && empty($last_nameErr) && empty($emailErr) && empty($contactNumberErr) 
                && empty($collegeErr) && empty($programErr) && empty($yearErr) && empty($imageErr) && empty($addressErr);

        if ($valid) {
            try {
                // Prepare data for database insertion
                $data = [
                    'first_name' => $first_name,
                    'middle_name' => $middle_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'contact_number' => $contact_number,
                    'classification' => $classification,
                    'region' => $region,
                    'province' => $province,
                    'city' => $city,
                    'barangay' => $barangay,
                    'street' => $street,
                    'zip_code' => $zip_code,
                    'college_id' => $college_id,
                    'ol_college' => ($classification == 'Online' && !empty($school)) ? $school : null,
                    'program_id' => $program_id,
                    'ol_program' => null,
                    'year_level' => $year_level,
                    'school' => $school,
                    'cor_path' => $cor_file
                ];

                // Insert into database and get result
                $result = $userObj->addMadrasaEnrollment($data);
                
                // Log actual result for debugging
                file_put_contents('registration_debug.log', 'Result value: ' . (is_numeric($result) ? $result : 'false/null') . ' - ' . date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);
                
                // Consider ANY non-false result as success (including ID=0)
                if ($result !== false) {
                    // Log registration success with the ID
                    file_put_contents('registration_debug.log', 'Registration successful! ID: ' . $result . ' - ' . date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);
                    
                    // Important: Set session flag BEFORE any output
                    $_SESSION['madrasa_registration_success'] = true;
                    $_SESSION['registration_message'] = "Your enrollment for Madrasa has been received and will be processed by our team.";
                    
                    // Use PHP header redirect instead of JavaScript
                    header('Location: registrationmadrasa.php');
                    exit;
                } else {
                    // Log when registration fails
                    file_put_contents('registration_debug.log', 'Registration failed - ' . date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);
                }
            } catch (Exception $e) {
                // Log detailed error message
                file_put_contents('registration_debug.log', 'Error: ' . $e->getMessage() . ' at ' . date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Madrasa Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap" rel="stylesheet">
    <!-- Add regVolunteer.css instead of registermadrasa.css but keep all functional CSS -->
    <link rel="stylesheet" href="../../css/regVolunteer.css">
    <?php include '../../includes/header.php'; ?>
    <style>
        body {
            margin: 0 !important;
            padding: 0 !important;
            font-family: 'Noto Naskh Arabic', serif;
            overflow-x: hidden;
            position: relative;
            background: #ffffff;
            box-sizing: border-box;
        }
        
        /* Header styling from original file */
        header {
            position: fixed !important;
            top: 0 !important;
            z-index: 999999 !important;
            width: 100% !important;
            left: 0 !important;
            background-color: #ffffff !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2) !important;
        }
        
        .header-top, .navbar {
            width: 100% !important;
        }
        
        /* Main Content Container - match the regVolunteer structure */
        .main-content {
            width: 100% !important;
            display: flex !important;
            justify-content: center !important;
            align-items: flex-start !important;
            padding: 20px 0 80px 0 !important; /* Reduced top padding from 80px to 50px */
            box-sizing: border-box !important;
            position: relative !important;
        }
        
        /* Form styling - match regVolunteer exactly */
        form {
            font-family: 'Noto Naskh Arabic', serif !important;
            max-width: 600px !important;
            width: 90% !important;
            margin: 0 auto !important;
            padding: 25px !important;
            background-color: #ffffff !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1) !important;
            overflow: hidden !important;
            max-height: 80vh !important; /* Keep scrollbar */
            overflow-y: auto !important;
            position: relative !important;
            z-index: 10 !important;
        }
        
        /* Form columns with exact same dimensions */
        .form-columns {
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
            margin-bottom: 20px !important;
            gap: 0 !important;
        }
        
        /* Ensure proper spacing with footer */
        footer {
            margin-top: 50px !important;
            position: relative !important;
            z-index: 5 !important;
        }
        
        /* Responsive styles */
        @media (max-width: 768px) {
            .form-col {
                flex: 100% !important;
                min-width: 100% !important;
            }
            
            form {
                width: 95% !important;
                padding: 15px !important;
                max-height: 75vh !important;
            }
            
            .main-content {
                padding: 70px 0 70px 0 !important;
            }
        }
        
        @media (max-width: 480px) {
            form {
                padding: 15px !important;
                width: 95% !important;
                max-height: 70vh !important;
            }
            
            button[type="submit"], .back-button {
                font-size: 14px !important;
                padding: 10px !important;
            }
            
            .main-content {
                padding: 60px 0 60px 0 !important;
            }
        }
        
        /* Fix dropdown styling */
        select {
            display: block !important;
            width: 100% !important;
            padding: 12px !important;
            margin-bottom: 15px !important;
            border: 1px solid #ddd !important;
            border-radius: 8px !important;
            font-size: 14px !important;
            background-color: #f9f9f9 !important;
            font-family: 'Noto Naskh Arabic', serif !important;
        }
        
        /* Styling for disabled select elements */
        select:disabled {
            background-color: #f0f0f0 !important;
            color: #888 !important;
            cursor: not-allowed !important;
        }
        
        /* Styling for separator options */
        option:disabled {
            color: #1a541c !important;
            font-weight: bold !important;
            background-color: #f0f0f0 !important;
        }
        
        /* Styling for independent city options */
        option.independent-city {
            font-style: italic !important;
            color: #1a541c !important;
        }
        
        /* Label styling */
        label {
            display: block !important;
            margin-bottom: 8px !important;
            font-weight: 600 !important;
            color: #333 !important;
            font-size: 14px !important;
            font-family: 'Noto Naskh Arabic', serif !important;
        }
        
        /* Input styling */
        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100% !important;
            padding: 12px !important;
            margin-bottom: 15px !important;
            border: 1px solid #ddd !important;
            border-radius: 8px !important;
            font-size: 14px !important;
            background-color: #f9f9f9 !important;
            font-family: 'Noto Naskh Arabic', serif !important;
        }
        
        /* Error message styling */
        .error, .validation-error {
            color: #b33a3a !important;
            font-size: 13px !important;
            display: block !important;
            margin-top: 5px !important;
            margin-bottom: 10px !important;
            font-style: italic !important;
        }
        
        /* Remove the negative margin since we want it to appear below the field */
        .validation-error {
            margin-top: 5px !important;
        }
        
        /* Highlighted border for invalid inputs */
        input.invalid, select.invalid {
            border: 1px solid #b33a3a !important;
            background-color: #fff !important;
        }
        
        /* Upload container styling */
        .upload-container {
            margin-bottom: 15px !important;
        }
        
        .upload-area {
            border: 2px dashed #1a541c !important;
            border-radius: 8px !important;
            padding: 15px !important;
            text-align: center !important;
            cursor: pointer !important;
            background-color: #f9f9f9 !important;
        }
        
        /* Special styling for error on file upload */
        .upload-container .validation-error {
            margin-top: 8px !important;
        }
        
        .upload-icon {
            width: 40px !important;
            height: 40px !important;
            opacity: 0.7 !important;
        }
        
        /* Button styling - exact match to volunteer form */
        button[type="submit"], .back-button {
            flex: 1 !important;
            width: 50% !important;
            height: 50px !important;
            font-size: 17px !important;
            font-weight: 700 !important;
            padding: 14px 20px !important;
            border-radius: 10px !important;
            cursor: pointer !important;
            border: none !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-family: 'Noto Naskh Arabic', serif !important;
        }
        
        .back-button {
            background-color: #1a541c !important;
            color: white !important;
        }
        
        button[type="submit"] {
            background-color: #d72f2f !important;
            color: white !important;
        }
        
        /* Button container to match volunteer form */
        .button-container {
            display: flex !important;
            gap: 15px !important;
            justify-content: space-between !important;
            margin-top: 20px !important;
        }
        
        /* Form sections */
        .form-section {
            margin-bottom: 20px !important;
        }
        
        /* Address fields styling */
        .address-fields {
            margin-bottom: 20px !important;
        }
        
        .address-fields label {
            margin-bottom: 5px !important;
        }
        
        .address-fields select,
        .address-fields input {
            margin-bottom: 15px !important;
        }
        
        h2 {
            color: #333 !important;
            text-align: center !important;
            margin-bottom: 30px !important;
            font-family: 'Noto Naskh Arabic', serif !important;
        }
        
        h3 {
            color: #1a541c !important;
            margin-bottom: 15px !important;
            font-family: 'Noto Naskh Arabic', serif !important;
        }
        
        /* Custom scrollbar for the form - same as volunteer form */
        form::-webkit-scrollbar {
            width: 10px;
        }
        
        form::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 8px;
        }
        
        form::-webkit-scrollbar-thumb {
            background: #1a541c;
            border-radius: 8px;
        }
        
        form::-webkit-scrollbar-thumb:hover {
            background: #134015;
        }
    </style>
</head>
<body>
    <?php
    // Show success modal if registration was successful
    if (isset($_SESSION['madrasa_registration_success'])) {
        $modalPath = dirname(dirname(dirname(__FILE__))) . '/views/usermodals/registrationforvolunteermodal.php';
        include $modalPath;
        unset($_SESSION['madrasa_registration_success']);
    }
    ?>
    
    <div class="main-content">
        <form action="" method="POST" enctype="multipart/form-data" id="madrasaForm" onsubmit="return validateMadrasaFormDirect(event);" novalidate>
            <h2>Madrasa Registration Form</h2>
            <div class="form-columns">
                <div class="form-col">
                    <!-- Registration Type -->
                    <div class="form-section">
                        <label for="registration_type">Registration Type:</label>
                        <select id="registration_type" name="registration_type" required onchange="toggleRegistrationTypeFields()">
                            <option value="On-site" <?= ($registration_type == 'On-site') ? 'selected' : '' ?>>On-site</option>
                            <option value="Online" <?= ($registration_type == 'Online') ? 'selected' : '' ?>>Online</option>
                        </select>
                    </div>

                    <!-- Name Fields -->
                    <div class="form-section">
                        <label for="first_name">First Name:</label>
                        <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>
                        
                        <label for="middle_name">Middle Name:</label>
                        <input type="text" id="middle_name" name="middle_name" placeholder="Enter your middle name" required>
                        
                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" placeholder="Enter your last name" required>
                        
                    </div>

                    <!-- Contact Information -->
                    <div class="form-section">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                        
                        <label for="contact_number">Contact Number:</label>
                        <input type="tel" id="contact_number" name="contact_number" placeholder="Enter your contact number" required>
                        
                    </div>
                    
                    <!-- Address Fields -->
                    <div class="form-section address-fields">
                        <h3>Address Information</h3>
                        
                        <label for="region">Region:</label>
                        <select id="region" name="region" required>
                            <option value="">Select Region</option>
                        </select>

                        <label for="province">Province:</label>
                        <select id="province" name="province" required>
                            <option value="">Select Province</option>
                        </select>

                        <label for="city">City/Municipality:</label>
                        <select id="city" name="city" required>
                            <option value="">Select City/Municipality</option>
                        </select>

                        <label for="barangay">Barangay:</label>
                        <select id="barangay" name="barangay" required>
                            <option value="">Select Barangay</option>
                        </select>
                        
                        <label for="street">Street/House No.:</label>
                        <input type="text" id="street" name="street" placeholder="Enter street address" required>
                        
                        <label for="zip_code">Zip Code:</label>
                        <input type="text" id="zip_code" name="zip_code" placeholder="Enter zip code" required>
                        
                    </div>
                </div>
                <div class="form-col">
                    <!-- Optional Fields Indicator (Online Only) -->
                    <div class="form-section online-only" id="optional-indicator" style="display:none;">
                        <p style="color:#1a541c; font-size: 14px; margin-top: 0;">
                            <em>Note: College, Program, Year Level, School fields, and COR are optional for Online registration. Fill them only if you want to provide this information.</em>
                        </p>
                    </div>

                    <!-- College and Program Section -->
                    <div class="form-section onsite-only online-only" id="college-program-section">
                        <label for="college_id">College:</label>
                        <select id="college_id" name="college_id" onchange="loadProgramsByCollege(this.value)">
                            <option value="">Select College<?= ($registration_type == 'Online') ? '' : '' ?></option>
                            <?php foreach ($colleges as $college): ?>
                                <option value="<?= $college['college_id'] ?>" <?= ($college_id == $college['college_id']) ? 'selected' : '' ?>><?= $college['college_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        
                        <label for="program_id">Program:</label>
                        <select id="program_id" name="program_id">
                            <option value="">Select College First</option>
                        </select>
                        
                    </div>

                    <!-- Year Level Section -->
                    <div class="form-section onsite-only online-only" id="year-level-section">
                        <label for="year_level">Year Level:</label>
                        <select id="year_level" name="year_level">
                            <option value="">Select Year Level<?= ($registration_type == 'Online') ? '' : '' ?></option>
                            <option value="1st Year" <?= ($year_level == '1st Year') ? 'selected' : '' ?>>1st Year</option>
                            <option value="2nd Year" <?= ($year_level == '2nd Year') ? 'selected' : '' ?>>2nd Year</option>
                            <option value="3rd Year" <?= ($year_level == '3rd Year') ? 'selected' : '' ?>>3rd Year</option>
                            <option value="4th Year" <?= ($year_level == '4th Year') ? 'selected' : '' ?>>4th Year</option>
                        </select>
                        
                    </div>

                    <!-- School Section (Online Only) -->
                    <div class="form-section online-only" id="school-section">
                        <label for="school">School:</label>
                        <input type="text" id="school" name="school" placeholder="Enter your school">
                    </div>

                    <!-- COR Upload -->
                    <div class="form-section">
                        <label for="cor_file">Upload COR (Certificate of Registration):</label>
                        <div class="upload-container">
                            <div class="upload-area" id="upload-area" onclick="document.getElementById('cor_file').click()">
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
                            <input type="file" id="cor_file" name="cor_file" accept="image/*" onchange="previewImage(event)" style="display: none;">
                            
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="button-container">
                        <button type="button" class="back-button" onclick="window.location.href='registrationmadrasa'">Back</button>
                        <button type="submit" name="submit_registration" id="submit_button">Submit Registration</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php include '../../includes/footer.php'; ?>
    
    <!-- Load only registermadrasaform.js which now uses the Philippine Address API -->
    <script src="../../js/registermadrasaform.js"></script>
</body>
</html>
<?php
// Flush the output buffer and send all output to the browser
ob_end_flush();
?>
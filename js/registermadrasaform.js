// Function to preview image before upload
function previewImage(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const previewImg = document.getElementById('preview-img');
            const previewDiv = document.getElementById('image-preview');
            const placeholder = document.getElementById('upload-placeholder');
            
            previewImg.src = e.target.result;
            previewDiv.style.display = 'block';
            placeholder.style.display = 'none';
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Function to remove the image preview
function removeImage() {
    const fileInput = document.getElementById('cor_file');
    const previewDiv = document.getElementById('image-preview');
    const placeholder = document.getElementById('upload-placeholder');
    
    fileInput.value = '';
    previewDiv.style.display = 'none';
    placeholder.style.display = 'flex';
}

// Function to toggle registration type fields
function toggleRegistrationTypeFields() {
    var regType = document.getElementById('registration_type').value;
    var onsiteFields = document.querySelectorAll('.onsite-only');
    var onlineFields = document.querySelectorAll('.online-only');
    var optionalIndicator = document.getElementById('optional-indicator');
    
    // Clear any validation errors
    clearValidationErrors();
    
    // Hide all first
    onsiteFields.forEach(function(el) { 
        if (!el.classList.contains('online-only')) {
            el.style.display = 'none'; 
        }
    });
    
    onlineFields.forEach(function(el) { 
        el.style.display = 'none';
    });
    
    if (optionalIndicator) optionalIndicator.style.display = 'none';

    // Get all form input elements
    var middleName = document.getElementById('middle_name');
    var college = document.getElementById('college_id');
    var program = document.getElementById('program_id');
    var year = document.getElementById('year_level');
    var collegeSections = document.querySelectorAll('.form-section.onsite-only.online-only');
    var corFile = document.getElementById('cor_file');
    
    // Always show address fields
    document.querySelector('.address-fields').style.display = 'block';
    
    // Middle name is required for both types
    if (middleName) middleName.required = true;

    if (regType === 'On-site') {
        // Show onsite fields
        onsiteFields.forEach(function(el) { 
            el.style.display = 'block';
        });
        
        collegeSections.forEach(function(el) { 
            el.style.display = 'block';
        });
        
        // Set required fields for On-site
        if (college) college.required = true;
        if (program) program.required = true;
        if (year) year.required = true;
        if (corFile) corFile.required = true;
    } else if (regType === 'Online') {
        // Show online fields
        onlineFields.forEach(function(el) { 
            el.style.display = 'block';
        });
        
        collegeSections.forEach(function(el) { 
            el.style.display = 'block';
        });
        
        // Make these fields optional for Online
        if (college) college.required = false;
        if (program) program.required = false;
        if (year) year.required = false;
        if (corFile) corFile.required = false;
        
        if (optionalIndicator) optionalIndicator.style.display = 'block';
    }
}

// Function to load programs by college
function loadProgramsByCollege(collegeId) {
    const programSelect = document.getElementById('program_id');
    if (!programSelect || !collegeId) return;

    // Show loading state
    programSelect.innerHTML = '<option value="">Loading programs...</option>';

    // Get base URL dynamically
    const baseUrl = window.location.href.split('/').slice(0, -2).join('/');
    const apiUrl = `${baseUrl}/handler/user/getProgramsByCollege.php?college_id=${collegeId}`;
    
    console.log('Fetching programs from:', apiUrl);
    
    // Fetch programs from server
    fetch(apiUrl)
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`Network response was not ok: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Programs data received:', data);
            
            // Clear and add default option
            programSelect.innerHTML = '<option value="">Select Program</option>';
            
            // Check if data has expected structure
            if (data && Array.isArray(data)) {
                if (data.length > 0) {
                    // Add program options
                    data.forEach(program => {
                        const option = document.createElement('option');
                        option.value = program.program_id;
                        option.textContent = program.program_name;
                        programSelect.appendChild(option);
                    });
                } else {
                    programSelect.innerHTML = '<option value="">No programs available for this college</option>';
                }
            } else {
                throw new Error('Invalid data format received from server');
            }
        })
        .catch(error => {
            console.error('Error fetching programs:', error);
            programSelect.innerHTML = '<option value="">Error loading programs</option>';
            
            // Try fallback approach with direct URL
            const fallbackUrl = `/msaconn/handler/user/getProgramsByCollege.php?college_id=${collegeId}`;
            console.log('Trying fallback URL:', fallbackUrl);
            
            fetch(fallbackUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Fallback failed: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Fallback data received:', data);
                    
                    programSelect.innerHTML = '<option value="">Select Program</option>';
                    
                    if (data && Array.isArray(data) && data.length > 0) {
                        data.forEach(program => {
                            const option = document.createElement('option');
                            option.value = program.program_id;
                            option.textContent = program.program_name;
                            programSelect.appendChild(option);
                        });
                    } else {
                        programSelect.innerHTML = '<option value="">No programs found</option>';
                    }
                })
                .catch(fallbackError => {
                    console.error('Fallback error:', fallbackError);
                });
        });
}

// Clear validation errors and reset input styling
function clearValidationErrors() {
    // Remove all error messages
    document.querySelectorAll('.validation-error').forEach(el => el.remove());
    
    // Remove invalid class from all inputs
    document.querySelectorAll('.invalid').forEach(input => {
        input.classList.remove('invalid');
    });
    
    // Also clear the original error messages if any
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
}

// Function to validate email
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
}

// Function to validate phone number
function validatePhoneNumber(phone) {
    // Simple validation for Philippine numbers
    // Allows formats like: +639XXXXXXXXX, 09XXXXXXXXX, 639XXXXXXXXX
    const re = /^(\+?63|0)9\d{9}$/;
    return re.test(phone);
}

// Function to show validation error with consistent styling
function showValidationError(inputId, message) {
    const input = typeof inputId === 'string' ? document.getElementById(inputId) : inputId;
    if (!input) return;
    
    // Remove any existing error
    const existingError = input.nextElementSibling;
    if (existingError && existingError.classList.contains('validation-error')) {
        existingError.remove();
    }
    
    // Create error message element
    const errorSpan = document.createElement('span');
    errorSpan.classList.add('validation-error');
    errorSpan.textContent = message;
    
    // Apply direct styling with !important to ensure it overrides any other styles
    errorSpan.style.cssText = 'color: #b33a3a !important; font-size: 13px !important; display: block !important; margin-top: 5px !important; margin-bottom: 10px !important; font-style: italic !important;';
    
    // For file input, append to the upload container
    if (input.type === 'file') {
        const uploadContainer = input.closest('.upload-container');
        if (uploadContainer) {
            uploadContainer.appendChild(errorSpan);
        }
    } else {
        // Add error message after the input
        input.parentNode.insertBefore(errorSpan, input.nextSibling);
    }
    
    // Add invalid class to input for visual feedback
    input.classList.add('invalid');
}

// Main form validation function
function validateMadrasaFormDirect(e) {
    console.log('Validating form...');
    e.preventDefault(); // Prevent default form submission
    
    let isValid = true;
    
    // Clear previous errors
    clearValidationErrors();
    
    // Get registration type
    const regType = document.getElementById('registration_type').value;
    
    // Fields required for ALL registration types
    const requiredFields = [
        {id: 'first_name', message: 'First name is required'},
        {id: 'middle_name', message: 'Middle name is required'},
        {id: 'last_name', message: 'Last name is required'},
        {id: 'email', message: 'Email is required'},
        {id: 'contact_number', message: 'Contact number is required'},
        {id: 'region', message: 'Region is required'},
        {id: 'province', message: 'Province is required'},
        {id: 'city', message: 'City/Municipality is required'},
        {id: 'barangay', message: 'Barangay is required'},
        {id: 'street', message: 'Street/House No. is required'},
        {id: 'zip_code', message: 'Zip code is required'}
    ];
    
    // Validate all required fields
    requiredFields.forEach(field => {
        const input = document.getElementById(field.id);
        if (input && !input.value.trim()) {
            showValidationError(input, field.message);
            isValid = false;
        }
    });
    
    // Email format validation
    const emailInput = document.getElementById('email');
    if (emailInput && emailInput.value.trim() && !validateEmail(emailInput.value)) {
        showValidationError(emailInput, 'Invalid email format');
        isValid = false;
    }
    
    // Phone number validation
    const contactInput = document.getElementById('contact_number');
    if (contactInput && contactInput.value.trim() && !validatePhoneNumber(contactInput.value)) {
        showValidationError(contactInput, 'Invalid phone number format');
        isValid = false;
    }
    
    // Additional validation ONLY for On-site registration
    if (regType === 'On-site') {
        // College validation
        const collegeField = document.getElementById('college_id');
        if (collegeField && !collegeField.value) {
            showValidationError(collegeField, 'College is required for On-site registration');
            isValid = false;
        }
        
        // Program validation
        const programField = document.getElementById('program_id');
        if (programField && !programField.value) {
            showValidationError(programField, 'Program is required for On-site registration');
            isValid = false;
        }
        
        // Year level validation
        const yearField = document.getElementById('year_level');
        if (yearField && !yearField.value) {
            showValidationError(yearField, 'Year level is required for On-site registration');
            isValid = false;
        }
        
        // COR file validation
        const fileInput = document.getElementById('cor_file');
        if (fileInput && !fileInput.files.length) {
            const uploadContainer = document.querySelector('.upload-container');
            if (uploadContainer) {
                showValidationError(fileInput, 'COR file is required for On-site registration');
                document.querySelector('.upload-area').style.border = '2px dashed #b33a3a !important';
                isValid = false;
            }
        }
    }
    
    // If valid, submit the form
    if (isValid) {
        console.log('Form validation passed, submitting form');
        document.getElementById('madrasaForm').submit();
    } else {
        // Scroll to the first error
        const firstError = document.querySelector('.validation-error');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
    
    return isValid;
}

// Add input event listeners to clear validation errors when user types
function addInputListeners() {
    const formInputs = document.querySelectorAll('input, select');
    formInputs.forEach(input => {
        input.addEventListener('input', function() {
            // Remove error message for this input
            const nextSibling = this.nextElementSibling;
            if (nextSibling && nextSibling.classList.contains('validation-error')) {
                nextSibling.remove();
            }
            // Remove invalid class from this input
            this.classList.remove('invalid');
            
            // For address fields, if any address field is changed, remove the zip code error
            if (['region', 'province', 'city', 'barangay', 'street'].includes(this.id)) {
                const zipCodeInput = document.getElementById('zip_code');
                if (zipCodeInput) {
                    const zipCodeError = zipCodeInput.nextElementSibling;
                    if (zipCodeError && zipCodeError.classList.contains('validation-error')) {
                        zipCodeError.remove();
                    }
                    zipCodeInput.classList.remove('invalid');
                }
            }
        });
    });
    
    // Add special event listener for the file input
    const corFileInput = document.getElementById('cor_file');
    if (corFileInput) {
        corFileInput.addEventListener('change', function() {
            // Find and remove error message for file input
            const uploadContainer = this.closest('.upload-container');
            if (uploadContainer) {
                const errorMsg = uploadContainer.querySelector('.validation-error');
                if (errorMsg) errorMsg.remove();
                
                // Reset the border color
                const uploadArea = uploadContainer.querySelector('.upload-area');
                if (uploadArea) {
                    uploadArea.style.border = '2px dashed #1a541c !important';
                }
            }
        });
    }
}

// Initialize address dropdowns
function initAddressDropdowns() {
    const regionSelect = document.getElementById('region');
    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');
    const barangaySelect = document.getElementById('barangay');
    
    if(!regionSelect || !provinceSelect || !citySelect || !barangaySelect) {
        console.error('Address dropdown elements not found');
        return;
    }
    
    // Clear existing options except the first one
    regionSelect.innerHTML = '<option value="">Select Region</option>';
    provinceSelect.innerHTML = '<option value="">Select Province</option>';
    citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
    barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
    
    // Define region data if it's not already defined
    if (typeof regionData === 'undefined') {
        console.log('Defining regionData locally');
        window.regionData = {
            regions: ['Zamboanga Peninsula'],
            provinces: [
                'Zamboanga del Norte',
                'Zamboanga del Sur',
                'Zamboanga Sibugay',
                'Zamboanga City',
                'Isabela City'
            ],
            cities: {
                'Zamboanga del Norte': ['Dapitan City', 'Dipolog City', 'Katipunan', 'La Libertad', 'Labason', 'Liloy', 'Manukan', 'Polanco', 'Rizal', 'Roxas', 'Sergio Osmeña Sr.', 'Siayan', 'Sindangan', 'Siocon', 'Tampilisan'],
                'Zamboanga del Sur': ['Aurora', 'Bayog', 'Dimataling', 'Dinas', 'Dumalinao', 'Dumingag', 'Guipos', 'Josefina', 'Kumalarang', 'Labangan', 'Lakewood', 'Lapuyan', 'Mahayag', 'Margosatubig', 'Midsalip', 'Molave', 'Pagadian City', 'Pitogo', 'Ramon Magsaysay', 'San Miguel', 'San Pablo', 'Sominot', 'Tabina', 'Tambulig', 'Tigbao', 'Tukuran', 'Vincenzo A. Sagun'],
                'Zamboanga Sibugay': ['Alicia', 'Buug', 'Diplahan', 'Imelda', 'Ipil', 'Kabasalan', 'Mabuhay', 'Malangas', 'Naga', 'Olutanga', 'Payao', 'Roseller Lim', 'Siay', 'Talusan', 'Titay', 'Tungawan'],
                'Zamboanga City': ['Zamboanga City'],
                'Isabela City': ['Isabela City']
            },
            barangays: {
                'Zamboanga City': ['Arena Blanco', 'Ayala', 'Baluno', 'Boalan', 'Bolong', 'Buenavista', 'Bunguiao', 'Busay', 'Cabaluay', 'Cabatangan', 'Calarian', 'Canelar', 'Divisoria', 'Guiwan', 'Lunzuran', 'Putik', 'Recodo', 'San Jose Gusu', 'Sta. Maria', 'Tetuan'],
                'Dipolog City': ['Barra', 'Biasong', 'Central', 'Cogon', 'Dicayas', 'Diwan', 'Estaka', 'Galas', 'Gulayon', 'Lugdungan', 'Magsaysay', 'Olingan', 'Sicayab', 'Sta. Isabel', 'Turno']
            }
        };
    }
    
    // Populate Regions
    regionData.regions.forEach(region => {
        const option = document.createElement('option');
        option.value = region;
        option.textContent = region;
        regionSelect.appendChild(option);
    });

    // Handle Region Change
    regionSelect.addEventListener('change', function() {
        const selectedRegion = regionSelect.value;
        provinceSelect.innerHTML = '<option value="">Select Province</option>';
        citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

        if (selectedRegion === 'Zamboanga Peninsula') {
            regionData.provinces.forEach(province => {
                const option = document.createElement('option');
                option.value = province;
                option.textContent = province;
                provinceSelect.appendChild(option);
            });
        }
    });

    // Handle Province Change
    provinceSelect.addEventListener('change', function() {
        const selectedProvince = provinceSelect.value;
        citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

        if (regionData.cities[selectedProvince]) {
            regionData.cities[selectedProvince].forEach(city => {
                const option = document.createElement('option');
                option.value = city;
                option.textContent = city;
                citySelect.appendChild(option);
            });
        }
    });

    // Handle City Change
    citySelect.addEventListener('change', function() {
        const selectedCity = citySelect.value;
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

        if (regionData.barangays[selectedCity]) {
            regionData.barangays[selectedCity].forEach(barangay => {
                const option = document.createElement('option');
                option.value = barangay;
                option.textContent = barangay;
                barangaySelect.appendChild(option);
            });
        }
    });
}

// Initialize everything when the document is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded - initializing form validation');
    
    // Initialize address dropdowns
    initAddressDropdowns();
    
    // Initialize form fields based on registration type
    const registrationTypeSelect = document.getElementById('registration_type');
    if (registrationTypeSelect) {
        toggleRegistrationTypeFields();
        
        registrationTypeSelect.addEventListener('change', function() {
            toggleRegistrationTypeFields();
        });
    }
    
    // Add change event listener for college selection
    const collegeSelect = document.getElementById('college_id');
    if (collegeSelect) {
        collegeSelect.addEventListener('change', function() {
            loadProgramsByCollege(this.value);
            
            // Remove validation error if present
            const nextSibling = this.nextElementSibling;
            if (nextSibling && nextSibling.classList.contains('validation-error')) {
                nextSibling.remove();
            }
            this.classList.remove('invalid');
        });
        
        // If college already has a value, load programs
        if (collegeSelect.value) {
            loadProgramsByCollege(collegeSelect.value);
        }
    }
    
    // Add input event listeners to fields to clear errors when typing
    addInputListeners();
    
    // Initialize form with direct validation method
    const madrasaForm = document.getElementById('madrasaForm');
    if (madrasaForm) {
        console.log('Form found, attaching submit event listener');
        madrasaForm.addEventListener('submit', function(e) {
            return validateMadrasaFormDirect(e);
        });
    } else {
        console.error('Madrasa form not found!');
    }
    
    // Add click handler for submit button as backup
    const submitButton = document.getElementById('submit_button');
    if (submitButton) {
        submitButton.addEventListener('click', function(e) {
            // This will trigger the form's onsubmit handler
            console.log('Submit button clicked');
        });
    }
}); 
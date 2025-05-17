// DOM Elements
const SELECTORS = {
    FORM: 'form',
    IMAGE_INPUT: '#image',
    PREVIEW_IMG: '#preview-img',
    UPLOAD_PLACEHOLDER: '#upload-placeholder',
    PREVIEW_CONTAINER: '#image-preview',
    BACK_BUTTON: '.back-button',
    PROGRAM_SELECT: '#program',
    YEAR_LEVEL_SELECT: '#year_level',
    NAME_INPUT: '#name',
    ADDRESS_INPUT: '#address',
    COLLEGE_INPUT: '#college',
    REGISTRATION_TYPE: '[name="registration_type"]',
    EXISTING_IMAGE: '[name="existing_image"]'
};

const form = document.querySelector(SELECTORS.FORM);
const imageInput = document.querySelector(SELECTORS.IMAGE_INPUT);
const previewImg = document.querySelector(SELECTORS.PREVIEW_IMG);
const uploadPlaceholder = document.querySelector(SELECTORS.UPLOAD_PLACEHOLDER);
const previewContainer = document.querySelector(SELECTORS.PREVIEW_CONTAINER);
const backButton = document.querySelector(SELECTORS.BACK_BUTTON);
const programSelect = document.querySelector(SELECTORS.PROGRAM_SELECT);

// Event Listeners
function initEventListeners() {
    if (imageInput) {
        imageInput.addEventListener('change', previewImage);
    }

    if (form) {
        form.addEventListener('submit', validateMadrasaForm);
    }

    if (backButton) {
        backButton.addEventListener('click', handleBackButton);
    }

    if (programSelect) {
        programSelect.addEventListener('change', updateYearLevels);
    }
}

// Image Preview Functionality
function previewImage(event) {
    var input = event.target;
    var preview = document.getElementById('image-preview');
    var placeholder = document.getElementById('upload-placeholder');
    var img = document.getElementById('preview-img');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function removeImage() {
    var input = document.getElementById('cor_file');
    var preview = document.getElementById('image-preview');
    var placeholder = document.getElementById('upload-placeholder');
    input.value = '';
    preview.style.display = 'none';
    placeholder.style.display = 'flex';
}

function resetImageInput() {
    imageInput.value = '';
    uploadPlaceholder.style.display = 'block';
    previewContainer.style.display = 'none';
}

// Form Validation for Madrasa Registration
function validateMadrasaForm(e) {
    console.log('validateMadrasaForm called!');
    
    const regType = document.getElementById('registration_type').value;
    let isValid = true;
    
    // Clear previous error messages and input styling
    clearValidationErrors();
    
    // Common required fields validation (for both On-site and Online)
    const requiredFields = [
        { id: 'first_name', message: 'First name is required' },
        { id: 'last_name', message: 'Last name is required' },
        { id: 'email', message: 'Email is required' },
        { id: 'contact_number', message: 'Contact number is required' }
    ];

    // Validate common fields
    requiredFields.forEach(field => {
        const input = document.getElementById(field.id);
        if (input && !input.value.trim()) {
            showValidationError(input, field.message);
            isValid = false;
        }
    });
    
    // Address fields validation - group them together
    const addressFields = [
        { id: 'region', required: true },
        { id: 'province', required: true },
        { id: 'city', required: true },
        { id: 'barangay', required: true },
        { id: 'street', required: true },
        { id: 'zip_code', required: true }
    ];
    
    // Check if any address field is empty
    let addressComplete = true;
    addressFields.forEach(field => {
        const input = document.getElementById(field.id);
        if (input && field.required && !input.value.trim()) {
            addressComplete = false;
        }
    });
    
    // If any address field is empty, show a single error message for zip_code field
    if (!addressComplete) {
        const zipCodeInput = document.getElementById('zip_code');
        if (zipCodeInput) {
            showValidationError(zipCodeInput, 'Address information is required');
            isValid = false;
        }
    }
    
    // Email format validation
    const emailInput = document.getElementById('email');
    if (emailInput && emailInput.value.trim() && !validateEmail(emailInput.value)) {
        showValidationError(emailInput, 'Invalid email format');
        isValid = false;
    }
    
    // Phone number format validation
    const contactInput = document.getElementById('contact_number');
    if (contactInput && contactInput.value.trim() && !validatePhoneNumber(contactInput.value)) {
        showValidationError(contactInput, 'Invalid phone number format');
        isValid = false;
    }
    
    // On-site specific validations
    if (regType === 'On-site') {
        // College validation
        const collegeInput = document.getElementById('college_id');
        if (collegeInput && !collegeInput.value.trim()) {
            showValidationError(collegeInput, 'College is required for On-site registration');
            isValid = false;
        }
        
        // Program validation
        const programInput = document.getElementById('program_id');
        if (programInput && !programInput.value.trim()) {
            showValidationError(programInput, 'Program is required for On-site registration');
            isValid = false;
        }
        
        // Year level validation
        const yearInput = document.getElementById('year_level');
        if (yearInput && !yearInput.value.trim()) {
            showValidationError(yearInput, 'Year level is required for On-site registration');
            isValid = false;
        }
        
        // COR file validation (required for On-site)
        const corFile = document.getElementById('cor_file');
        if (corFile && !corFile.files.length) {
            // Special handling for file input since it's hidden
            const uploadContainer = corFile.closest('.upload-container');
            if (uploadContainer) {
                // Create error message element
                const errorSpan = document.createElement('span');
                errorSpan.classList.add('validation-error');
                errorSpan.textContent = 'COR file is required for On-site registration';
                errorSpan.style.cssText = 'color: #b33a3a !important; font-size: 13px !important; display: block !important; margin-top: 5px !important; margin-bottom: 10px !important; font-style: italic !important; text-align: center !important;';
                
                // Remove any existing error
                const existingError = uploadContainer.querySelector('.validation-error');
                if (existingError) {
                    existingError.remove();
                }
                
                // Add the error message to the upload container
                uploadContainer.appendChild(errorSpan);
                
                // Add red border to the upload area
                const uploadArea = uploadContainer.querySelector('.upload-area');
                if (uploadArea) {
                    uploadArea.style.border = '2px dashed #b33a3a !important';
                }
                
                isValid = false;
            }
        }
    }
    
    // If validation fails, prevent form submission
    if (!isValid) {
        e.preventDefault();
        // Scroll to the first error
        const firstError = document.querySelector('.validation-error');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
}

function validatePhoneNumber(phone) {
    // Simple validation for Philippine numbers
    // Allows formats like: +639XXXXXXXXX, 09XXXXXXXXX, 639XXXXXXXXX
    const re = /^(\+?63|0)9\d{9}$/;
    return re.test(phone);
}

function showValidationError(input, message) {
    console.log('Adding validation error:', message, 'to input:', input.id);
    
    // Remove any existing error for this input
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

// Form Validation
function validateForm(e) {
    const registrationType = document.querySelector(SELECTORS.REGISTRATION_TYPE)?.value;
    let isValid = true;

    // Clear previous errors
    clearValidationErrors();

    // Name validation
    if (!document.querySelector(SELECTORS.NAME_INPUT).value.trim()) {
        showValidationError(SELECTORS.NAME_INPUT, 'Name is required!');
        isValid = false;
    }

    // Registration type specific validations
    if (registrationType === 'online') {
        if (!document.querySelector(SELECTORS.ADDRESS_INPUT).value.trim()) {
            showValidationError(SELECTORS.ADDRESS_INPUT, 'Address is required for online registration!');
            isValid = false;
        }
    } else if (registrationType === 'onsite') {
        if (!document.querySelector(SELECTORS.COLLEGE_INPUT).value.trim()) {
            showValidationError(SELECTORS.COLLEGE_INPUT, 'College is required for onsite registration!');
            isValid = false;
        }
    }

    // Image validation
    if (!imageInput.files.length && !document.querySelector(SELECTORS.EXISTING_IMAGE).value) {
        showValidationError(SELECTORS.IMAGE_INPUT, 'Please upload your COR screenshot!');
        isValid = false;
    }

    if (!isValid) {
        e.preventDefault();
    }
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
    document.querySelectorAll('.error-message').forEach(el => el.remove());
}

// Back Button Handler
function handleBackButton(e) {
    if (formHasData()) {
        if (!confirm('Are you sure? Unsaved changes will be lost.')) {
            e.preventDefault();
            return;
        }
    }
    window.location.href = '?reset=1';
}

function formHasData() {
    // Implement logic to check if form has unsaved data
    return false;
}

// Program Loading
let fetchController = null;

async function loadPrograms(collegeId) {
    if (!programSelect) return;

    // Abort previous request if exists
    if (fetchController) {
        fetchController.abort();
    }
    fetchController = new AbortController();

    // Reset program select
    programSelect.innerHTML = '<option value="">Loading programs...</option>';
    programSelect.disabled = false;

    if (!collegeId) {
        programSelect.innerHTML = '<option value="">Select College First</option>';
        programSelect.disabled = true;
        return;
    }

    try {
        const response = await fetch(`/msaconnect/handler/admin/getProgramsByCollege.php?college_id=${collegeId}`, {
            signal: fetchController.signal
        });

        if (!response.ok) {
            const errorText = await response.text();
            throw new Error(errorText || `HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        if (!data || !data.success) {
            throw new Error(data.error || 'Invalid data received');
        }

        if (!data.data || data.data.length === 0) {
            programSelect.innerHTML = '<option value="">No programs available</option>';
            return;
        }

        programSelect.innerHTML = data.data.reduce((options, program) => {
            return options + `<option value="${program.program_id}">${program.program_name}</option>`;
        }, '<option value="">Select Program</option>');

    } catch (error) {
        if (error.name !== 'AbortError') {
            console.error('Program loading error:', error);
            programSelect.innerHTML = '<option value="">Error loading programs</option>';
            // You might want to show a more user-friendly error here
        }
    } finally {
        fetchController = null;
    }
}
function toggleRegistrationTypeFields() {
    var regType = document.getElementById('registration_type').value;
    var onsiteFields = document.querySelectorAll('.onsite-only');
    var onlineFields = document.querySelectorAll('.online-only');
    var optionalIndicator = document.getElementById('optional-indicator');
    // Hide all first
    onsiteFields.forEach(function(el) { el.style.display = 'none'; });
    onlineFields.forEach(function(el) { el.style.display = 'none'; });
    if (optionalIndicator) optionalIndicator.style.display = 'none';

    // Show college/program/year for both, but required only for On-site
    var college = document.getElementById('college_id');
    var program = document.getElementById('program_id');
    var year = document.getElementById('year_level');
    var collegeSections = document.querySelectorAll('.form-section.onsite-only.online-only');
    var corFile = document.getElementById('cor_file');

    if (regType === 'On-site') {
        onsiteFields.forEach(function(el) { el.style.display = ''; });
        collegeSections.forEach(function(el) { el.style.display = ''; });
        if (college) college.required = true;
        if (program) program.required = true;
        if (year) year.required = true;
        if (corFile) corFile.required = true;
    } else if (regType === 'Online') {
        onlineFields.forEach(function(el) { el.style.display = ''; });
        collegeSections.forEach(function(el) { el.style.display = ''; });
        if (college) college.required = false;
        if (program) program.required = false;
        if (year) year.required = false;
        if (corFile) corFile.required = false;
        if (optionalIndicator) optionalIndicator.style.display = '';
    }

    // Remove previous validation errors when toggling registration type
    clearValidationErrors();

    // Call the initializeAddressDropdowns function from user.js when online registration is selected
    if (regType === 'Online') {
        if (typeof regionData === 'undefined') {
            console.error('regionData is not defined, cannot initialize dropdowns');
            return;
        }
        
        if (typeof initializeAddressDropdowns === 'function') {
            // Wait a bit for all DOM elements to be visible
            setTimeout(function() {
                try {
                    initializeAddressDropdowns();
                    
                    // Auto-select Zamboanga Peninsula region
                    const regionSelect = document.getElementById('region');
                    if (regionSelect && regionSelect.options.length > 1) {
                        regionSelect.selectedIndex = 1; // Select first option after placeholder
                        regionSelect.dispatchEvent(new Event('change'));
                    }
                } catch (error) {
                    console.error('Error initializing address dropdowns:', error);
                    // Fall back to manual initialization
                    initializeAddressDropdownsManually();
                }
            }, 300);
        } else {
            console.error('initializeAddressDropdowns function not found, using fallback');
            initializeAddressDropdownsManually();
        }
    }
}

// Fallback function to manually initialize address dropdowns
function initializeAddressDropdownsManually() {
    if (typeof regionData === 'undefined') {
        console.error('regionData not defined in this scope');
        return;
    }
    
    const regionSelect = document.getElementById('region');
    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');
    const barangaySelect = document.getElementById('barangay');
    
    if (!regionSelect || !provinceSelect || !citySelect || !barangaySelect) {
        console.error('One or more address dropdown elements not found');
        return;
    }
    
    // Clear existing options
    regionSelect.innerHTML = '<option value="">Select Region</option>';
    provinceSelect.innerHTML = '<option value="">Select Province</option>';
    citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
    barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
    
    // Populate regions
    regionData.regions.forEach(region => {
        const option = document.createElement('option');
        option.value = region;
        option.textContent = region;
        regionSelect.appendChild(option);
    });
    
    // Add event listeners for cascading dropdowns
    regionSelect.addEventListener('change', function() {
        const selectedRegion = this.value;
        
        // Clear dependent dropdowns
        provinceSelect.innerHTML = '<option value="">Select Province</option>';
        citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
        
        // Populate provinces based on selected region
        if (selectedRegion && selectedRegion === 'Zamboanga Peninsula') {
            regionData.provinces.forEach(province => {
                const option = document.createElement('option');
                option.value = province;
                option.textContent = province;
                provinceSelect.appendChild(option);
            });
        }
    });
    
    provinceSelect.addEventListener('change', function() {
        const selectedProvince = this.value;
        
        // Clear dependent dropdowns
        citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
        
        // Populate cities based on selected province
        if (selectedProvince && regionData.cities[selectedProvince]) {
            regionData.cities[selectedProvince].forEach(city => {
                const option = document.createElement('option');
                option.value = city;
                option.textContent = city;
                citySelect.appendChild(option);
            });
        }
    });
    
    citySelect.addEventListener('change', function() {
        const selectedCity = this.value;
        
        // Clear barangay dropdown
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
        
        // Populate barangays based on selected city
        if (selectedCity && regionData.barangays[selectedCity]) {
            regionData.barangays[selectedCity].forEach(barangay => {
                const option = document.createElement('option');
                option.value = barangay;
                option.textContent = barangay;
                barangaySelect.appendChild(option);
            });
        }
    });
    
    // Auto-select Zamboanga Peninsula as default region
    if (regionSelect.options.length > 1) {
        regionSelect.selectedIndex = 1; // Select first option after placeholder
        regionSelect.dispatchEvent(new Event('change'));
    }
}

function updateYearLevels() {
    // For future year level updates based on program
}

// Function to load programs by college
function loadProgramsByCollege(collegeId) {
    const programSelect = document.getElementById('program_id');
    if (!programSelect || !collegeId) return;

    // Simulate API call with a simple fetch
    fetch(`/msaconn/handler/user/getProgramsByCollege.php?college_id=${collegeId}`)
        .then(response => response.json())
        .then(data => {
            programSelect.innerHTML = '<option value="">Select Program</option>';
            if (data && data.programs) {
                data.programs.forEach(program => {
                    const option = document.createElement('option');
                    option.value = program.program_id;
                    option.textContent = program.program_name;
                    programSelect.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error loading programs:', error);
            programSelect.innerHTML = '<option value="">Error loading programs</option>';
        });
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
            }
        });
    }
}

// Initialize everything when the document is ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize base functionality
    initEventListeners();
    
    // Initialize form fields based on registration type
    toggleRegistrationTypeFields();
    
    // Add change event listener to registration type
    const registrationTypeSelect = document.getElementById('registration_type');
    if (registrationTypeSelect) {
        registrationTypeSelect.addEventListener('change', function() {
            toggleRegistrationTypeFields();
            // Clear all validation errors when switching registration types
            clearValidationErrors();
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
    
    // Add input event listeners to fields
    addInputListeners();
    
    // Initialize address dropdowns if needed
    if (typeof initializeAddressDropdowns === 'function') {
        initializeAddressDropdowns();
    } else {
        initializeAddressDropdownsManually();
    }
});
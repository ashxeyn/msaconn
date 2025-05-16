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
        form.addEventListener('submit', validateForm);
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

function showValidationError(selector, message) {
    const field = document.querySelector(selector);
    if (!field) return;

    const errorElement = document.createElement('div');
    errorElement.className = 'error-message';
    errorElement.textContent = message;
    errorElement.style.color = 'red';
    errorElement.style.fontSize = '0.8rem';
    errorElement.style.marginTop = '5px';
    
    field.parentNode.appendChild(errorElement);
}

function clearValidationErrors() {
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

    if (regType === 'On-site') {
        onsiteFields.forEach(function(el) { el.style.display = ''; });
        collegeSections.forEach(function(el) { el.style.display = ''; });
        if (college) college.required = true;
        if (program) program.required = true;
        if (year) year.required = true;
    } else if (regType === 'Online') {
        onlineFields.forEach(function(el) { el.style.display = ''; });
        collegeSections.forEach(function(el) { el.style.display = ''; });
        if (college) college.required = false;
        if (program) program.required = false;
        if (year) year.required = false;
        if (optionalIndicator) optionalIndicator.style.display = '';
    }

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

// Initialize everything when the document is ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize registration form
    if (document.getElementById('registration_type')) {
        toggleRegistrationTypeFields();
    }
});
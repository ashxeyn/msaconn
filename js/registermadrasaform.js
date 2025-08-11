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

    // Correctly build the URL by going from the current directory (views/user) up to the root
    const apiUrl = '/msaconn/handler/user/fetchProgramsByCollege.php?college_id=' + collegeId;
    
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
            if (data && data.success && data.data && Array.isArray(data.data)) {
                if (data.data.length > 0) {
                    // Add program options
                    data.data.forEach(program => {
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
            
            // Try another alternative path as fallback
            const fallbackUrl = '../../handler/user/fetchProgramsByCollege.php?college_id=' + collegeId;
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
                    
                    if (data && data.success && data.data && Array.isArray(data.data) && data.data.length > 0) {
                        data.data.forEach(program => {
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
                    
                    // Last resort - try a third path
                    const lastResortUrl = '/handler/user/fetchProgramsByCollege.php?college_id=' + collegeId;
                    console.log('Trying last resort URL:', lastResortUrl);
                    
                    fetch(lastResortUrl)
                        .then(response => response.json())
                        .then(data => {
                            programSelect.innerHTML = '<option value="">Select Program</option>';
                            
                            if (data && data.success && data.data && Array.isArray(data.data) && data.data.length > 0) {
                                data.data.forEach(program => {
                                    const option = document.createElement('option');
                                    option.value = program.program_id;
                                    option.textContent = program.program_name;
                                    programSelect.appendChild(option);
                                });
                            } else {
                                programSelect.innerHTML = '<option value="">No programs found</option>';
                            }
                        })
                        .catch(e => {
                            console.error('All attempts failed:', e);
                            programSelect.innerHTML = '<option value="">Unable to load programs</option>';
                        });
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
    
    // If not valid, prevent form submission and show errors
    if (!isValid) {
        e.preventDefault(); // Only prevent default if validation fails
        
        // Scroll to the first error
        const firstError = document.querySelector('.validation-error');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    } else {
        console.log('Form validation passed, allowing form submission');
        // Allow normal form submission
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

// FIXED: Initialize address dropdowns - Now stores NAMES instead of CODES
function initAddressDropdowns() {
    console.log('Initializing address dropdowns...');
    
    const regionSelect = document.getElementById('region');
    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');
    const barangaySelect = document.getElementById('barangay');
    
    if(!regionSelect || !provinceSelect || !citySelect || !barangaySelect) {
        console.error('Address dropdown elements not found');
        return;
    }
    
    // Clear existing options
    regionSelect.innerHTML = '<option value="">Select Region</option>';
    provinceSelect.innerHTML = '<option value="">Select Province</option>';
    citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
    barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
    
    // Disable dropdowns until data is loaded
    provinceSelect.disabled = true;
    citySelect.disabled = true;
    barangaySelect.disabled = true;
    
    // Base URL for the Philippine Addresses API
    const baseApiUrl = 'https://psgc.gitlab.io/api';
    
    // Store region lookup data (name -> code mapping for API calls)
    let regionLookup = {};
    let provinceLookup = {};
    let cityLookup = {};
    
    // Load Regions
    fetch(`${baseApiUrl}/regions`)
        .then(response => response.json())
        .then(regions => {
            console.log('Loaded regions:', regions.length);
            
            // Sort regions by name
            regions.sort((a, b) => a.name.localeCompare(b.name));
            
            // Store region data for API lookups
            regions.forEach(region => {
                regionLookup[region.name] = region.code;
            });
            
            // FIXED: Add regions with NAME as value (not code)
            regions.forEach(region => {
                const option = document.createElement('option');
                option.value = region.name; // STORE NAME, NOT CODE
                option.textContent = region.name;
                regionSelect.appendChild(option);
            });
            
            regionSelect.disabled = false;
        })
        .catch(error => {
            console.error('Error loading regions:', error);
            showValidationError(regionSelect, 'Failed to load regions. Please try again later.');
        });
    
    // Handle Region Change
    regionSelect.addEventListener('change', function() {
        const selectedRegionName = this.value; // This is now the NAME
        const regionCode = regionLookup[selectedRegionName]; // Get code for API call
        
        console.log('Region selected:', selectedRegionName, 'Code:', regionCode);
        
        // Reset dependent dropdowns
        provinceSelect.innerHTML = '<option value="">Select Province</option>';
        citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
        
        provinceSelect.disabled = true;
        citySelect.disabled = true;
        barangaySelect.disabled = true;
        
        // Clear lookups
        provinceLookup = {};
        cityLookup = {};
        
        if (!regionCode) return;
        
        // Load provinces for selected region using the CODE for API call
        fetch(`${baseApiUrl}/regions/${regionCode}/provinces`)
            .then(response => response.json())
            .then(provinces => {
                console.log('Loaded provinces:', provinces.length);
                
                // Sort provinces by name
                provinces.sort((a, b) => a.name.localeCompare(b.name));
                
                // Store province data for API lookups
                provinces.forEach(province => {
                    provinceLookup[province.name] = province.code;
                });
                
                // FIXED: Add provinces with NAME as value (not code)
                provinces.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.name; // STORE NAME, NOT CODE
                    option.textContent = province.name;
                    provinceSelect.appendChild(option);
                });
                
                provinceSelect.disabled = false;
                
                // Also load highly urbanized cities for the region
                return fetch(`${baseApiUrl}/regions/${regionCode}/cities`);
            })
            .then(response => response.json())
            .then(cities => {
                if (cities && cities.length > 0) {
                    console.log('Loaded regional cities (HUCs):', cities.length);
                    
                    // Add separator for highly urbanized cities
                    const separator = document.createElement('option');
                    separator.disabled = true;
                    separator.textContent = '─────── Highly Urbanized Cities ───────';
                    citySelect.appendChild(separator);
                    
                    // Sort cities by name
                    cities.sort((a, b) => a.name.localeCompare(b.name));
                    
                    // Store city data for API lookups
                    cities.forEach(city => {
                        cityLookup[city.name] = city.code;
                    });
                    
                    // FIXED: Add independent cities with NAME as value (not code)
                    cities.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.name; // STORE NAME, NOT CODE
                        option.textContent = city.name;
                        option.dataset.type = 'huc';
                        option.classList.add('independent-city');
                        citySelect.appendChild(option);
                    });
                    
                    // Add note to select province for other cities
                    const note = document.createElement('option');
                    note.disabled = true;
                    note.textContent = '─────── Select Province for Other Cities ───────';
                    citySelect.appendChild(note);
                    
                    citySelect.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error loading provinces/cities:', error);
            });
    });
    
    // Handle Province Change
    provinceSelect.addEventListener('change', function() {
        const selectedProvinceName = this.value; // This is now the NAME
        const provinceCode = provinceLookup[selectedProvinceName]; // Get code for API call
        
        console.log('Province selected:', selectedProvinceName, 'Code:', provinceCode);
        
        // Keep existing HUCs and reset the rest
        const existingOptions = Array.from(citySelect.options);
        const hucOptions = existingOptions.filter(option => 
            option.dataset.type === 'huc' || option.disabled
        );
        
        // Reset city dropdown but keep HUCs
        citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
        hucOptions.forEach(option => {
            citySelect.appendChild(option.cloneNode(true));
        });
        
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
        barangaySelect.disabled = true;
        
        if (!provinceCode) {
            citySelect.disabled = false; // Keep enabled for HUCs
            return;
        }
        
        // Load municipalities for the selected province using the CODE for API call
        fetch(`${baseApiUrl}/provinces/${provinceCode}/municipalities`)
            .then(response => response.json())
            .then(municipalities => {
                console.log('Loaded municipalities:', municipalities.length);
                
                // Sort municipalities by name
                municipalities.sort((a, b) => a.name.localeCompare(b.name));
                
                // Store municipality data for API lookups
                municipalities.forEach(municipality => {
                    cityLookup[municipality.name] = municipality.code;
                });
                
                // Add separator if there are HUCs
                const hasHUCs = citySelect.options.length > 1;
                if (hasHUCs && municipalities.length > 0) {
                    const separator = document.createElement('option');
                    separator.disabled = true;
                    separator.textContent = '─────── Municipalities ───────';
                    citySelect.appendChild(separator);
                }
                
                // FIXED: Add municipalities with NAME as value (not code)
                municipalities.forEach(municipality => {
                    const option = document.createElement('option');
                    option.value = municipality.name; // STORE NAME, NOT CODE
                    option.textContent = municipality.name;
                    option.dataset.type = 'municipality';
                    citySelect.appendChild(option);
                });
                
                // Also load component cities for the province
                return fetch(`${baseApiUrl}/provinces/${provinceCode}/cities`);
            })
            .then(response => response.json())
            .then(cities => {
                if (cities && cities.length > 0) {
                    console.log('Loaded component cities:', cities.length);
                    
                    // Sort cities by name
                    cities.sort((a, b) => a.name.localeCompare(b.name));
                    
                    // Store city data for API lookups
                    cities.forEach(city => {
                        cityLookup[city.name] = city.code;
                    });
                    
                    // Add separator for component cities
                    const hasOtherOptions = Array.from(citySelect.options).some(opt => 
                        opt.dataset.type === 'municipality' || opt.dataset.type === 'huc'
                    );
                    
                    if (hasOtherOptions) {
                        const separator = document.createElement('option');
                        separator.disabled = true;
                        separator.textContent = '─────── Component Cities ───────';
                        citySelect.appendChild(separator);
                    }
                    
                    // FIXED: Add component cities with NAME as value (not code)
                    cities.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.name; // STORE NAME, NOT CODE
                        option.textContent = city.name;
                        option.dataset.type = 'component-city';
                        citySelect.appendChild(option);
                    });
                }
                
                citySelect.disabled = false;
            })
            .catch(error => {
                console.error('Error loading municipalities/cities:', error);
                citySelect.disabled = false;
                showValidationError(citySelect, 'Failed to load municipalities/cities. Please try again later.');
            });
    });
    
    // Handle City Change
    citySelect.addEventListener('change', function() {
        const selectedCityName = this.value; // This is now the NAME
        const cityCode = cityLookup[selectedCityName]; // Get code for API call
        const selectedOption = this.options[this.selectedIndex];
        const cityType = selectedOption ? selectedOption.dataset.type : null;
        
        console.log('City selected:', selectedCityName, 'Code:', cityCode, 'Type:', cityType);
        
        // Reset barangay dropdown
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
        barangaySelect.disabled = true;
        
        if (!cityCode || !selectedCityName) return;
        
        // Determine API endpoint based on city type
        let apiUrl;
        if (cityType === 'municipality') {
            apiUrl = `${baseApiUrl}/municipalities/${cityCode}/barangays`;
        } else {
            // For both HUC and component cities
            apiUrl = `${baseApiUrl}/cities/${cityCode}/barangays`;
        }
        
        // Load barangays using the CODE for API call
        fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
                    // Fallback: try the other endpoint
                    const fallbackUrl = cityType === 'municipality' 
                        ? `${baseApiUrl}/cities/${cityCode}/barangays`
                        : `${baseApiUrl}/municipalities/${cityCode}/barangays`;
                    return fetch(fallbackUrl);
                }
                return response;
            })
            .then(response => response.json())
            .then(barangays => {
                console.log('Loaded barangays:', barangays.length);
                
                // Sort barangays by name
                barangays.sort((a, b) => a.name.localeCompare(b.name));
                
                // FIXED: Add barangays with NAME as value (already correct - API returns name)
                barangays.forEach(barangay => {
                    const option = document.createElement('option');
                    option.value = barangay.name; // This is already NAME, which is correct
                    option.textContent = barangay.name;
                    barangaySelect.appendChild(option);
                });
                
                barangaySelect.disabled = false;
            })
            .catch(error => {
                console.error('Error loading barangays:', error);
                barangaySelect.disabled = false;
                showValidationError(barangaySelect, 'Failed to load barangays. Please try again later.');
            });
    });
}

// Initialize everything when the document is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded - initializing form validation');
    
    // Initialize address dropdowns with fixed implementation
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
});
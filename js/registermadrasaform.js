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

function removeImage() {
    const fileInput = document.getElementById('cor_file');
    const previewDiv = document.getElementById('image-preview');
    const placeholder = document.getElementById('upload-placeholder');
    
    fileInput.value = '';
    previewDiv.style.display = 'none';
    placeholder.style.display = 'flex';
}

function toggleRegistrationTypeFields() {
    var regType = document.getElementById('registration_type').value;
    var onsiteFields = document.querySelectorAll('.onsite-only');
    var onlineFields = document.querySelectorAll('.online-only');
    var optionalIndicator = document.getElementById('optional-indicator');
    
    clearValidationErrors();
    
    onsiteFields.forEach(function(el) { 
        if (!el.classList.contains('online-only')) {
            el.style.display = 'none'; 
        }
    });
    
    onlineFields.forEach(function(el) { 
        el.style.display = 'none';
    });
    
    if (optionalIndicator) optionalIndicator.style.display = 'none';

    var middleName = document.getElementById('middle_name');
    var college = document.getElementById('college_id');
    var program = document.getElementById('program_id');
    var year = document.getElementById('year_level');
    var collegeSections = document.querySelectorAll('.form-section.onsite-only.online-only');
    var corFile = document.getElementById('cor_file');
    
    document.querySelector('.address-fields').style.display = 'block';
    
    if (middleName) middleName.required = true;

    if (regType === 'On-site') {
        onsiteFields.forEach(function(el) { 
            el.style.display = 'block';
        });
        
        collegeSections.forEach(function(el) { 
            el.style.display = 'block';
        });
        
        if (college) college.required = true;
        if (program) program.required = true;
        if (year) year.required = true;
        if (corFile) corFile.required = true;
    } else if (regType === 'Online') {
        onlineFields.forEach(function(el) { 
            el.style.display = 'block';
        });
        
        collegeSections.forEach(function(el) { 
            el.style.display = 'block';
        });
        
        if (college) college.required = false;
        if (program) program.required = false;
        if (year) year.required = false;
        if (corFile) corFile.required = false;
        
        if (optionalIndicator) optionalIndicator.style.display = 'block';
    }
}

function loadProgramsByCollege(collegeId) {
    const programSelect = document.getElementById('program_id');
    if (!programSelect || !collegeId) return;

    programSelect.innerHTML = '<option value="">Loading programs...</option>';

    const apiUrl = '/msaconn/handler/user/fetchProgramsByCollege.php?college_id=' + collegeId;
    
    console.log('Fetching programs from:', apiUrl);
    
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
            
            programSelect.innerHTML = '<option value="">Select Program</option>';
            
            if (data && data.success && data.data && Array.isArray(data.data)) {
                if (data.data.length > 0) {
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

function clearValidationErrors() {
    document.querySelectorAll('.validation-error').forEach(el => el.remove());
    
    document.querySelectorAll('.invalid').forEach(input => {
        input.classList.remove('invalid');
    });
    
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
}

function validatePhoneNumber(phone) {
    const re = /^(\+?63|0)9\d{9}$/;
    return re.test(phone);
}

function showValidationError(inputId, message) {
    const input = typeof inputId === 'string' ? document.getElementById(inputId) : inputId;
    if (!input) return;
    
    const existingError = input.nextElementSibling;
    if (existingError && existingError.classList.contains('validation-error')) {
        existingError.remove();
    }
    
    const errorSpan = document.createElement('span');
    errorSpan.classList.add('validation-error');
    errorSpan.textContent = message;
    
    errorSpan.style.cssText = 'color: #b33a3a !important; font-size: 13px !important; display: block !important; margin-top: 5px !important; margin-bottom: 10px !important; font-style: italic !important;';
    
    if (input.type === 'file') {
        const uploadContainer = input.closest('.upload-container');
        if (uploadContainer) {
            uploadContainer.appendChild(errorSpan);
        }
    } else {
        input.parentNode.insertBefore(errorSpan, input.nextSibling);
    }
    
    input.classList.add('invalid');
}

function validateMadrasaFormDirect(e) {
    console.log('Validating form...');
    
    let isValid = true;
    
    clearValidationErrors();
    
    const regType = document.getElementById('registration_type').value;
    
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
    
    requiredFields.forEach(field => {
        const input = document.getElementById(field.id);
        if (input && !input.value.trim()) {
            showValidationError(input, field.message);
            isValid = false;
        }
    });
    
    const emailInput = document.getElementById('email');
    if (emailInput && emailInput.value.trim() && !validateEmail(emailInput.value)) {
        showValidationError(emailInput, 'Invalid email format');
        isValid = false;
    }
    
    const contactInput = document.getElementById('contact_number');
    if (contactInput && contactInput.value.trim() && !validatePhoneNumber(contactInput.value)) {
        showValidationError(contactInput, 'Invalid phone number format');
        isValid = false;
    }
    
    if (regType === 'On-site') {
        const collegeField = document.getElementById('college_id');
        if (collegeField && !collegeField.value) {
            showValidationError(collegeField, 'College is required for On-site registration');
            isValid = false;
        }
        
        const programField = document.getElementById('program_id');
        if (programField && !programField.value) {
            showValidationError(programField, 'Program is required for On-site registration');
            isValid = false;
        }
        
        const yearField = document.getElementById('year_level');
        if (yearField && !yearField.value) {
            showValidationError(yearField, 'Year level is required for On-site registration');
            isValid = false;
        }
        
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
    
    if (!isValid) {
        e.preventDefault(); 
        
        const firstError = document.querySelector('.validation-error');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    } else {
        console.log('Form validation passed, allowing form submission');
    }
    
    return isValid;
}

function addInputListeners() {
    const formInputs = document.querySelectorAll('input, select');
    formInputs.forEach(input => {
        input.addEventListener('input', function() {
            const nextSibling = this.nextElementSibling;
            if (nextSibling && nextSibling.classList.contains('validation-error')) {
                nextSibling.remove();
            }
            this.classList.remove('invalid');
            
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
    
    const corFileInput = document.getElementById('cor_file');
    if (corFileInput) {
        corFileInput.addEventListener('change', function() {
            const uploadContainer = this.closest('.upload-container');
            if (uploadContainer) {
                const errorMsg = uploadContainer.querySelector('.validation-error');
                if (errorMsg) errorMsg.remove();
                
                const uploadArea = uploadContainer.querySelector('.upload-area');
                if (uploadArea) {
                    uploadArea.style.border = '2px dashed #1a541c !important';
                }
            }
        });
    }
}

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
    
    regionSelect.innerHTML = '<option value="">Select Region</option>';
    provinceSelect.innerHTML = '<option value="">Select Province</option>';
    citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
    barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
    
    provinceSelect.disabled = true;
    citySelect.disabled = true;
    barangaySelect.disabled = true;
    
    const baseApiUrl = 'https://psgc.gitlab.io/api';
    
    let regionLookup = {};
    let provinceLookup = {};
    let cityLookup = {};
    
    fetch(`${baseApiUrl}/regions`)
        .then(response => response.json())
        .then(regions => {
            console.log('Loaded regions:', regions.length);
            
            regions.sort((a, b) => a.name.localeCompare(b.name));
            
            regions.forEach(region => {
                regionLookup[region.name] = region.code;
            });
            
            regions.forEach(region => {
                const option = document.createElement('option');
                option.value = region.name; 
                option.textContent = region.name;
                regionSelect.appendChild(option);
            });
            
            regionSelect.disabled = false;
        })
        .catch(error => {
            console.error('Error loading regions:', error);
            showValidationError(regionSelect, 'Failed to load regions. Please try again later.');
        });
    
    regionSelect.addEventListener('change', function() {
        const selectedRegionName = this.value; 
        const regionCode = regionLookup[selectedRegionName]; 
        
        console.log('Region selected:', selectedRegionName, 'Code:', regionCode);
        
        provinceSelect.innerHTML = '<option value="">Select Province</option>';
        citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
        
        provinceSelect.disabled = true;
        citySelect.disabled = true;
        barangaySelect.disabled = true;
        
        provinceLookup = {};
        cityLookup = {};
        
        if (!regionCode) return;
        
        fetch(`${baseApiUrl}/regions/${regionCode}/provinces`)
            .then(response => response.json())
            .then(provinces => {
                console.log('Loaded provinces:', provinces.length);
                
                provinces.sort((a, b) => a.name.localeCompare(b.name));
                
                provinces.forEach(province => {
                    provinceLookup[province.name] = province.code;
                });
                
                provinces.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.name; 
                    option.textContent = province.name;
                    provinceSelect.appendChild(option);
                });
                
                provinceSelect.disabled = false;
                
                return fetch(`${baseApiUrl}/regions/${regionCode}/cities`);
            })
            .then(response => response.json())
            .then(cities => {
                if (cities && cities.length > 0) {
                    console.log('Loaded regional cities (HUCs):', cities.length);
                    
                    const separator = document.createElement('option');
                    separator.disabled = true;
                    separator.textContent = '─────── Highly Urbanized Cities ───────';
                    citySelect.appendChild(separator);
                    
                    cities.sort((a, b) => a.name.localeCompare(b.name));
                    
                    cities.forEach(city => {
                        cityLookup[city.name] = city.code;
                    });
                    
                    cities.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.name; 
                        option.textContent = city.name;
                        option.dataset.type = 'huc';
                        option.classList.add('independent-city');
                        citySelect.appendChild(option);
                    });
                    
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
    
    provinceSelect.addEventListener('change', function() {
        const selectedProvinceName = this.value; 
        const provinceCode = provinceLookup[selectedProvinceName]; 
        
        console.log('Province selected:', selectedProvinceName, 'Code:', provinceCode);
        
        const existingOptions = Array.from(citySelect.options);
        const hucOptions = existingOptions.filter(option => 
            option.dataset.type === 'huc' || option.disabled
        );
        
        citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
        hucOptions.forEach(option => {
            citySelect.appendChild(option.cloneNode(true));
        });
        
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
        barangaySelect.disabled = true;
        
        if (!provinceCode) {
            citySelect.disabled = false; 
            return;
        }
        
        fetch(`${baseApiUrl}/provinces/${provinceCode}/municipalities`)
            .then(response => response.json())
            .then(municipalities => {
                console.log('Loaded municipalities:', municipalities.length);
                
                municipalities.sort((a, b) => a.name.localeCompare(b.name));
                
                municipalities.forEach(municipality => {
                    cityLookup[municipality.name] = municipality.code;
                });
                
                const hasHUCs = citySelect.options.length > 1;
                if (hasHUCs && municipalities.length > 0) {
                    const separator = document.createElement('option');
                    separator.disabled = true;
                    separator.textContent = '─────── Municipalities ───────';
                    citySelect.appendChild(separator);
                }
                
                municipalities.forEach(municipality => {
                    const option = document.createElement('option');
                    option.value = municipality.name; 
                    option.textContent = municipality.name;
                    option.dataset.type = 'municipality';
                    citySelect.appendChild(option);
                });
                
                return fetch(`${baseApiUrl}/provinces/${provinceCode}/cities`);
            })
            .then(response => response.json())
            .then(cities => {
                if (cities && cities.length > 0) {
                    console.log('Loaded component cities:', cities.length);
                    
                    cities.sort((a, b) => a.name.localeCompare(b.name));
                    
                    cities.forEach(city => {
                        cityLookup[city.name] = city.code;
                    });
                    
                    const hasOtherOptions = Array.from(citySelect.options).some(opt => 
                        opt.dataset.type === 'municipality' || opt.dataset.type === 'huc'
                    );
                    
                    if (hasOtherOptions) {
                        const separator = document.createElement('option');
                        separator.disabled = true;
                        separator.textContent = '─────── Component Cities ───────';
                        citySelect.appendChild(separator);
                    }
                    
                    cities.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.name; 
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
    
    citySelect.addEventListener('change', function() {
        const selectedCityName = this.value; 
        const cityCode = cityLookup[selectedCityName]; 
        const selectedOption = this.options[this.selectedIndex];
        const cityType = selectedOption ? selectedOption.dataset.type : null;
        
        console.log('City selected:', selectedCityName, 'Code:', cityCode, 'Type:', cityType);
        
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
        barangaySelect.disabled = true;
        
        if (!cityCode || !selectedCityName) return;
        
        let apiUrl;
        if (cityType === 'municipality') {
            apiUrl = `${baseApiUrl}/municipalities/${cityCode}/barangays`;
        } else {
            apiUrl = `${baseApiUrl}/cities/${cityCode}/barangays`;
        }
        
        fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
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
                
                barangays.sort((a, b) => a.name.localeCompare(b.name));
                
                barangays.forEach(barangay => {
                    const option = document.createElement('option');
                    option.value = barangay.name; 
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

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded - initializing form validation');
    
    initAddressDropdowns();
    
    const registrationTypeSelect = document.getElementById('registration_type');
    if (registrationTypeSelect) {
        toggleRegistrationTypeFields();
        
        registrationTypeSelect.addEventListener('change', function() {
            toggleRegistrationTypeFields();
        });
    }
    
    const collegeSelect = document.getElementById('college_id');
    if (collegeSelect) {
        collegeSelect.addEventListener('change', function() {
            loadProgramsByCollege(this.value);
            
            const nextSibling = this.nextElementSibling;
            if (nextSibling && nextSibling.classList.contains('validation-error')) {
                nextSibling.remove();
            }
            this.classList.remove('invalid');
        });
        
        if (collegeSelect.value) {
            loadProgramsByCollege(collegeSelect.value);
        }
    }
    
    addInputListeners();
});
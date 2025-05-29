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
    const fileInput = document.getElementById('image');
    const previewDiv = document.getElementById('image-preview');
    const placeholder = document.getElementById('upload-placeholder');
    
    fileInput.value = '';
    previewDiv.style.display = 'none';
    placeholder.style.display = 'flex';
}

// Function to load programs based on selected college
function loadProgramsByCollege(collegeId) {
    const programSelect = document.getElementById('program');
    
    // Reset program select
    programSelect.innerHTML = '<option value="">Loading programs...</option>';
    
    if (!collegeId) {
        programSelect.innerHTML = '<option value="">Select College First</option>';
        return;
    }
    
    // Get base URL dynamically - FIX: Change the path to point to the correct location
    const baseUrl = window.location.protocol + '//' + window.location.host + '/msaconn';
    const apiUrl = `${baseUrl}/handler/user/fetchProgramsByCollege.php?college_id=${collegeId}`;
    
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
            if (data && data.success === true && Array.isArray(data.data)) {
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
            
            // Try fallback approach with direct URL
            if (error.message.includes('Network response was not ok')) {
                const fallbackUrl = `/msaconn/handler/user/fetchProgramsByCollege.php?college_id=${collegeId}`;
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
                        
                        if (data && data.success === true && Array.isArray(data.data) && data.data.length > 0) {
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
                        programSelect.innerHTML = '<option value="">Error loading programs</option>';
                    });
            }
        });
}

// Function to validate form before submission
function validateForm() {
    const collegeSelect = document.getElementById('college');
    const programSelect = document.getElementById('program');
    
    // If either college or program is not selected, the PHP validation will handle it
    if (!collegeSelect.value || !programSelect.value) {
        return true;
    }
    
    // Check if the program belongs to the college
    // This is a redundant check since the dropdown should only contain programs for the selected college
    // But it's a good practice for security
    
    return true;
}

// Function to show error message
function showError(inputId, message) {
    const errorSpan = document.getElementById(inputId + '-error');
    const inputElement = document.getElementById(inputId);
    
    if (errorSpan) {
        errorSpan.textContent = message;
        // Apply the error message styling to match Registermadrasaform.php
        errorSpan.style.color = '#b33a3a';
        errorSpan.style.fontSize = '13px';
        errorSpan.style.display = 'block';
        errorSpan.style.marginTop = '5px';
        errorSpan.style.marginBottom = '10px';
        errorSpan.style.fontStyle = 'italic';
        errorSpan.style.fontFamily = "'Noto Naskh Arabic', serif";
    }
    
    // Add the invalid class to the input element
    if (inputElement) {
        inputElement.classList.add('invalid');
    }
}

// Function to clear error message
function clearError(inputId) {
    const errorSpan = document.getElementById(inputId + '-error');
    const inputElement = document.getElementById(inputId);
    
    if (errorSpan) {
        errorSpan.textContent = '';
    }
    
    // Remove the invalid class from the input element
    if (inputElement) {
        inputElement.classList.remove('invalid');
    }
}

// Function to validate form fields
function validateFormFields() {
    let valid = true;

    // First Name
    const firstname = document.getElementById('firstname');
    if (!firstname.value.trim()) {
        showError('firstname', 'First name is required');
        valid = false;
    } else {
        clearError('firstname');
    }

    // Middle Name
    const middlename = document.getElementById('middlename');
    if (!middlename.value.trim()) {
        // Middle name is optional, no error needed
        clearError('middlename');
    } else {
        clearError('middlename');
    }

    // Last Name
    const lastname = document.getElementById('lastname');
    if (!lastname.value.trim()) {
        showError('lastname', 'Last name is required');
        valid = false;
    } else {
        clearError('lastname');
    }

    // College
    const college = document.getElementById('college');
    if (!college.value) {
        showError('college', 'Please select a college');
        valid = false;
    } else {
        clearError('college');
    }

    // Program
    const program = document.getElementById('program');
    if (!program.value) {
        showError('program', 'Please select a program');
        valid = false;
    } else {
        clearError('program');
    }

    // Year
    const year = document.getElementById('year');
    if (!year.value) {
        showError('year', 'Please select year level');
        valid = false;
    } else {
        clearError('year');
    }

    // Contact
    const contact = document.getElementById('contact');
    if (!contact.value.trim()) {
        showError('contact', 'Please enter contact number');
        valid = false;
    } else {
        clearError('contact');
    }

    // Email
    const email = document.getElementById('email');
    if (!email.value.trim()) {
        showError('email', 'Please enter email');
        valid = false;
    } else {
        clearError('email');
    }

    // COR Image
    const image = document.getElementById('image');
    const existingImage = document.querySelector('input[name="existing_image"]');
    if ((!image.value || image.files.length === 0) && (!existingImage || !existingImage.value)) {
        showError('image', 'Please upload your COR screenshot');
        // Add a red border to the upload area
        const uploadArea = document.querySelector('.upload-area');
        if (uploadArea) {
            uploadArea.style.border = '2px dashed #b33a3a';
        }
        valid = false;
    } else {
        clearError('image');
        // Reset the border color
        const uploadArea = document.querySelector('.upload-area');
        if (uploadArea) {
            uploadArea.style.border = '2px dashed #1a541c';
        }
    }

    return valid;
}

// Initialize program dropdown if college is already selected on page load
document.addEventListener('DOMContentLoaded', function() {
    const collegeSelect = document.getElementById('college');
    
    // Add event listener directly in the JS file to ensure it's properly attached
    if (collegeSelect) {
        collegeSelect.addEventListener('change', function() {
            loadProgramsByCollege(this.value);
        });
        
        // Load programs if a college is already selected
        if (collegeSelect.value) {
            loadProgramsByCollege(collegeSelect.value);
        }
    }
    
    // Add form submission validation
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateFormFields()) {
                e.preventDefault();
                
                // Scroll to the first error
                const firstError = document.querySelector('.error-message:not(:empty)');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    }

    // Add input event listeners to clear validation errors when user types
    const allInputs = document.querySelectorAll('input, select');
    allInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearError(this.id);
        });
    });
    
    // Special handler for file input
    const fileInput = document.getElementById('image');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            clearError('image');
            // Reset the border color
            const uploadArea = document.querySelector('.upload-area');
            if (uploadArea) {
                uploadArea.style.border = '2px dashed #1a541c';
            }
        });
    }
});

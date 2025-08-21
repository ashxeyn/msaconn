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
    const fileInput = document.getElementById('image');
    const previewDiv = document.getElementById('image-preview');
    const placeholder = document.getElementById('upload-placeholder');
    
    fileInput.value = '';
    previewDiv.style.display = 'none';
    placeholder.style.display = 'flex';
}

function loadProgramsByCollege(collegeId) {
    const programSelect = document.getElementById('program');
    
    programSelect.innerHTML = '<option value="">Loading programs...</option>';
    
    if (!collegeId) {
        programSelect.innerHTML = '<option value="">Select College First</option>';
        return;
    }
    
    const baseUrl = window.location.protocol + '//' + window.location.host + '/msaconn';
    const apiUrl = `${baseUrl}/handler/user/fetchProgramsByCollege.php?college_id=${collegeId}`;
    
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
            
            if (data && data.success === true && Array.isArray(data.data)) {
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

function validateForm() {
    const collegeSelect = document.getElementById('college');
    const programSelect = document.getElementById('program');
    
    if (!collegeSelect.value || !programSelect.value) {
        return true;
    }
    
    
    return true;
}

function showError(inputId, message) {
    const errorSpan = document.getElementById(inputId + '-error');
    const inputElement = document.getElementById(inputId);
    
    if (errorSpan) {
        errorSpan.textContent = message;
        errorSpan.style.color = '#b33a3a';
        errorSpan.style.fontSize = '13px';
        errorSpan.style.display = 'block';
        errorSpan.style.marginTop = '5px';
        errorSpan.style.marginBottom = '10px';
        errorSpan.style.fontStyle = 'italic';
        errorSpan.style.fontFamily = "'Noto Naskh Arabic', serif";
    }
    
    if (inputElement) {
        inputElement.classList.add('invalid');
    }
}

function clearError(inputId) {
    const errorSpan = document.getElementById(inputId + '-error');
    const inputElement = document.getElementById(inputId);
    
    if (errorSpan) {
        errorSpan.textContent = '';
    }
    
    if (inputElement) {
        inputElement.classList.remove('invalid');
    }
}

function validateFormFields() {
    let valid = true;

    const firstname = document.getElementById('firstname');
    if (!firstname.value.trim()) {
        showError('firstname', 'First name is required');
        valid = false;
    } else {
        clearError('firstname');
    }

    const middlename = document.getElementById('middlename');
    if (!middlename.value.trim()) {
        clearError('middlename');
    } else {
        clearError('middlename');
    }

    const lastname = document.getElementById('lastname');
    if (!lastname.value.trim()) {
        showError('lastname', 'Last name is required');
        valid = false;
    } else {
        clearError('lastname');
    }

    const college = document.getElementById('college');
    if (!college.value) {
        showError('college', 'Please select a college');
        valid = false;
    } else {
        clearError('college');
    }

    const program = document.getElementById('program');
    if (!program.value) {
        showError('program', 'Please select a program');
        valid = false;
    } else {
        clearError('program');
    }

    const year = document.getElementById('year');
    if (!year.value) {
        showError('year', 'Please select year level');
        valid = false;
    } else {
        clearError('year');
    }

    const contact = document.getElementById('contact');
    if (!contact.value.trim()) {
        showError('contact', 'Please enter contact number');
        valid = false;
    } else {
        clearError('contact');
    }

    const email = document.getElementById('email');
    if (!email.value.trim()) {
        showError('email', 'Please enter email');
        valid = false;
    } else {
        clearError('email');
    }

    const image = document.getElementById('image');
    const existingImage = document.querySelector('input[name="existing_image"]');
    if ((!image.value || image.files.length === 0) && (!existingImage || !existingImage.value)) {
        showError('image', 'Please upload your COR screenshot');
        const uploadArea = document.querySelector('.upload-area');
        if (uploadArea) {
            uploadArea.style.border = '2px dashed #b33a3a';
        }
        valid = false;
    } else {
        clearError('image');
        const uploadArea = document.querySelector('.upload-area');
        if (uploadArea) {
            uploadArea.style.border = '2px dashed #1a541c';
        }
    }

    return valid;
}

document.addEventListener('DOMContentLoaded', function() {
    const collegeSelect = document.getElementById('college');
    
    if (collegeSelect) {
        collegeSelect.addEventListener('change', function() {
            loadProgramsByCollege(this.value);
        });
        
        if (collegeSelect.value) {
            loadProgramsByCollege(collegeSelect.value);
        }
    }
    
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateFormFields()) {
                e.preventDefault();
                
                const firstError = document.querySelector('.error-message:not(:empty)');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    }

    const allInputs = document.querySelectorAll('input, select');
    allInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearError(this.id);
        });
    });
    
    const fileInput = document.getElementById('image');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            clearError('image');
            const uploadArea = document.querySelector('.upload-area');
            if (uploadArea) {
                uploadArea.style.border = '2px dashed #1a541c';
            }
        });
    }
});

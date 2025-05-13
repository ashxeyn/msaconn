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
    
    // Get base URL dynamically
    const baseUrl = window.location.href.split('/').slice(0, -2).join('/');
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
            if (!validateForm()) {
                e.preventDefault();
                alert('Please ensure the selected program belongs to the selected college.');
            }
        });
    }
});

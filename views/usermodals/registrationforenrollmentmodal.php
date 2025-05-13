<div id="registrationSuccessModal" class="modal" style="display: block;">
    <div class="modal-content">
        <span class="close-button" onclick="closeRegistrationModal()">&times;</span>
        <div class="success-icon">
            <i class="fa fa-check-circle"></i>
        </div>
        <h2>Registration Successful!</h2>
        <p>You have successfully registered for Madrasa Enrollment.</p>
        <p>Your registration has been received and is being processed.</p>
        <div class="modal-actions">
            <button type="button" class="close-modal-btn" onclick="closeRegistrationModal()">Close</button>
        </div>
    </div>
</div>

<script>
    function closeRegistrationModal() {
        document.getElementById("registrationSuccessModal").style.display = "none";
        window.location.href = "registrationmadrasa.php";
    }
    
    // Auto close after 5 seconds
    setTimeout(function() {
        closeRegistrationModal();
    }, 5000);
    
    // Ensure modal is visible
    document.addEventListener("DOMContentLoaded", function() {
        var modal = document.getElementById("registrationSuccessModal");
        if (modal) {
            modal.style.display = "block";
            modal.addEventListener("click", function(e) {
                if (e.target === this) {
                    closeRegistrationModal();
                }
            });
        }
    });
</script>

<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
    }
    
    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        width: 90%;
        max-width: 500px;
        text-align: center;
    }
    
    .close-button {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }
    
    .close-button:hover {
        color: #333;
    }
    
    .success-icon {
        font-size: 60px;
        color: #4CAF50;
        margin-bottom: 20px;
    }
    
    h2 {
        color: #333;
        margin-bottom: 15px;
    }
    
    .modal-actions {
        margin-top: 25px;
    }
    
    .close-modal-btn {
        background-color: #d72f2f;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.3s;
    }
    
    .close-modal-btn:hover {
        background-color: #b12828;
    }
</style>

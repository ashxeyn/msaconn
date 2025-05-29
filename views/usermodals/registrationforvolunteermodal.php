<!-- filepath: c:\xampp\htdocs\msaconn\views\usermodals\registrationforvolunteermodal.php -->

<div id="successModal" class="modal" style="display: block !important;">
    <div class="modal-content">
        <div class="success-icon">
            <i class="fa fa-check-circle"></i>
        </div>
        <h2>Registration Received</h2>
        <p>Your registration for volunteer has been received and will be processed by our team.</p>
        <div class="modal-actions">
            <button type="button" class="close-modal-btn" onclick="closeVolunteerModal()">Close</button>
        </div>
    </div>
</div>

<script>
    function closeVolunteerModal() {
        document.getElementById("successModal").style.display = "none";
        window.location.href = "volunteer.php";
    }
    
    // Auto close after 5 seconds
    setTimeout(function() {
        closeVolunteerModal();
    }, 5000);
    
    // Ensure modal is visible when page loads
    window.onload = function() {
        var modal = document.getElementById("successModal");
        if (modal) {
            modal.style.display = "block";
            modal.addEventListener("click", function(e) {
                if (e.target === this) {
                    closeVolunteerModal();
                }
            });
        }
    };
</script>

<style>
    .modal {
        display: block; /* Changed from 'none' to 'block' to make sure it's visible */
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
<!-- filepath: c:\xampp\htdocs\msaconnect\views\usermodals\registrationforvolunteermodal.php -->
<div id="successModal" class="modal" style="display: block;">
    <div class="modal-content">
        <span class="close-button" onclick="this.parentElement.parentElement.style.display='none'">&times;</span>
        <h2>Registration Successful!</h2>
        <p>You have successfully registered as a volunteer.</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Close the modal when clicking outside of it
    var modal = document.getElementById('successModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = 'none';
            }
        });
    }
});
</script>
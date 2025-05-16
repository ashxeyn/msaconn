document.addEventListener("DOMContentLoaded", function () {
    const faqsContent = document.getElementById('faqs-content');
    
    if (faqsContent) {
        // Listen for click events on FAQ questions using event delegation
        faqsContent.addEventListener("click", function(event) {
            // Find the clicked element that has the faq-question class
            const question = event.target.closest(".faq-question");
            
            // If click was on a question
            if (question) {
                // Get the answer element (the next sibling of the question)
                const answer = question.nextElementSibling;
                
                // Toggle the open class on both the question and answer
                question.classList.toggle("open");
                answer.classList.toggle("open");
                
                // Prevent event bubbling
                event.stopPropagation();
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const faqsContent = document.getElementById('faqs-content');
    
    if (faqsContent) {
        faqsContent.addEventListener("click", function(event) {
            const question = event.target.closest(".faq-question");
            
            if (question) {
                const answer = question.nextElementSibling;
                
                question.classList.toggle("open");
                answer.classList.toggle("open");
                
                event.stopPropagation();
            }
        });
    }
});

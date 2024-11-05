
const questions = document.querySelectorAll('.faq-question');


questions.forEach(question => {
    question.addEventListener('click', () => {
        const parent = question.parentElement;
        parent.classList.toggle('active'); 


        document.querySelectorAll('.faq-item').forEach(item => {
            if (item !== parent && item.classList.contains('active')) {
                item.classList.remove('active');
            }
        });
    });
});

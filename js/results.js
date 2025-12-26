/* script.js (Quiz Logic) */
const quizContainer = document.getElementById('quiz');
const submitButton = document.getElementById('submit');
const questions = [
    {question: "When faced with a challenge, how do you respond?", options: {Hero: "Seek a solution", Sage: "Reflect on meaning", Innocent: "Avoid confrontation"}},
    {question: "How do you feel about growth?", options: {Creator: "Constantly evolving", Rebel: "Want change", Caregiver: "Strive to care for others"}}
];
let userAnswers = {};
questions.forEach((q, index) => {
    const div = document.createElement('div');
    div.innerHTML = `<h3>${q.question}</h3>`;
    Object.keys(q.options).forEach(archetype => {
        div.innerHTML += `<label><input type="radio" name="q${index}" value="${archetype}"> ${q.options[archetype]}</label><br>`;
    });
    quizContainer.appendChild(div);
});
submitButton.addEventListener('click', () => {
    document.querySelectorAll('input[type=radio]:checked').forEach(input => {
        userAnswers[input.value] = (userAnswers[input.value] || 0) + 1;
    });
    localStorage.setItem('quizResults', JSON.stringify(userAnswers));
    window.location.href = 'results.php';
});

/* results.js (Results Logic) */
const resultsContainer = document.getElementById('results');
const results = JSON.parse(localStorage.getItem('quizResults')) || {};
const total = Object.values(results).reduce((a, b) => a + b, 0);
Object.keys(results).forEach(archetype => {
    const percentage = ((results[archetype] / total) * 100).toFixed(1);
    resultsContainer.innerHTML += `<h3>${archetype}: ${percentage}%</h3>`;
});

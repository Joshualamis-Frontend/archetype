const quizData = [
    // INNOCENT
    { question: "People tell me they feel safe and comforted when I am around.", archetype: "Caregiver" },
    { question: "I can sense when someone is struggling emotionally even without being told.", archetype: "Caregiver" },
    { question: "I show care through small actions like preparing food or checking on someone.", archetype: "Caregiver" },
    { question: "I remain patient even when caring for someone who is difficult or demanding.", archetype: "Caregiver" },
    { question: "I prefer showing care through practical acts rather than emotional words.", archetype: "Caregiver" },

    // ORPHAN
    { question: "I naturally lift the atmosphere of group interactions without drawing attention to myself.", archetype: "Jester" },
    { question: "I can smoothly diffuse social awkwardness by making playful or well-timed remarks.", archetype: "Jester" },
    { question: "I tend to uplift others emotionally simply by engaging with them.", archetype: "Jester" },
    { question: "I use humor to help myself deal with stress or emotional burdens.", archetype: "Jester" },
    { question: "I embody the Filipino spirit of finding hope through humor and positivity.", archetype: "Jester" },

    // CAREGIVER
    { question: "I give advice based on the lessons I learned from my own real-life experiences.", archetype: "Sage" },
    { question: "I carefully evaluate all options before making an important decision.", archetype: "Sage" },
    { question: "I stay open to new perspectives or ideas even when they challenge what I already know.", archetype: "Sage" },
    { question: "I take the time to reflect deeply before giving advice.", archetype: "Sage" },
    { question: "People often ask for my perspective before making their own decisions.", archetype: "Sage" },

    // LOVER
    { question: "I naturally look for new ways to solve problems instead of relying on traditional methods.", archetype: "Creator" },
    { question: "I often imagine possibilities and ideas that others do not immediately notice.", archetype: "Creator" },
    { question: "I enjoy exploring creative ideas and am naturally curious about how things could be improved.", archetype: "Creator" },
    { question: "I often experiment with new methods, tools, or techniques.", archetype: "Creator" },
    { question: "I enjoy turning my ideas into tangible creations that reflect my identity.", archetype: "Creator" },

    // JESTER
    { question: "I take responsibility for the outcomes of my group’s actions.", archetype: "Leader" },
    { question: "I strive to guide and unite people during times of uncertainty.", archetype: "Leader" },
    { question: "I motivate others to take part and work together.", archetype: "Leader" },
    { question: "I act in ways that earn the trust of my community.", archetype: "Leader" },
    { question: "I stay calm and collected when others panic.", archetype: "Leader" },

    // RULER
    { question: "I adjust my plans to provide emotional closeness and reassurance to someone I love.", archetype: "Lover" },
    { question: "I feel most alive when someone I love seeks my emotional closeness and support.", archetype: "Lover" },
    { question: "I am sensitive to the emotional needs of someone I love and respond to strengthen our bond.", archetype: "Lover" },
    { question: "I maintain emotional intimacy with someone I love, even during their struggle. ", archetype: "Lover" },
    { question: "I struggle when my emotional love or support is rejected by someone I care deeply for.", archetype: "Lover" },
];

const responseScale = [
    { value: 1, label: "Strongly Disagree", description: "This statement does not describe you at all." },
    { value: 2, label: "Disagree", description: "This statement generally does not describe you." },
    { value: 3, label: "Agree", description: "This statement generally describes you." },
    { value: 4, label: "Strongly Agree", description: "This statement accurately and consistently describes you." }
];

let currentQuestion = 0;
let userResponses = {};
let userGender = "";

function startQuiz() {
    document.getElementById("intro-screen").style.display = "none";
    document.getElementById("gender-screen").style.display = "block";
    document.getElementById("gender-screen").classList.add("fade-in");
}

function selectGender(gender) {
    userGender = gender;
    document.getElementById("gender-screen").style.display = "none";
    document.getElementById("quiz-container").style.display = "block";
    document.getElementById("quiz-container").classList.add("fade-in");
    updateProgress();
    showQuestion();
}

function showQuestion() {
    if (currentQuestion >= quizData.length) {
        showResults();
        return;
    }
    let qData = quizData[currentQuestion];
    document.getElementById("question").innerText = qData.question;
    document.getElementById("question-count").innerText = `Question ${currentQuestion + 1} of ${quizData.length}`;
    
    let optionsDiv = document.getElementById("options");
    optionsDiv.innerHTML = "";
    
    // Create Likert scale buttons (1-4)
    responseScale.forEach(scale => {
        let btn = document.createElement("button");
        btn.innerText = scale.label;
        btn.classList.add("option-btn", "likert-btn");
        btn.setAttribute("title", scale.description);
        btn.onclick = () => selectOption(qData.archetype, scale.value);
        optionsDiv.appendChild(btn);
    });
    
    updateProgress();
}

function selectOption(archetype, value) {
    // Initialize archetype score if it doesn't exist
    if (!userResponses[archetype]) {
        userResponses[archetype] = 0;
    }
    // Add the rating value to the archetype's total score
    userResponses[archetype] += value;
    currentQuestion++;
    showQuestion();
}

function updateProgress() {
    document.getElementById("progress-bar").style.width = (currentQuestion / quizData.length) * 100 + "%";
}

function showResults() {
    // Find the archetype with the highest total score
    let maxArchetype = Object.keys(userResponses).reduce((a, b) => 
        userResponses[a] > userResponses[b] ? a : b
    );
    window.location.href = `result.php?archetype=${maxArchetype}&gender=${userGender}`;
}

document.getElementById("start-btn").addEventListener("click", startQuiz);

// Add event listeners for gender buttons
document.querySelectorAll(".gender-btn").forEach(btn => {
    btn.addEventListener("click", () => selectGender(btn.getAttribute("data-gender")));
});

// Initial setup
document.getElementById("gender-screen").style.display = "none";
document.getElementById("quiz-container").style.display = "none";
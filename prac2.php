<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archetype Personality Quiz</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            max-width: 800px;
            width: 100%;
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .screen {
            display: none;
        }

        .screen.active {
            display: block;
            animation: fadeIn 0.5s ease-in;
        }

        h1 {
            font-size: 2.5rem;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 2rem;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .intro-icon {
            font-size: 4rem;
            text-align: center;
            margin-bottom: 20px;
        }

        .description {
            text-align: center;
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 50px;
            cursor: pointer;
            display: block;
            margin: 0 auto;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .gender-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 30px;
        }

        .gender-btn {
            padding: 20px;
            font-size: 1.1rem;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            color: white;
        }

        .gender-btn.male {
            background: #3b82f6;
        }

        .gender-btn.female {
            background: #ec4899;
        }

        .gender-btn.other {
            background: #8b5cf6;
        }

        .gender-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .progress-container {
            margin-bottom: 30px;
        }

        .progress-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: #666;
            font-size: 0.9rem;
        }

        .progress-bar {
            width: 100%;
            height: 12px;
            background: #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea 0%, #ec4899 100%);
            transition: width 0.3s ease;
        }

        .question-text {
            font-size: 1.5rem;
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .options {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .option-btn {
            background: #f9fafb;
            border: 2px solid #e5e7eb;
            padding: 20px;
            text-align: left;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .option-btn:hover {
            background: #f3e8ff;
            border-color: #a855f7;
        }

        .option-label {
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        .option-desc {
            font-size: 0.9rem;
            color: #666;
        }

        .option-btn:hover .option-label {
            color: #7c3aed;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Intro Screen -->
        <div id="intro-screen" class="screen active">
            <div class="intro-icon"></div>
            <h1>Discover Your Archetype</h1>
            <p class="description">
                Uncover the dominant personality archetype that shapes who you are. 
                Answer honestly to get the most accurate results.
            </p>
            <button id="start-btn" class="btn">Begin Your Journey</button>
        </div>

        <!-- Gender Selection Screen -->
        <div id="gender-screen" class="screen">
            <div class="intro-icon">👥</div>
            <h2>Select Your Gender</h2>
            <p class="description">This helps us personalize your results</p>
            <div class="gender-buttons">
                <button class="gender-btn male" data-gender="male">Male</button>
                <button class="gender-btn female" data-gender="female">Female</button>
                <button class="gender-btn other" data-gender="other">Other</button>
            </div>
        </div>

        <!-- Quiz Screen -->
        <div id="quiz-container" class="screen">
            <div class="progress-container">
                <div class="progress-info">
                    <span id="question-count">Question 1 of 30</span>
                    <span id="progress-percent">0%</span>
                </div>
                <div class="progress-bar">
                    <div id="progress-bar" class="progress-fill" style="width: 0%"></div>
                </div>
            </div>
            <h3 id="question" class="question-text"></h3>
            <div id="options" class="options"></div>
        </div>
    </div>

    <script>
        const quizData = [
            { question: "People tell me they feel safe and comforted when I am around.", archetype: "Caregiver" },
            { question: "I can sense when someone is struggling emotionally even without being told.", archetype: "Caregiver" },
            { question: "I show care through small actions like preparing food or checking on someone.", archetype: "Caregiver" },
            { question: "I remain patient even when caring for someone who is difficult or demanding.", archetype: "Caregiver" },
            { question: "I prefer showing care through practical acts rather than emotional words.", archetype: "Caregiver" },
            { question: "I naturally lift the atmosphere of group interactions without drawing attention to myself.", archetype: "Jester" },
            { question: "I can smoothly diffuse social awkwardness by making playful or well-timed remarks.", archetype: "Jester" },
            { question: "I tend to uplift others emotionally simply by engaging with them.", archetype: "Jester" },
            { question: "I use humor to help myself deal with stress or emotional burdens.", archetype: "Jester" },
            { question: "I embody the Filipino spirit of finding hope through humor and positivity.", archetype: "Jester" },
            { question: "I give advice based on the lessons I learned from my own real-life experiences.", archetype: "Sage" },
            { question: "I carefully evaluate all options before making an important decision.", archetype: "Sage" },
            { question: "I stay open to new perspectives or ideas even when they challenge what I already know.", archetype: "Sage" },
            { question: "I take the time to reflect deeply before giving advice.", archetype: "Sage" },
            { question: "People often ask for my perspective before making their own decisions.", archetype: "Sage" },
            { question: "I naturally look for new ways to solve problems instead of relying on traditional methods.", archetype: "Creator" },
            { question: "I often imagine possibilities and ideas that others do not immediately notice.", archetype: "Creator" },
            { question: "I enjoy exploring creative ideas and am naturally curious about how things could be improved.", archetype: "Creator" },
            { question: "I often experiment with new methods, tools, or techniques.", archetype: "Creator" },
            { question: "I enjoy turning my ideas into tangible creations that reflect my identity.", archetype: "Creator" },
            { question: "I take responsibility for the outcomes of my group's actions.", archetype: "Leader" },
            { question: "I strive to guide and unite people during times of uncertainty.", archetype: "Leader" },
            { question: "I motivate others to take part and work together.", archetype: "Leader" },
            { question: "I act in ways that earn the trust of my community.", archetype: "Leader" },
            { question: "I stay calm and collected when others panic.", archetype: "Leader" },
            { question: "I adjust my plans to provide emotional closeness and reassurance to someone I love.", archetype: "Lover" },
            { question: "I feel most alive when someone I love seeks my emotional closeness and support.", archetype: "Lover" },
            { question: "I am sensitive to the emotional needs of someone I love and respond to strengthen our bond.", archetype: "Lover" },
            { question: "I maintain emotional intimacy with someone I love, even during their struggle.", archetype: "Lover" },
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
            document.getElementById("intro-screen").classList.remove("active");
            document.getElementById("gender-screen").classList.add("active");
        }

        function selectGender(gender) {
            userGender = gender;
            document.getElementById("gender-screen").classList.remove("active");
            document.getElementById("quiz-container").classList.add("active");
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
            
            responseScale.forEach(scale => {
                let btn = document.createElement("button");
                btn.classList.add("option-btn");
                btn.innerHTML = `
                    <span class="option-label">${scale.label}</span>
                    <span class="option-desc">${scale.description}</span>
                `;
                btn.onclick = () => selectOption(qData.archetype, scale.value);
                optionsDiv.appendChild(btn);
            });
            
            updateProgress();
        }

        function selectOption(archetype, value) {
            if (!userResponses[archetype]) {
                userResponses[archetype] = 0;
            }
            userResponses[archetype] += value;
            currentQuestion++;
            showQuestion();
        }

        function updateProgress() {
            const progress = (currentQuestion / quizData.length) * 100;
            document.getElementById("progress-bar").style.width = progress + "%";
            document.getElementById("progress-percent").innerText = Math.round(progress) + "%";
        }

        function showResults() {
            // Encode responses and gender as URL parameters
            const responsesEncoded = encodeURIComponent(JSON.stringify(userResponses));
            window.location.href = `prac.php?responses=${responsesEncoded}&gender=${userGender}`;
        }

        document.getElementById("start-btn").addEventListener("click", startQuiz);

        document.querySelectorAll(".gender-btn").forEach(btn => {
            btn.addEventListener("click", () => selectGender(btn.getAttribute("data-gender")));
        });
    </script>
</body>
</html>
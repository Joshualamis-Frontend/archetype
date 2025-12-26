<?php
session_start();

// Initialize quiz state
if (!isset($_SESSION['quiz_stage'])) {
    $_SESSION['quiz_stage'] = 'welcome'; // welcome, gender, quiz, result
    $_SESSION['gender'] = null;
    $_SESSION['current_question'] = 0;
    $_SESSION['scores'] = [
        'caregiver' => 0,
        'jester' => 0,
        'sage' => 0,
        'creator' => 0,
        'leader' => 0,
        'lover' => 0
    ];
}

// Handle start button
if (isset($_POST['start_quiz'])) {
    $_SESSION['quiz_stage'] = 'gender';
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Handle gender selection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['gender'])) {
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['quiz_stage'] = 'quiz';
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Quiz questions organized by archetype
$questions = [
    // CAREGIVER (0-4)
    ['text' => 'People tell me they feel safe and comforted when I am around.', 'archetype' => 'caregiver'],
    ['text' => 'I can sense when someone is struggling emotionally even without being told.', 'archetype' => 'caregiver'],
    ['text' => 'I show care through small actions like preparing food or checking on someone.', 'archetype' => 'caregiver'],
    ['text' => 'I remain patient even when caring for someone who is difficult or demanding.', 'archetype' => 'caregiver'],
    ['text' => 'I prefer showing care through practical acts rather than emotional words.', 'archetype' => 'caregiver'],
    
    // JESTER (5-9)
    ['text' => 'I naturally lift the atmosphere of group interactions without drawing attention to myself.', 'archetype' => 'jester'],
    ['text' => 'I can smoothly diffuse social awkwardness by making playful or well-timed remarks.', 'archetype' => 'jester'],
    ['text' => 'I tend to uplift others emotionally simply by engaging with them.', 'archetype' => 'jester'],
    ['text' => 'I use humor to help myself deal with stress or emotional burdens.', 'archetype' => 'jester'],
    ['text' => 'I embody the Filipino spirit of finding hope through humor and positivity.', 'archetype' => 'jester'],
    
    // SAGE (10-14)
    ['text' => 'I give advice based on the lessons I learned from my own real-life experiences.', 'archetype' => 'sage'],
    ['text' => 'I carefully evaluate all options before making an important decision.', 'archetype' => 'sage'],
    ['text' => 'I stay open to new perspectives or ideas even when they challenge what I already know.', 'archetype' => 'sage'],
    ['text' => 'I take the time to reflect deeply before giving advice.', 'archetype' => 'sage'],
    ['text' => 'People often ask for my perspective before making their own decisions.', 'archetype' => 'sage'],
    
    // CREATOR (15-19)
    ['text' => 'I naturally look for new ways to solve problems instead of relying on traditional methods.', 'archetype' => 'creator'],
    ['text' => 'I often imagine possibilities and ideas that others do not immediately notice.', 'archetype' => 'creator'],
    ['text' => 'I enjoy exploring creative ideas and am naturally curious about how things could be improved.', 'archetype' => 'creator'],
    ['text' => 'I often experiment with new methods, tools, or techniques.', 'archetype' => 'creator'],
    ['text' => 'I enjoy turning my ideas into tangible creations that reflect my identity.', 'archetype' => 'creator'],
    
    // LEADER (20-24)
    ['text' => 'I take responsibility for the outcomes of my group\'s actions.', 'archetype' => 'leader'],
    ['text' => 'I strive to guide and unite people during times of uncertainty.', 'archetype' => 'leader'],
    ['text' => 'I motivate others to take part and work together.', 'archetype' => 'leader'],
    ['text' => 'I act in ways that earn the trust of my community.', 'archetype' => 'leader'],
    ['text' => 'I stay calm and collected when others panic.', 'archetype' => 'leader'],
    
    // LOVER (25-29)
    ['text' => 'I adjust my plans to provide emotional closeness and reassurance to someone I love.', 'archetype' => 'lover'],
    ['text' => 'I feel most alive when someone I love seeks my emotional closeness and support.', 'archetype' => 'lover'],
    ['text' => 'I am sensitive to the emotional needs of someone I love and respond to strengthen our bond.', 'archetype' => 'lover'],
    ['text' => 'I maintain emotional intimacy with someone I love, even during their struggle.', 'archetype' => 'lover'],
    ['text' => 'I struggle when my emotional love or support is rejected by someone I care deeply for.', 'archetype' => 'lover']
];

// Archetype descriptions and images (with gender variations)
$archetypes = [
    'caregiver' => [
        'male' => [
            'name' => 'The Caregiver',
            'meaning' => 'You are a natural protector and nurturer. Your strength lies in your ability to provide safety, comfort, and practical support to those around you. You have an intuitive understanding of others\' needs and express your care through thoughtful, reliable actions. Your steady presence and dedication make you a dependable pillar in your community.',
            'image' => 'images/caregiver_male.jpeg'
        ],
        'female' => [
            'name' => 'The Caregiver',
            'meaning' => 'You are naturally nurturing and protective. Your strength lies in your ability to provide comfort, safety, and practical support to those around you. You have an intuitive understanding of others\' needs and express your care through thoughtful actions. Your patience and dedication make you a pillar of support in your community.',
            'image' => 'images/caregiver_female.jpeg'
        ]
    ],
    'jester' => [
        'male' => [
            'name' => 'The Jester',
            'meaning' => 'You bring energy and positivity wherever you go. Your gift is the ability to lift spirits and create a lighthearted atmosphere through wit and humor. You help others find perspective and joy even in challenging times. Your playful spirit reminds people to embrace life\'s lighter moments and not take themselves too seriously.',
            'image' => 'images/jester_male.jpeg'
        ],
        'female' => [
            'name' => 'The Jester',
            'meaning' => 'You bring light and joy wherever you go. Your gift is the ability to lift spirits and create positive energy through humor and playfulness. You help others see the brighter side of life and use levity to navigate challenges. Your presence reminds people not to take life too seriously and to find hope even in difficult times.',
            'image' => 'images/jester_female.jpeg'
        ]
    ],
    'sage' => [
        'male' => [
            'name' => 'The Sage',
            'meaning' => 'You are a seeker of knowledge and wisdom. Your strength lies in your analytical approach to life and your ability to learn from experience. You value truth, careful thought, and understanding. Others seek your counsel because you provide balanced, well-reasoned perspectives that help them make informed decisions.',
            'image' => 'images/sage_male.jpeg'
        ],
        'female' => [
            'name' => 'The Sage',
            'meaning' => 'You are a seeker of truth and wisdom. Your strength lies in your thoughtful approach to life and your ability to learn from experience. You value knowledge, reflection, and understanding. Others seek your counsel because you provide balanced, well-considered perspectives that help them navigate their own journeys.',
            'image' => 'images/sage_female.jpeg'
        ]
    ],
    'creator' => [
        'male' => [
            'name' => 'The Creator',
            'meaning' => 'You are an innovator and builder. Your imagination allows you to see possibilities that others miss, and you have the drive to bring your visions to reality. You constantly seek new ways to express yourself and improve the world around you. Your creativity and determination make you a catalyst for innovation and progress.',
            'image' => 'images/creator_male.jpeg'
        ],
        'female' => [
            'name' => 'The Creator',
            'meaning' => 'You are an innovator and visionary. Your imagination allows you to see possibilities that others miss, and you have the drive to bring your ideas to life. You constantly seek new ways to express yourself and improve the world around you. Your creativity and curiosity make you a catalyst for change and innovation.',
            'image' => 'images/creator_female.jpeg'
        ]
    ],
    'leader' => [
        'male' => [
            'name' => 'The Leader',
            'meaning' => 'You are a natural guide and decision-maker. Your strength lies in your ability to take charge, inspire others, and remain steadfast during uncertainty. You build trust through your actions and help groups work toward common goals. Your composed demeanor and sense of responsibility make you someone others look to for direction and strength.',
            'image' => 'images/leader_male.jpeg'
        ],
        'female' => [
            'name' => 'The Leader',
            'meaning' => 'You are a natural guide and unifier. Your strength lies in your ability to take responsibility, inspire others, and remain steady during uncertainty. You build trust through your actions and help groups work toward common goals. Your calm presence and dedication make you someone others look to for direction and support.',
            'image' => 'images/leader_female.jpeg'
        ]
    ],
    'lover' => [
        'male' => [
            'name' => 'The Lover',
            'meaning' => 'You are deeply connected to the power of emotional bonds. Your strength lies in your ability to create and maintain meaningful connections with those you care about. You are attuned to the emotional needs of loved ones and prioritize closeness and authenticity in relationships. Your capacity for commitment and devotion enriches the lives of those around you.',
            'image' => 'images/lover_male.jpeg'
        ],
        'female' => [
            'name' => 'The Lover',
            'meaning' => 'You are deeply connected to the power of emotional bonds. Your strength lies in your ability to create and maintain intimate connections with those you care about. You are attuned to the emotional needs of loved ones and prioritize closeness and authenticity in relationships. Your capacity for deep love and devotion enriches the lives of those around you.',
            'image' => 'images/lover_female.jpeg'
        ]
    ]
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])) {
    $answer = intval($_POST['answer']);
    $current = $_SESSION['current_question'];
    
    if ($current < count($questions)) {
        $archetype = $questions[$current]['archetype'];
        $_SESSION['scores'][$archetype] += $answer;
        $_SESSION['current_question']++;
    }
    
    // Check if quiz is completed
    if ($_SESSION['current_question'] >= count($questions)) {
        $_SESSION['quiz_stage'] = 'result';
    }
    
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Reset quiz
if (isset($_GET['reset'])) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$current = $_SESSION['current_question'];
$total = count($questions);
$stage = $_SESSION['quiz_stage'];

// Calculate result
$result = null;
$gender = $_SESSION['gender'];
if ($stage === 'result' && $gender) {
    $maxScore = max($_SESSION['scores']);
    $resultArchetype = array_search($maxScore, $_SESSION['scores']);
    $result = $archetypes[$resultArchetype][$gender];
}
?>

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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #f5ebe0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: #f5ebe0;
            max-width: 700px;
            width: 100%;
            padding: 40px 20px;
        }
        
        h1 {
            color: #2d2d2d;
            text-align: center;
            margin-bottom: 10px;
            font-size: 1.1em;
            font-weight: 500;
        }
        
        .question-card {
            background: transparent;
            padding: 0;
            border-radius: 0;
            margin-bottom: 25px;
        }
        
        .question-number {
            color: #666;
            font-weight: 400;
            margin-bottom: 20px;
            font-size: 0.95em;
        }
        
        .question-text {
            color: #2d2d2d;
            font-size: 1.4em;
            line-height: 1.5;
            margin-bottom: 40px;
            font-weight: 400;
        }
        
        .answers {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .answer-btn {
            background: #ede0d4;
            border: 2px solid #ede0d4;
            padding: 20px 25px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: left;
            font-size: 1em;
            color: #2d2d2d;
        }
        
        .answer-btn:hover {
            border-color: #d4c4b0;
            background: #e6d5c3;
            transform: none;
        }
        
        .answer-btn input[type="radio"] {
            display: none;
        }
        
        .answer-label {
            color: #2d2d2d;
            font-size: 1em;
        }
        
        .result-card {
            text-align: center;
        }
        
        .result-image {
            width: 80%;
            max-width: 300px;
            height: 350px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 25px;
        }
        
        .result-title {
            color: #2d2d2d;
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        
        .result-gender {
            color: #666;
            font-size: 1.1em;
            margin-bottom: 20px;
            font-style: italic;
        }
        
        .result-meaning {
            color: #555;
            line-height: 1.8;
            font-size: 1.05em;
            margin-bottom: 30px;
            text-align: left;
        }
        
        .reset-btn {
            background: #9c8574;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-size: 1em;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .reset-btn:hover {
            background: #8a7464;
            transform: translateY(-2px);
        }
        
        /* Welcome screen styles */
        .welcome-screen {
            text-align: center;
            padding: 60px 20px;
        }
        
        .welcome-title {
            color: #4E1F00;
            font-size: 2.5em;
            margin-bottom: 10px;
            font-weight: 400;
        }
        
        .welcome-subtitle {
            color: #666;
            font-size: 1.2em;
            margin-bottom: 10px;
            line-height: 1.6;
        }
        
        .start-btn {
            background: #4E1F00;
            color: white;
            border: none;
            padding: 18px 60px;
            border-radius: 30px;
            font-size: 1.2em;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .start-btn:hover {
            background: #8a7464;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        /* Gender selection styles */
        .gender-selection {
            text-align: center;
            padding: 40px 0;
        }
        
        .gender-title {
            color: #2d2d2d;
            font-size: 2em;
            margin-bottom: 15px;
            font-weight: 400;
        }
        
        .gender-subtitle {
            color: #666;
            font-size: 1.1em;
            margin-bottom: 40px;
        }
        
        .gender-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .gender-btn {
            background: #ede0d4;
            border: 2px solid #ede0d4;
            padding: 30px 50px;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.2em;
            color: #2d2d2d;
            min-width: 200px;
        }
        
        .gender-btn:hover {
            border-color: #c4b5a0;
            background: #d4c4b0;
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }
            
            .welcome-title {
                font-size: 1.8em;
            }
            
            .welcome-subtitle {
                font-size: 1em;
            }
            
            .question-text {
                font-size: 1.2em;
            }
            
            .result-title {
                font-size: 2em;
            }
            
            .gender-title {
                font-size: 1.5em;
            }
            
            .gender-btn {
                min-width: 150px;
                padding: 25px 40px;
            }
            
            .start-btn {
                padding: 15px 40px;
                font-size: 1.1em;
            }
        }

           .scale-description p {
            text-align: left;
    margin-bottom: 12px;
    line-height: 1.5;
    color: #4E1F00;
}

.card-header h3 {
    margin: 0;
    text-align: left;
    color: #4E1F00;
}
    </style>
</head>
<body>
    <div class="container">
        <?php if ($stage === 'welcome'): ?>
            <!-- Welcome Screen -->
            <div class="welcome-screen">
                <h1 class="welcome-title">Archetype Personality Quiz</h1>
                <p class="welcome-subtitle">DEVELOPMENT AND VALIDATION OF A FILIPINO WEB-BASED ARCHETYPE PERSONALITY INVENTORY
</p>
 <p class="welcome-subtitle">
(Latergo, Ortiguesa, Patopatin, Suganob, Viesca, Villarde)
</p>

 <div class="container">
    <div id="intro-screen" class="card fade-in">
        <div class="card-header">
            <h3>Please read each statement carefully and indicate how much you agree or disagree with it. Use the following scale to rate your response</h3>
        </div>
        <br>

        <div class="card-body scale-description">
            <p><strong>1 – Strongly Disagree</strong><br>
            This statement does not describe you at all.</p>

            <p><strong>2 – Disagree</strong><br>
            This statement generally does not describe you.</p>

            <p><strong>3 – Agree</strong><br>
            This statement generally describes you.</p>

            <p><strong>4 – Strongly Agree</strong><br>
            This statement accurately and consistently describes you.</p>
        </div>    
    </div>
</div>
                
                <form method="POST">
                    <button type="submit" name="start_quiz" class="start-btn">Start Quiz</button>
                </form>
            </div>
            
        <?php elseif ($stage === 'gender'): ?>
            <!-- Gender Selection Screen -->
            <div class="gender-selection">
                <h2 class="gender-title">Select Your Gender</h2>
                <p class="gender-subtitle">This helps us personalize your results</p>
                
                <form method="POST">
                    <div class="gender-buttons">
                        <button type="submit" name="gender" value="male" class="gender-btn">Male</button>
                        <button type="submit" name="gender" value="female" class="gender-btn">Female</button>
                    </div>
                </form>
            </div>
            
        <?php elseif ($stage === 'quiz'): ?>
            <!-- Quiz Questions -->
            <div class="question-card">
                <div class="question-number"><?php echo $current + 1; ?>/<?php echo $total; ?></div>
                <div class="question-text"><?php echo $questions[$current]['text']; ?></div>
                
                <form method="POST" id="quizForm">
                    <div class="answers">
                        <label class="answer-btn">
                            <input type="radio" name="answer" value="1" required onchange="this.form.submit()">
                            <span class="answer-label">1 – Strongly Disagree</span>
                        </label>
                        
                        <label class="answer-btn">
                            <input type="radio" name="answer" value="2" required onchange="this.form.submit()">
                            <span class="answer-label">2 – Disagree</span>
                        </label>
                        
                        <label class="answer-btn">
                            <input type="radio" name="answer" value="3" required onchange="this.form.submit()">
                            <span class="answer-label">3 – Agree</span>
                        </label>
                        
                        <label class="answer-btn">
                            <input type="radio" name="answer" value="4" required onchange="this.form.submit()">
                            <span class="answer-label">4 – Strongly Agree</span>
                        </label>
                    </div>
                </form>
            </div>
            
        <?php elseif ($stage === 'result'): ?>
            <!-- Results Screen -->
            <div class="result-card">
                <h1 style="text-align: center; font-size: 1.1em; margin-bottom: 30px;">Your Archetype</h1>
                
                <img src="<?php echo $result['image']; ?>" alt="<?php echo $result['name']; ?>" class="result-image">
                
                <h2 class="result-title"><?php echo $result['name']; ?></h2>
                
                <p class="result-gender">Gender: <?php echo ucfirst($gender); ?></p>
                
                <p class="result-meaning"><?php echo $result['meaning']; ?></p>
                
                <a href="?reset=1" class="reset-btn">Take Quiz Again</a>
            </div>
        <?php endif; ?>
    </div>
    
    <script>
        // Add visual feedback for selected radio buttons
        document.querySelectorAll('.answer-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.answer-btn').forEach(b => {
                    b.style.borderColor = '#ede0d4';
                    b.style.background = '#ede0d4';
                });
                this.style.borderColor = '#c4b5a0';
                this.style.background = '#d4c4b0';
            });
        });
    </script>
</body>
</html>
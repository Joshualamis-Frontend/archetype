<?php
require_once 'config.php';

function sanitizeInput($data, $conn = null) {
    // If no connection is provided, return sanitized input without DB escaping
    if ($conn === null) {
        return htmlspecialchars(strip_tags(trim($data)));
    }
    return htmlspecialchars(strip_tags(trim($conn->real_escape_string($data))));
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function validateAge($dob) {
    $today = new DateTime();
    $birthdate = new DateTime($dob);
    $age = $today->diff($birthdate)->y;
    return $age >= 18;
}
?>



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
            'image' => 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?w=800&h=600&fit=crop'
        ],
        'female' => [
            'name' => 'The Caregiver',
            'meaning' => 'You are naturally nurturing and protective. Your strength lies in your ability to provide comfort, safety, and practical support to those around you. You have an intuitive understanding of others\' needs and express your care through thoughtful actions. Your patience and dedication make you a pillar of support in your community.',
            'image' => 'https://images.unsplash.com/photo-1516733725897-1aa73b87c8e8?w=800&h=600&fit=crop'
        ]
    ],
    'jester' => [
        'male' => [
            'name' => 'The Jester',
            'meaning' => 'You bring energy and positivity wherever you go. Your gift is the ability to lift spirits and create a lighthearted atmosphere through wit and humor. You help others find perspective and joy even in challenging times. Your playful spirit reminds people to embrace life\'s lighter moments and not take themselves too seriously.',
            'image' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?w=800&h=600&fit=crop'
        ],
        'female' => [
            'name' => 'The Jester',
            'meaning' => 'You bring light and joy wherever you go. Your gift is the ability to lift spirits and create positive energy through humor and playfulness. You help others see the brighter side of life and use levity to navigate challenges. Your presence reminds people not to take life too seriously and to find hope even in difficult times.',
            'image' => 'https://images.unsplash.com/photo-1533738363-b7f9aef128ce?w=800&h=600&fit=crop'
        ]
    ],
    'sage' => [
        'male' => [
            'name' => 'The Sage',
            'meaning' => 'You are a seeker of knowledge and wisdom. Your strength lies in your analytical approach to life and your ability to learn from experience. You value truth, careful thought, and understanding. Others seek your counsel because you provide balanced, well-reasoned perspectives that help them make informed decisions.',
            'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop'
        ],
        'female' => [
            'name' => 'The Sage',
            'meaning' => 'You are a seeker of truth and wisdom. Your strength lies in your thoughtful approach to life and your ability to learn from experience. You value knowledge, reflection, and understanding. Others seek your counsel because you provide balanced, well-considered perspectives that help them navigate their own journeys.',
            'image' => 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=800&h=600&fit=crop'
        ]
    ],
    'creator' => [
        'male' => [
            'name' => 'The Creator',
            'meaning' => 'You are an innovator and builder. Your imagination allows you to see possibilities that others miss, and you have the drive to bring your visions to reality. You constantly seek new ways to express yourself and improve the world around you. Your creativity and determination make you a catalyst for innovation and progress.',
            'image' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=800&h=600&fit=crop'
        ],
        'female' => [
            'name' => 'The Creator',
            'meaning' => 'You are an innovator and visionary. Your imagination allows you to see possibilities that others miss, and you have the drive to bring your ideas to life. You constantly seek new ways to express yourself and improve the world around you. Your creativity and curiosity make you a catalyst for change and innovation.',
            'image' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=800&h=600&fit=crop'
        ]
    ],
    'leader' => [
        'male' => [
            'name' => 'The Leader',
            'meaning' => 'You are a natural guide and decision-maker. Your strength lies in your ability to take charge, inspire others, and remain steadfast during uncertainty. You build trust through your actions and help groups work toward common goals. Your composed demeanor and sense of responsibility make you someone others look to for direction and strength.',
            'image' => 'https://images.unsplash.com/photo-1556157382-97eda2d62296?w=800&h=600&fit=crop'
        ],
        'female' => [
            'name' => 'The Leader',
            'meaning' => 'You are a natural guide and unifier. Your strength lies in your ability to take responsibility, inspire others, and remain steady during uncertainty. You build trust through your actions and help groups work toward common goals. Your calm presence and dedication make you someone others look to for direction and support.',
            'image' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=800&h=600&fit=crop'
        ]
    ],
    'lover' => [
        'male' => [
            'name' => 'The Lover',
            'meaning' => 'You are deeply connected to the power of emotional bonds. Your strength lies in your ability to create and maintain meaningful connections with those you care about. You are attuned to the emotional needs of loved ones and prioritize closeness and authenticity in relationships. Your capacity for commitment and devotion enriches the lives of those around you.',
            'image' => 'https://images.unsplash.com/photo-1500336624523-d727130c3328?w=800&h=600&fit=crop'
        ],
        'female' => [
            'name' => 'The Lover',
            'meaning' => 'You are deeply connected to the power of emotional bonds. Your strength lies in your ability to create and maintain intimate connections with those you care about. You are attuned to the emotional needs of loved ones and prioritize closeness and authenticity in relationships. Your capacity for deep love and devotion enriches the lives of those around you.',
            'image' => 'https://images.unsplash.com/photo-1518199266791-5375a83190b7?w=800&h=600&fit=crop'
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

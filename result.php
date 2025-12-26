<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DGital - Digital Agency HTML Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>
<style>
 :root {
    --filipino-gold: #D4AF37;
    --filipino-blue: #0038A8;
    --filipino-red: #CE1126;
    --filipino-light:#5D4037;
    --filipino-dark:rgb(255, 254, 254);
    --filipino-rattan: #D2B48C;
    --filipino-bamboo: #9AAF8A;
    --filipino-accent: #FF9E2C;
    --filipino-text: #333333;
    --filipino-card-bg: #FFFDF7;
    --filipino-shadow: rgba(0, 0, 0, 0.1);
}

body {
    font-family: 'Montserrat', 'Open Sans', sans-serif;
    background-color: var(--filipino-light);
    color: var(--filipino-text);
    line-height: 1.6;
    margin: 0;
    padding: 0;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239AAF8A' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
}

header {
    text-align: center;
    padding: 20px 0 40px;
    position: relative;
}

header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 120px;
    height: 5px;
    background: linear-gradient(to right, var(--filipino-blue), var(--filipino-red), var(--filipino-gold));
    border-radius: 2.5px;
}

h1 {
    font-size: 2.5rem;
    color: var(--filipino-dark);
    margin-bottom: 10px;
    font-weight: 700;
    letter-spacing: 1px;
    position: relative;
    display: inline-block;
}

h1::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(to right, var(--filipino-gold), transparent);
}

.subtitle {
    font-size: 1.2rem;
    color: white;
    margin-bottom: 30px;
    font-style: italic;
}

#result-container {
    background-color: var(--filipino-card-bg);
    border-radius: 12px;
    box-shadow: 0 15px 35px var(--filipino-shadow);
    overflow: hidden;
    margin-bottom: 40px;
    border: 1px solid rgba(212, 175, 55, 0.2);
    position: relative;
}

#result-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 8px;
    background: linear-gradient(to right, var(--filipino-blue), var(--filipino-red), var(--filipino-gold));
}

.archetype-header {
    display: flex;
    flex-direction: row;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    position: relative;
    overflow: hidden;
}

.archetype-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: url("data:image/svg+xml,%3Csvg width='52' height='26' viewBox='0 0 52 26' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M10 10c0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6h2c0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4v2c-3.314 0-6-2.686-6-6 0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6zm25.464-1.95l8.486 8.486-1.414 1.414-8.486-8.486 1.414-1.414z' /%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.7;
}

.archetype-image-container {
    flex: 0 0 330px;
    padding: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
}

.archetype-image {
    width: 300%;
    height: 430px;
    object-fit: cover;
    border-radius: 8px;
    position: relative;
    z-index: 2;
}

.archetype-image::after {
    content: '';
    position: absolute;
    top: 15px;
    left: 15px;
    width: 100%;
    height: 100%;
    border: 2px solid var(--filipino-gold);
    border-radius: 8px;
    z-index: 1;
}

.archetype-header-content {
    flex: 1;
    padding: 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    z-index: 2;
}

#archetype-name {
    font-size: 2.2rem;
    margin: 0 0 15px 0;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 700;
    color: black;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
    position: relative;
    display: inline-block;
}

#archetype-name::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 80px;
    height: 3px;
    background-color: var(--filipino-gold);
}

#archetype-description {
    font-size: 1.1rem;
    line-height: 1.7;
    margin-bottom: 20px;
    color: black;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.gender-label {
    display: inline-block;
    padding: 6px 16px;
    background-color: rgba(207, 0, 0, 0.2);
    border-radius: 20px;
    font-size: 14px;
    margin-bottom: 20px;
    align-self: flex-start;
    border: 1px solid rgba(0, 0, 0, 0.4);
    color: black;
    font-weight: 500;
    letter-spacing: 0.5px;
}

.content-section {
    padding: 40px;
    position: relative;
}

.content-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 40px;
    right: 40px;
    height: 1px;
    background: linear-gradient(to right, transparent, var(--filipino-rattan), transparent);
}

.section-title {
    position: relative;
    font-size: 1.5rem;
    color: var(--filipino-dark);
    margin-bottom: 25px;
    padding-bottom: 12px;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 3px;
    background: linear-gradient(to right, var(--filipino-gold), var(--filipino-red));
}

.section-title::before {
    content: '★';
    position: absolute;
    bottom: -4px;
    left: 64px;
    font-size: 10px;
    color: var(--filipino-gold);
}

#archetype-tips {
    list-style-type: none;
    padding: 0;
    margin: 0;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    grid-gap: 20px;
}

#archetype-tips li {
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 8px;
    font-size: 1.1rem;
    display: flex;
    align-items: flex-start;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    border-left: 3px solid var(--filipino-gold);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

#archetype-tips li:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
}

#archetype-tips li::before {
    content: '✓';
    margin-right: 15px;
    color: var(--filipino-red);
    font-weight: bold;
    font-size: 1.2rem;
    padding: 2px 6px;
    background: rgba(206, 17, 38, 0.1);
    border-radius: 50%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    flex-shrink: 0;
}

.share-section {
    text-align: center;
    margin-top: 40px;
    display: flex;
    justify-content: center;
    gap: 20px;
    padding: 20px 0;
    position: relative;
}

.share-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 200px;
    height: 1px;
    background: linear-gradient(to right, transparent, var(--filipino-gold), transparent);
}

.share-button {
    background-color: brown;
    color: white;
    border: none;
    padding: 14px 28px;
    border-radius: 30px;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    font-weight: 500;
    letter-spacing: 0.5px;
    position: relative;
    overflow: hidden;
    z-index: 1;
}

.share-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--filipino-blue), var(--filipino-red));
    opacity: 0;
    z-index: -1;
    transition: opacity 0.3s ease;
}

.share-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.share-button:hover::before {
    opacity: 1;
}

.share-button svg {
    margin-right: 10px;
}

footer {
    text-align: center;
    padding: 30px 20px;
    color: #666;
    font-size: 0.9rem;
    position: relative;
    background: linear-gradient(to bottom, transparent, rgba(154, 175, 138, 0.1));
    margin-top: 40px;
}

footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 120px;
    height: 3px;
    background: linear-gradient(to right, var(--filipino-blue), var(--filipino-red), var(--filipino-gold));
}

/* Custom themes for each archetype with Filipino influence */
.Hero-theme {
    --primary-color: #CE1126; /* Filipino red */
    --secondary-color: #FF5757;
    --accent-color: rgba(206, 17, 38, 0.1);
}

.Sage-theme {
    --primary-color: #0038A8; /* Filipino blue */
    --secondary-color: #3E7CB1;
    --accent-color: rgba(0, 56, 168, 0.1);
}

.Magician-theme {
    --primary-color: #8C3B85; /* Purple inspired by Filipino textiles */
    --secondary-color: #B355A8;
    --accent-color: rgba(140, 59, 133, 0.1);
}

.Innocent-theme {
    --primary-color: #D4AF37; /* Filipino gold */
    --secondary-color: #FFCC66;
    --accent-color: rgba(212, 175, 55, 0.1);
}

.Ruler-theme {
    --primary-color: #4A5174; /* Deep blue inspired by Filipino formal wear */
    --secondary-color: #7986CB;
    --accent-color: rgba(74, 81, 116, 0.1);
}

.Caregiver-theme {
    --primary-color: #9AAF8A; /* Filipino bamboo green */
    --secondary-color: #A7C29C;
    --accent-color: rgba(154, 175, 138, 0.1);
}
.Lover-theme {
    --primary-color:rgb(204, 33, 33); /* Filipino bamboo green */
    --secondary-color:rgb(156, 51, 25);
    --accent-color: rgba(154, 175, 138, 0.1);
}
.Orphan-theme {
    --primary-color:rgb(226, 37, 163); /* Filipino bamboo green */
    --secondary-color:rgb(0, 51, 218);
    --accent-color: rgba(154, 175, 138, 0.1);
}

/* Responsive design improvements */
@media (max-width: 992px) {
    .archetype-header {
        flex-direction: column;
    }
    
    .archetype-image-container {
        flex: 0 0 auto;
        padding: 30px 30px 0;
    }
    
    .archetype-header-content {
        padding: 20px 30px 30px;
    }
    
    #archetype-name::after {
        width: 60px;
    }
}

@media (max-width: 768px) {
    .archetype-image {
        height: 350px;
    }
    
    #archetype-tips {
        grid-template-columns: 1fr;
    }
    
    .content-section {
        padding: 25px;
    }
    
    #archetype-name {
        font-size: 1.8rem;
    }
    
    .share-section {
        flex-direction: column;
        align-items: center;
    }
    
    .share-button {
        margin-bottom: 10px;
    }
    
    h1 {
        font-size: 2rem;
    }
    
    .subtitle {
        font-size: 1rem;
    }
}

</style>

<body>
            <div class="container-xxl py-5 bg-primary hero-header">
                <div class="container my-5 py-5 px-lg-5">
                    <div class="row g-5 py-5">
                        <div class="col-12 text-center">
                            <!-- <h1 class="text-white animated slideInDown">Result Page</h1> -->
                            <hr class="bg-white mx-auto mt-0" style="width: 90px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->
        

        <!-- Team Start -->
        <div class="container">
            <header>
                <h1 class="animate__animated animate__fadeIn">Your Personality Archetype</h1>
                <p class="subtitle animate__animated animate__fadeIn">Discover your core strengths and opportunities for growth</p>
            </header>
            
            <div id="result-container" class="animate__animated animate__fadeInUp">
                <div class="archetype-header">
                    <div class="archetype-image-container">
                        <img id="archetype-image" class="archetype-image" src="/api/placeholder/400/400" alt="Archetype Image">
                    </div>
                    <div class="archetype-header-content">
                        <span id="gender-indicator" class="gender-label"></span>
                        <h2 id="archetype-name"></h2>
                        <p id="archetype-description"></p>
                    </div>
                </div>
                
                <div class="content-section">
                    <h3 class="section-title">Self-Improvement Tips</h3>
                    <ul id="archetype-tips"></ul>
                    
                    <div class="share-section">
                        <button class="share-button">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                            </svg>
                            Share on Facebook
                        </button>
                        <button class="share-button">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                            </svg>
                            Share on Twitter
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Team End -->
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>

        const archetypeData = {
          "Creator": {
    male: {
        description: "You are imaginative and driven to build something meaningful from your experiences. Early challenges shaped your creativity and resilience, pushing you to express ideas that connect and inspire others. You thrive when turning vision into reality, but must avoid self-doubt or fear of imperfection.",
        tips: [
            "Trust your creative voice. Your ideas matter, even when they feel unfinished or unconventional.",
            "Create consistently, not perfectly. Progress comes from action, not waiting for the ideal moment.",
            "Channel emotions into creation. Your experiences are powerful fuel for originality and innovation."
        ],
        image: "images/pikachu.png"
    },
    female: {
        description: "You are expressive, insightful, and deeply creative, using your experiences to bring beauty and meaning into the world. You inspire others through authenticity and imagination, but must guard against undervaluing your talents or holding back your ideas.",
        tips: [
            "Honor your creativity as a strength. Sharing your work allows others to grow alongside you.",
            "Release fear of judgment. Creation is about expression, not validation.",
            "Balance sensitivity with confidence. Your perspective is unique and worthy of being seen."
        ],
        image: "images/dora.png"
    },
    default: {
        description: "You are a visionary creator, driven to imagine, design, and bring new ideas into existence. You value originality, self-expression, and meaning, constantly seeking to leave a personal mark on the world. Your challenge is to overcome perfectionism and fear, allowing your creativity to flow freely.",
        tips: [
            "Focus on creation over criticism—let ideas evolve naturally.",
            "Make space for experimentation and play to spark innovation.",
            "Share your creations with others to amplify impact and inspiration."
        ],
        image: "/api/placeholder/400/400"
    }
}

          "Lover": {
              male: {
                  description: "As a male Sage, you are driven by intellectual curiosity and the pursuit of truth. You enjoy analyzing complex problems and sharing your insights with others. Your methodical approach to gathering and evaluating information makes you a valuable advisor. You often find yourself in mentor roles where your wisdom and perspective can benefit others.",
                  tips: [
                      "Practice expressing your thoughts with clarity and patience when others don't immediately understand.",
                      "Recognize that emotional intelligence is as valuable as intellectual knowledge.",
                      "Share your wisdom through teaching or writing to create lasting impact."
                  ],
                  image: "images/pikachu.png",
                  
              },
              female: {
                  description: "As a female Sage, you combine intellectual depth with intuitive understanding. Your insights come from both careful analysis and deep emotional intelligence. You excel at seeing patterns and connections others miss, making you an exceptional problem-solver and guide. Your ability to communicate complex ideas with clarity makes you a natural teacher and mentor.",
                  tips: [
                      "Trust your intuition alongside your analytical abilities - they complement each other.",
                      "Create spaces where your wisdom can be shared without interruption or dismissal.",
                      "Find balance between seeking knowledge and applying it practically in your life."
                  ],
                  image: "images/dora.png",
                  
              },
              default: {
                  description: "You seek wisdom and knowledge above all else. You enjoy analyzing situations and understanding the deeper meanings of life. As a Sage, your thirst for truth and clarity guides your decisions, and you often find yourself in the role of advisor or mentor. Your analytical mind helps you see beyond surface-level appearances.",
                  tips: [
                      "Engage in meaningful discussions that challenge your perspective.",
                      "Practice active listening to gain insights from others' experiences.",
                      "Balance knowledge with action - wisdom is most valuable when applied."
                  ],
                  image: "images/pikachu.png",
                
              }
          },
          "Jester": {
              male: {
                  description: "As a male Magician, you have a unique ability to transform situations through vision and innovation. You see possibilities where others see roadblocks and can articulate compelling visions of the future. Your confidence in pursuing unconventional solutions and willingness to take calculated risks sets you apart. You excel at connecting seemingly unrelated concepts to create something new.",
                  tips: [
                      "Channel your innovative thinking toward helping others realize their potential.",
                      "Practice grounding your visionary ideas with practical implementation steps.",
                      "Develop patience when others take time to understand your unconventional thinking."
                  ],
                  image: "images/pikachu.png",
                 
              },
              female: {
                  description: "As a female Magician, you combine creativity with practical intuition. Your transformative power comes from seeing beyond conventional limitations and inspiring others to embrace change. You have a natural talent for helping people see new perspectives and possibilities. Your approach to problem-solving often incorporates both analytical thinking and intuitive leaps that lead to breakthrough solutions.",
                  tips: [
                      "Embrace your unique perspective without feeling the need to justify your intuitive insights.",
                      "Seek environments that nurture rather than constrain your creative vision.",
                      "Use your transformative abilities to create meaningful change in areas you're passionate about."
                  ],
                  image: "images/dora.png",
                  
              },
              default: {
                  description: "You are an innovator and problem solver with a unique perspective. You believe in transformation and finding creative solutions where others see only obstacles. As a Magician, you connect ideas in unexpected ways and help manifest change. Your visionary thinking often leads to breakthroughs that others might miss.",
                  tips: [
                      "Experiment with new ideas and approaches without fear of failure.",
                      "Stay adaptable to change and open to unexpected possibilities.",
                      "Use your insight and innovative thinking to help others transform their circumstances."
                  ],
                  image: "/api/placeholder/400/400",
                  
              }
          },

          "Leader": {
    male: {
        description: "As a male Leader, you naturally step into positions of authority, guiding others with vision and decisiveness. You excel at organizing people and resources to achieve clear goals, creating order out of complexity. Your strength lies in balancing assertiveness with fairness, making you a figure others trust in times of uncertainty.",
        tips: [
            "Lead with integrity and clarity—your vision inspires confidence.",
            "Balance control with collaboration, allowing others to contribute their strengths.",
            "Develop emotional intelligence to connect with and motivate those you guide."
        ],
        image: "images/pikachu.png"
    },
    female: {
        description: "As a female Leader, you combine authority with empathy, inspiring others through vision and emotional intelligence. You are skilled at fostering collaboration while maintaining clear direction, empowering your team to achieve shared goals. Your leadership shines when balancing strategic thinking with the human side of guiding others.",
        tips: [
            "Trust your instincts and lead with authenticity.",
            "Seek mentorship and networks that strengthen your perspective and resilience.",
            "Balance assertiveness with openness, ensuring your team feels both guided and valued."
        ],
        image: "images/dora.png"
    },
    default: {
        description: "You are a natural Leader, driven to create order, set direction, and inspire others. You excel at organizing systems and people efficiently, providing stability and guidance in complex situations. Your challenge is to wield authority wisely—empowering others while maintaining responsibility for outcomes.",
        tips: [
            "Lead with empathy, understanding the diverse needs of your team.",
            "Empower others to grow and take initiative—true leadership multiplies itself.",
            "Remain flexible and adaptive; even strong leaders must evolve with changing circumstances."
        ],
        image: "/api/placeholder/400/400"
    }
}

          "Caregiver": {
              male: {
                  description: "As a male Caregiver, you bring strength through support and protection. You find fulfillment in being there for others and creating safe environments where people can thrive. Your empathy allows you to understand others' needs on a deep level, and you're willing to put those needs before your own. Your nurturing nature often surprises people who expect more traditional masculine traits.",
                  tips: [
                      "Recognize that your caregiving nature is a strength, not a contradiction to masculinity.",
                      "Set clear boundaries to prevent burnout and resentment from always putting others first.",
                      "Find ways to receive care and support from others - caregiving should be reciprocal."
                  ],
                  image: "images/pikachu.png",
                  
              },
              female: {
                  description: "As a female Caregiver, you have exceptional emotional intelligence and nurturing abilities. You intuitively understand others' needs and create environments where people feel safe and supported. Your strength comes from your capacity for empathy and your willingness to be there for others. You find deep fulfillment in helping others grow and overcome challenges.",
                  tips: [
                      "Establish clear boundaries to prevent compassion fatigue and burnout.",
                      "Schedule regular self-care and don't feel guilty about meeting your own needs.",
                      "Recognize when helping becomes enabling and learn to support growth through appropriate challenge."
                  ],
                  image: "images/dora.png",
                 
              },
              default: {
                  description: "You are compassionate and nurturing, finding purpose in helping and supporting others. Your empathy allows you to understand people's needs, often before they recognize them themselves. As a Caregiver, you create safe spaces for growth and healing. Your generous spirit makes you a source of comfort and strength for many.",
                  tips: [
                      "Set boundaries to avoid exhaustion and compassion fatigue.",
                      "Take time for self-care - you cannot pour from an empty cup.",
                      "Continue helping others but don't neglect your own needs and dreams."
                  ],
                  image: "/api/placeholder/400/400",
                  
              }
          },

         "Sage": {
    male: {
        description: "As a male Sage, you possess deep wisdom and a natural curiosity about the world. You excel at analyzing complex ideas and offering guidance grounded in knowledge and experience. Others trust your insight, and you find fulfillment in helping people understand themselves and the world around them.",
        tips: [
            "Seek continual learning—wisdom grows with experience and reflection.",
            "Share knowledge generously, but also listen deeply to others’ perspectives.",
            "Balance intellectual pursuits with practical application to make your insights actionable."
        ],
        image: "images/pikachu.png"
    },
    female: {
        description: "As a female Sage, you combine intuition with intellect to perceive truths that others may overlook. Your ability to reflect, analyze, and guide makes you a trusted advisor and mentor. You inspire others through your clarity of thought and your commitment to understanding the world deeply.",
        tips: [
            "Trust your intuition alongside rational analysis—it enriches your wisdom.",
            "Mentor and support others, as teaching also deepens your understanding.",
            "Take time for reflection and solitude to recharge your mental and emotional energy."
        ],
        image: "images/dora.png"
    },
    default: {
        description: "You are a Sage, guided by curiosity, insight, and the pursuit of truth. You excel at understanding complex systems, analyzing information, and offering clarity to others. Your challenge is to apply your knowledge practically while remaining humble and open to learning.",
        tips: [
            "Balance contemplation with action—knowledge is most powerful when applied.",
            "Remain open-minded; wisdom comes from learning as much from others as from books.",
            "Cultivate patience and empathy to share your insight effectively without overwhelming others."
        ],
        image: "/api/placeholder/400/400"
    }
}


      };

     // Get archetype and gender from URL parameters
const urlParams = new URLSearchParams(window.location.search);
const archetype = urlParams.get("archetype");
const gender = urlParams.get("gender");

// Check if archetype exists in data
if (archetype && archetypeData[archetype]) {
    // Apply theme based on archetype
    document.body.classList.add(`${archetype}-theme`);
    
    // Set archetype name
    document.getElementById("archetype-name").innerText = archetype;
    
    // Determine content based on gender
    let content;
    if (gender === "male" && archetypeData[archetype].male) {
        content = archetypeData[archetype].male;
        document.getElementById("gender-indicator").innerText = "Male Perspective";
    } else if (gender === "female" && archetypeData[archetype].female) {
        content = archetypeData[archetype].female;
        document.getElementById("gender-indicator").innerText = "Female Perspective";
    } else {
        content = archetypeData[archetype].default;
        document.getElementById("gender-indicator").innerText = "Universal Perspective";
    }
    
    // Set description and image
    document.getElementById("archetype-description").innerText = content.description;
    
    const archetypeImage = document.getElementById("archetype-image");
    archetypeImage.src = content.image;
    archetypeImage.alt = `${archetype} image`;
    
    // Add tips dynamically with animation
    const tipsList = document.getElementById("archetype-tips");
    tipsList.innerHTML = ""; // Clear previous tips if any
    content.tips.forEach((tip, index) => {
        const li = document.createElement("li");
        li.innerText = tip;
        li.classList.add("animate__animated", "animate__fadeInRight");
        li.style.animationDelay = `${0.3 + index * 0.2}s`;
        tipsList.appendChild(li);
    });

    // Set page title
    let titleText = `${archetype} Archetype`;
    if (gender === "male" || gender === "female") {
        titleText += ` (${gender.charAt(0).toUpperCase() + gender.slice(1)})`;
    }
    document.title = `${titleText} | Personality Quiz Results`;

} else {
    // If no archetype is found
    document.getElementById("result-container").innerHTML = `
        <div class="content-section" style="text-align: center;">
            <h2>No Result Found</h2>
            <a href="quiz.html" style="display: inline-block; margin-top: 20px; padding: 12px 24px; background-color: var(--primary-color); color: white; text-decoration: none; border-radius: 30px;">
                Take the Quiz
            </a>
        </div>
    `;
}
  </script>
</body>

</html>
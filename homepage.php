<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit();
    }
    ?> 
    <?php require_once 'config.php'; ?>
    
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filipino Modern Design</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet"  href="styles/styles.css">
    <style> 
:root {
    /* Refined Filipino color palette */
    --brown: #BF9264;
    --gold: #FFC107;
    --cream: #FFF9C4;
    --red: #D32F2F;
    --blue: #1976D2;
    --white: #FFFFFF;
    --off-white: #F8F9FA;
    --dark-brown: #5D4037;
    --light-gray: #EEEEEE;
    --dark-gray: #424242;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background-color: #FFF8DC;
    font-size: 16px;
}

/* Smooth scrolling */
html {
    scroll-behavior: smooth;
}

/* Navigation Bar */
nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 5%;
    background-color: #BF9264;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 1000;
    transition: all 0.4s ease;
}

nav.scrolled {
    padding: 0.5rem 5%;
    background-color: #F8F4E1;
    backdrop-filter: blur(10px);
}

.logo {
    font-weight: bold;
    font-size: 1.25rem;
    color: var(--red);
    display: flex;
    align-items: center;
}

.logo span {
    color: var(--gold);
}

.logo::before {
    content: '★';
    margin-right: 6px;
    color: var(--gold);
}

.nav-links {
    display: flex;
    list-style: none;
}

.nav-links li {
    margin-left: 1.5rem;
    position: relative;
}

.nav-links a {
    text-decoration: none;
    color: var(--gold);
    font-weight: 500;
    font-size: 0.95rem;
    transition: color 0.3s ease;
    position: relative;
    padding: 0.5rem 0;
}

.nav-links a::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: 0;
    left: 0;
    background-color: var(--gold);
    transition: width 0.3s ease;
}

.nav-links a:hover {
    color: var(--gold);
}

.nav-links a:hover::after {
    width: 100%;
}

.hamburger {
    display: none;
    cursor: pointer;
    font-size: 1.5rem;
    color: var(--dark-brown);
}

/* Hero Section */
.hero {
    min-height: 90vh;
    display: flex;
    align-items: center;
    padding: 5rem 5% 3rem;
    background: #FFF8DC;
    position: relative;
    overflow: hidden;
}

.hero-content {
    max-width: 550px;
    z-index: 1;
    animation: fadeInUp 1s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.hero h1 {
    font-size: 2.75rem;
    margin-bottom: 1.25rem;
    color: var(--dark-brown);
    position: relative;
    line-height: 1.2;
}

.hero h1 span {
    color: var(--red);
}

.hero h1::after {
    content: '';
    position: absolute;
    width: 80px;
    height: 3px;
    background: linear-gradient(90deg, var(--gold), var(--red));
    bottom: -8px;
    left: 0;
}

.hero p {
    font-size: 1.05rem;
    margin-bottom: 1.75rem;
    line-height: 1.6;
    color: var(--dark-gray);
}

.cta-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.hero-btn {
    display: inline-block;
    padding: 0.875rem 1.75rem;
    background-color: var(--red);
    color: var(--white);
    border: none;
    border-radius: 30px;
    font-weight: bold;
    font-size: 0.95rem;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(211, 47, 47, 0.3);
}

.hero-btn:hover {
    background-color: #C62828;
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(211, 47, 47, 0.4);
}

.hero-btn-outline {
    display: inline-block;
    padding: 0.875rem 1.75rem;
    background-color: transparent;
    color: var(--dark-brown);
    border: 2px solid var(--dark-brown);
    border-radius: 30px;
    font-weight: bold;
    font-size: 0.95rem;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.hero-btn-outline:hover {
    background-color: var(--dark-brown);
    color: var(--white);
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(93, 64, 55, 0.2);
}

.hero-image {
    margin-left: 20px;
    width: 45%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero-image img {
    border-radius: 20px;
    max-width: 100%;
    height: auto;
}

/* About Us Section */
.about {
    padding: 5rem 5%;
    background-color: var(--off-white);
    position: relative;
}

.section-title {
    margin-bottom: 3rem;
    text-align: center;
}

.section-title h2 {
    font-size: 2.25rem;
    color: var(--dark-brown);
    position: relative;
    display: inline-block;
}

.section-title h2::after {
    content: '';
    position: absolute;
    width: 70px;
    height: 3px;
    background: linear-gradient(90deg, var(--gold), var(--red));
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
}

.section-subtitle {
    font-size: 1rem;
    color: var(--dark-gray);
    margin: 1.25rem auto 0;
    max-width: 600px;
}

.about-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
}

.about-card {
    padding: 2rem;
    border-radius: 12px;
    background-color: var(--white);
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
}

.about-card::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, var(--gold), var(--red));
    top: 0;
    left: 0;
    transform: scaleX(0);
    transition: transform 0.4s ease;
    transform-origin: left;
}

.about-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.about-card:hover::before {
    transform: scaleX(1);
}

.about-card h3 {
    color: var(--dark-brown);
    margin-bottom: 1.25rem;
    font-size: 1.35rem;
    position: relative;
    padding-bottom: 0.75rem;
}

.about-card h3::after {
    content: '';
    position: absolute;
    width: 35px;
    height: 2px;
    background-color: var(--gold);
    bottom: 0;
    left: 0;
    transition: width 0.3s ease;
}

.about-card:hover h3::after {
    width: 70px;
}

.about-card p {
    line-height: 1.7;
    font-size: 0.95rem;
    color: var(--dark-gray);
}

.about-card-icon {
    position: absolute;
    top: 15px;
    right: 15px;
    color: rgba(141, 110, 99, 0.1);
    font-size: 2rem;
}

.about-image {
    flex: 1;
    max-width: 100%;
}

.about-image img {
    width: 100%;
    height: auto;
    border-radius: 8px;
}

/* Container for the image */
.image-container {
    max-width: 100%;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 1.25rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: var(--dark-brown);
    font-weight: 500;
    font-size: 0.95rem;
}

.form-control {
    width: 100%;
    padding: 11px 14px;
    border: 1px solid var(--light-gray);
    border-radius: 8px;
    font-size: 0.95rem;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.1);
}

textarea.form-control {
    min-height: 130px;
    resize: vertical;
}

.submit-btn {
    display: inline-block;
    padding: 0.875rem 1.75rem;
    background-color: var(--red);
    color: var(--white);
    border: none;
    border-radius: 30px;
    font-weight: bold;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(211, 47, 47, 0.3);
    width: 100%;
}

.submit-btn:hover {
    background-color: #C62828;
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(211, 47, 47, 0.4);
}

/* Footer */
footer {
    background-color: #493628;
    color: var(--cream);
    padding: 4rem 5% 1.5rem;
    position: relative;
}

footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--gold), var(--red), var(--blue));
}

.footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 2.5rem;
    margin-bottom: 3rem;
}

.footer-column h3 {
    font-size: 1.15rem;
    margin-bottom: 1.25rem;
    color: var(--gold);
    position: relative;
    padding-bottom: 0.75rem;
}

.footer-column h3::after {
    content: '';
    position: absolute;
    width: 25px;
    height: 2px;
    background-color: var(--gold);
    bottom: 0;
    left: 0;
}

.footer-logo {
    display: flex;
    align-items: center;
    font-weight: bold;
    font-size: 1.25rem;
    color: var(--white);
    margin-bottom: 0.875rem;
}

.footer-logo span {
    color: var(--gold);
}

.footer-logo::before {
    content: '★';
    margin-right: 6px;
    color: var(--gold);
}

.footer-column p,
.footer-column a {
    margin-bottom: 0.75rem;
    display: block;
    color: var(--cream);
    opacity: 0.8;
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.footer-column a {
    display: flex;
    align-items: center;
}

.footer-column a i {
    margin-right: 8px;
    font-size: 0.75rem;
}

.footer-column a:hover {
    color: var(--gold);
    opacity: 1;
    transform: translateX(5px);
}

.social-icons {
    display: flex;
    gap: 0.875rem;
    margin-top: 1.25rem;
}

.social-icons a {
    width: 38px;
    height: 38px;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--white);
    font-size: 1.1rem;
    transition: all 0.3s ease;
    margin-bottom: 0;
}

.social-icons a:hover {
    background-color: var(--gold);
    color: var(--dark-brown);
    transform: translateY(-5px);
}

.footer-newsletter p {
    margin-bottom: 1.25rem;
}

.newsletter-form {
    display: flex;
    margin-bottom: 0.875rem;
}

.newsletter-input {
    flex-grow: 1;
    padding: 10px 14px;
    border: none;
    border-radius: 30px 0 0 30px;
    font-size: 0.875rem;
}

.newsletter-input:focus {
    outline: none;
}

.newsletter-btn {
    background-color: var(--gold);
    color: var(--dark-brown);
    border: none;
    border-radius: 0 30px 30px 0;
    padding: 0 1.25rem;
    font-weight: bold;
    font-size: 0.875rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.newsletter-btn:hover {
    background-color: var(--red);
    color: var(--white);
}

.copyright {
    text-align: center;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    font-size: 0.85rem;
    color: var(--cream);
    opacity: 0.7;
}

/* Back to Top Button */
.back-to-top {
    position: fixed;
    bottom: 25px;
    right: 25px;
    width: 45px;
    height: 45px;
    background-color: var(--red);
    color: var(--white);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    z-index: 99;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.back-to-top.show {
    opacity: 1;
    visibility: visible;
}

.back-to-top:hover {
    background-color: var(--gold);
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

/* Auth Buttons Styling */
.auth-buttons {
    display: flex;
    gap: 10px;
    margin-left: auto;
    margin-right: 15px;
}

.btn {
    text-decoration: none;
    font-weight: 500;
    font-size: 0.875rem;
    padding: 7px 15px;
    border-radius: 20px;
    transition: all 0.3s ease;
    text-align: center;
    white-space: nowrap;
}

.btn-signin {
    color: #333;
    background-color: transparent;
    border: 1.5px solid #e0e0e0;
}

.btn-signin:hover {
    background-color: #f5f5f5;
    border-color: #d0d0d0;
}

/* Tablet Responsive */
@media (max-width: 992px) {
    .hero {
        flex-direction: column;
        text-align: center;
        padding: 4rem 5% 3rem;
    }

    .hero-image {
        display: none;
    }

    .hero-content {
        max-width: 100%;
    }

    .hero h1 {
        font-size: 2.5rem;
    }

    .hero h1::after {
        left: 50%;
        transform: translateX(-50%);
    }

    .cta-buttons {
        justify-content: center;
    }

    .section-title h2 {
        font-size: 2rem;
    }

    .about-content {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.75rem;
    }

    .footer-content {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
    }
}

/* Mobile Responsive */
@media (max-width: 768px) {
    nav {
        padding: 0.75rem 5%;
    }

    .logo {
        font-size: 1.1rem;
    }

    .auth-buttons {
        display: none;
    }

    .nav-links {
        position: fixed;
        top: 60px;
        left: 0;
        width: 100%;
        background-color: var(--white);
        flex-direction: column;
        align-items: center;
        padding: 1.5rem 0;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        transform: translateY(-200%);
        transition: transform 0.4s ease;
        z-index: 999;
    }

    .nav-links.active {
        transform: translateY(0);
    }

    .nav-links.active ~ .auth-buttons {
        display: flex;
        flex-direction: column;
        width: 90%;
        margin: 1rem auto 0;
        gap: 0.75rem;
    }

    .nav-links li {
        margin: 0.875rem 0;
    }

    .nav-links a {
        font-size: 1rem;
    }

    .hamburger {
        display: block;
    }

    .hero {
        min-height: 80vh;
        padding: 3.5rem 5% 2.5rem;
    }

    .hero h1 {
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .hero p {
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
    }

    .cta-buttons {
        flex-direction: column;
        gap: 0.875rem;
    }

    .hero-btn,
    .hero-btn-outline {
        width: 100%;
        text-align: center;
        padding: 0.75rem 1.5rem;
    }

    .about {
        padding: 4rem 5%;
    }

    .section-title {
        margin-bottom: 2.5rem;
    }

    .section-title h2 {
        font-size: 1.75rem;
    }

    .section-subtitle {
        font-size: 0.95rem;
    }

    .about-content {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .about-card {
        padding: 1.75rem;
    }

    .about-card h3 {
        font-size: 1.25rem;
    }

    .about-card p {
        font-size: 0.9rem;
    }

    footer {
        padding: 3.5rem 5% 1.5rem;
    }

    .footer-content {
        grid-template-columns: 1fr;
        gap: 2rem;
        text-align: center;
    }

    .footer-column h3::after {
        left: 50%;
        transform: translateX(-50%);
    }

    .footer-column a {
        justify-content: center;
    }

    .social-icons {
        justify-content: center;
    }

    .newsletter-form {
        flex-direction: column;
        gap: 0.75rem;
    }

    .newsletter-input {
        border-radius: 30px;
    }

    .newsletter-btn {
        border-radius: 30px;
        padding: 10px 1.25rem;
    }

    .back-to-top {
        right: 20px;
        bottom: 20px;
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
}

/* Small Mobile */
@media (max-width: 576px) {
    body {
        font-size: 15px;
    }

    nav {
        padding: 0.65rem 4%;
    }

    .logo {
        font-size: 1rem;
    }

    .hero {
        min-height: 75vh;
        padding: 3rem 4% 2rem;
    }

    .hero h1 {
        font-size: 1.65rem;
        margin-bottom: 0.875rem;
    }

    .hero h1::after {
        width: 60px;
        height: 2px;
    }

    .hero p {
        font-size: 0.875rem;
        margin-bottom: 1.25rem;
    }

    .hero-btn,
    .hero-btn-outline {
        padding: 0.65rem 1.25rem;
        font-size: 0.875rem;
    }

    .about {
        padding: 3.5rem 4%;
    }

    .section-title {
        margin-bottom: 2rem;
    }

    .section-title h2 {
        font-size: 1.5rem;
    }

    .section-title h2::after {
        width: 50px;
        height: 2px;
    }

    .section-subtitle {
        font-size: 0.875rem;
        margin-top: 1rem;
    }

    .about-card {
        padding: 1.5rem;
    }

    .about-card h3 {
        font-size: 1.15rem;
        margin-bottom: 1rem;
    }

    .about-card p {
        font-size: 0.85rem;
        line-height: 1.6;
    }

    .form-control {
        padding: 10px 12px;
        font-size: 0.875rem;
    }

    textarea.form-control {
        min-height: 110px;
    }

    .submit-btn {
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
    }

    footer {
        padding: 3rem 4% 1.25rem;
    }

    .footer-content {
        gap: 1.75rem;
        margin-bottom: 2.5rem;
    }

    .footer-column h3 {
        font-size: 1.05rem;
        margin-bottom: 1rem;
    }

    .footer-column p,
    .footer-column a {
        font-size: 0.85rem;
        margin-bottom: 0.65rem;
    }

    .footer-logo {
        font-size: 1.15rem;
    }

    .social-icons {
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .social-icons a {
        width: 35px;
        height: 35px;
        font-size: 1rem;
    }

    .newsletter-input {
        padding: 9px 12px;
        font-size: 0.8rem;
    }

    .newsletter-btn {
        padding: 9px 1rem;
        font-size: 0.8rem;
    }

    .copyright {
        font-size: 0.8rem;
        padding-top: 1.25rem;
    }

    .back-to-top {
        right: 15px;
        bottom: 15px;
        width: 38px;
        height: 38px;
        font-size: 0.95rem;
    }

    .btn {
        padding: 8px 14px;
        font-size: 0.8rem;
    }
}

/* Extra Small Devices */
@media (max-width: 400px) {
    body {
        font-size: 14px;
    }

    .hero h1 {
        font-size: 1.45rem;
    }

    .hero p {
        font-size: 0.8rem;
    }

    .section-title h2 {
        font-size: 1.35rem;
    }

    .about-card {
        padding: 1.25rem;
    }

    .about-card h3 {
        font-size: 1.05rem;
    }

    .about-card p {
        font-size: 0.8rem;
    }

    .footer-column h3 {
        font-size: 1rem;
    }
}
    
    </style>
</head>
<body>
   <!-- Navigation Bar -->
<nav id="navbar">
    <div class="logo">ANI<span>NAG</span></div>
    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="#about">About Us</a></li>
        <li><a href="#contact">Contact</a></li>
    </ul>
    <!-- <div class="auth-buttons">
        <a href="user_login.php" class="btn btn-signin">Sign In</a>
        <a href="user_register.php" class="btn btn-signin">Sign Up</a>
    </div> -->
    <div class="hamburger" id="hamburger">
        <i class="fas fa-bars"></i>
    </div>
</nav>

    <!-- Hero Section -->     
<section class="hero" id="home">         
    <div class="hero-background"></div>         
    <div class="hero-pattern"></div>         
    <div class="hero-content" data-aos="fade-up">             
        <h1>ANINAG: Discover Your Archetype<span> <?php 
                if (isset($_SESSION['username'])) {
                    echo htmlspecialchars($_SESSION['username']);
                } else {
                    echo "Guest";
                }
            ?>!!</span></h1>             
        <p>Welcome to ANINAG. Discover your unique archetype through our Filipino-based personality inventory. Take our interactive quiz to gain meaningful insights into your personality traits, patterns, and tendencies. 
            Explore your results and understand how your archetype reflects who you are.</p>             
        <div class="cta-buttons">                 
            <a href="#about" class="hero-btn">About us</a>                 
            <a href="quiz.php" class="hero-btn-outline">Take a Quiz</a>             
        </div>         
    </div>         
    <div class="hero-image" data-aos="fade-left">
        <img src="images/vb.png" alt="Modern Filipino Interior Design">
    </div>     
    
</section>


<!-- About Us Section -->
<section class="about" id="about">
    
    
    <div class="section-title" data-aos="fade-up">
        <h2>About Us</h2>
        <p class="section-subtitle">Introduction to Carl Jung's Archetype Theory</p>
    </div>
    
    <div class="about-content">
        <div class="about-image" data-aos="fade-left" data-aos-delay="200">
            <img src="images/about.png" alt="Interior Design Team">
        </div>
        
        <div class="about-card" data-aos="fade-up" data-aos-delay="100">
            <i class="fas fa-history about-card-icon"></i>
            <h3>Archetypes </h3>
            <p>Archetypes originate from Carl Jung’s Analytical Theory, which proposes that the human psyche includes a collective unconscious shared across individuals. Within this collective unconscious are archetypes—universal and recurring patterns that influence how people think, feel, and behave. 
                These patterns appear across cultures through myths, symbols, stories, and common human roles.</p>
            <br>
             <p>Building on Jung’s analytical concepts, Carol S. Pearson organized these archetypes into a structured archetype framework 
                 that allows archetypal patterns to be identified and described in a systematic manner.</p>
            <br>
            <p>ANINAG is theory-driven by Jung’s Analytical Theory and adopts Pearson’s archetype 
                framework as the foundation of its web-based personality inventory.</p>
            <br>
            
            <h4>Why Archetypes Matter</h4>
            <p>Archetypes provide a structured way to understand recurring patterns in personality, behavior, and motivation. Examining dominant archetypes offers 
                insight into how individuals typically perceive situations, relate to others, and respond to challenges.</p>
            
            <p>By identifying prominent archetypes, individuals can:</p>
            <ul>
                <li><span>Recognize recurring behavioral and thought patterns</span></li>
                <li>Understand characteristic motivations and tendencies</li>
                <li>Increase awareness of interpersonal and social responses</li>
                <li>Identify common approaches to life situations</li>
            </ul>
        </div>
    </div>
</section>


    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-column">
                <div class="footer-logo">Filipino<span>Design</span></div>
                <p>Blending traditional Filipino elements with contemporary aesthetics to create spaces that are both culturally rich and functionally elegant.</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="footer-column">
                <h3>Quick Links</h3>
                <a href="#home"><i class="fas fa-chevron-right"></i> Home</a>
                <a href="#about"><i class="fas fa-chevron-right"></i> About Us</a>
                <a href="#contact"><i class="fas fa-chevron-right"></i> Contact</a>
            </div>
            <div class="footer-column footer-newsletter">
                <h3>Newsletter</h3>
                <p>Subscribe to our newsletter to receive updates on our latest projects and design insights.</p>
                <form class="newsletter-form">
                    <input type="email" class="newsletter-input" placeholder="Your email" required>
                    <button type="submit" class="newsletter-btn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
                <p class="small">We respect your privacy and will never share your information.</p>
            </div>
        </div>
        <div class="copyright">
            &copy; 2025 Filipino Design. All Rights Reserved.
        </div>
    </footer>

    <!-- Back to Top Button -->
    <div class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        // Initialize AOS animation
        AOS.init({
            duration: 800,
            easing: 'ease',
            once: true,
            offset: 100
        });

        // Mobile Navigation Toggle
        const hamburger = document.getElementById('hamburger');
        const navLinks = document.querySelector('.nav-links');

        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            hamburger.innerHTML = navLinks.classList.contains('active') ? 
                '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
        });

        // Navbar Scroll Effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Back to Top Button
        const backToTopButton = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        });

        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    // Close mobile menu if open
                    if (navLinks.classList.contains('active')) {
                        navLinks.classList.remove('active');
                        hamburger.innerHTML = '<i class="fas fa-bars"></i>';
                    }
                    
                    // Scroll to target
                    window.scrollTo({
                        top: targetElement.offsetTop - 70,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Basic form validation
        const contactForm = document.getElementById('contactForm');
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();
                // Here you would normally send the form data to a server
                alert('Thank you for your message! We will get back to you soon.');
                this.reset();
            });
        }

        // Simple Testimonial Slider
        const dots = document.querySelectorAll('.dot');
        if (dots.length > 0) {
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    // Remove active class from all dots
                    dots.forEach(d => d.classList.remove('active'));
                    // Add active class to clicked dot
                    dot.classList.add('active');
                    
                    // Here you would normally switch to the corresponding testimonial
                    // For a complete implementation, you would need multiple testimonials in the HTML
                });
            });
        }
    </script>
</body>

</html>


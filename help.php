<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help & FAQs</title>
    <link rel="stylesheet" href="recipe.css"> 
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<header>
    <div class="logo"><img src="images/logo.png" alt="logo">
        <p>PantryPal</p>
    </div>
    <nav class="navbar">
        <a href="recipe.php">Home</a>
        <a href="cuisine.php">Cuisines</a>
        <a href="meals.php">Meals</a>
        <a href="help.php">Help</a>
        <a href="pantry.php">What's In Your Pantry?</a>
    </nav>
</header>

<div class="title-h1">
    <h1>Help & FAQs</h1>
</div>

<div class="container">
    <section class="guidelines">
        <h2>Usage Guidelines</h2>
        <p>Welcome to PantryPal! Here are a few guidelines to help you use the website:</p>
        <ul>
            <li>Navigate through the tabs in the navbar to explore recipes by cuisine or meal type.</li>
            <li>Use the "What's In Your Pantry" section to find recipes based on the ingredients you have.</li>
            <li>Click on a recipe card to view the full recipe details, including ingredients and preparation steps.</li>
            <li>Use the search bar to quickly find specific recipes.</li>
        </ul>
    </section>

    <section class="faqs">
        <h2>Frequently Asked Questions</h2>
        <div class="faq">
            <button class="faq-question">How do I search for recipes?<i class="fa fa-chevron-down"></i></button>
            <div class="faq-answer">
                <p>You can search for recipes by using the navigation tabs or by typing keywords in the search bar.</p>
            </div>
        </div>
        <div class="faq">
            <button class="faq-question">Can I add my own recipes?<i class="fa fa-chevron-down"></i></button>
            <div class="faq-answer">
                <p>Currently, the feature to add custom recipes is not available. Stay tuned for updates!</p>
            </div>
        </div>
        <div class="faq">
            <button class="faq-question">How can I find recipes with specific ingredients?<i class="fa fa-chevron-down"></i></button>
            <div class="faq-answer">
                <p>Go to the "What's In Your Pantry" page, select the ingredients you have, and click "Find Recipes" to get tailored results.</p>
            </div>
        </div>
    </section>
</div>

<footer>
    <div class="footer">
        <div class="topFooter">
            <div class="footerLinks">
                <nav>
                    <a href="recipe.php">Home</a>
                    <a href="cuisine.php">Cuisines</a>
                    <a href="meals.php">Meals</a>
                    <a href="help.php">Help</a>
                    <a href="pantry.php">What's In Your Pantry?</a>
                </nav>
                          
            </div>
        </div>
        <div class="footnote">
            <p>© 2024 PantryPal. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const faqQuestions = document.querySelectorAll(".faq-question");

        faqQuestions.forEach(question => {
            question.addEventListener("click", function() {
                const answer = this.nextElementSibling;
                answer.style.display = answer.style.display === "block" ? "none" : "block";
                this.querySelector("i").classList.toggle("fa-chevron-down");
                this.querySelector("i").classList.toggle("fa-chevron-up");
            });
        });
    });
</script>

</body>
</html>

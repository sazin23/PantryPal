<?php 
include('db_connect.php'); // Including the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What's In Your Pantry?</title>
    <link rel="stylesheet" href="recipe.css">
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <h1>What's In Your Pantry?</h1>
</div>
<div class="title-h2">Select your ingredients, and discover delicious recipes tailored just for you!</div>

<div class="container">
    <h2 class="title-h2">Select Ingredients:</h2>
    <div class="ingredients-selection">
        <div class="ingredient-options">

            <?php
            // Fetching ingredients from the database
            $sql = "SELECT IngredientID, IngredientName FROM Ingredients"; // Make sure your table is named correctly
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $ingredientID = $row['IngredientID'];
                    $ingredientName = $row['IngredientName'];
                    echo "
                    <label for='ingredient$ingredientID'>
                        <input type='checkbox' id='ingredient$ingredientID' class='ingredient-checkbox' value='$ingredientID'>
                        $ingredientName
                    </label><br>
                    ";
                }
            } else {
                echo "No ingredients found.";
            }
            ?>

        </div>
        <button id="filter-recipes" class="btn-submit">Find Recipes</button>
    </div>
</div>

<div id="recipes-container" class="recipes-container">
    <!-- Recipe cards will be dynamically added here -->
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
$(document).ready(function() {
    $('#filter-recipes').click(function() {
        const selectedIngredients = [];
        $('.ingredient-checkbox:checked').each(function() {
            selectedIngredients.push($(this).val());
        });

        // Log the selected ingredients to the console
        console.log(selectedIngredients);

        if (selectedIngredients.length === 0) {
            alert("Please select at least one ingredient.");
            return;
        }

        // Send selected ingredients to the server via AJAX
        $.ajax({
            url: 'filter_recipes.php', // PHP script to fetch filtered recipes
            method: 'POST',
            data: { ingredients: selectedIngredients },
            success: function(response) {
                console.log(response); // Log the response from the server
                $('#recipes-container').html(response); // Display recipes
            }
        });
    });
});

</script>

</body>
</html>

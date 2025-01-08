<?php

include('db_connect.php');

if (isset($_GET['RecipeID'])) {
    $recipeID = $_GET['RecipeID']; 
    $query = "SELECT * FROM recipes WHERE RecipeID = '$recipeID'"; 
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $recipe = mysqli_fetch_assoc($result);
    } else {
        echo "Recipe not found!";
    }
} else {
    echo "No RecipeID provided!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($recipe) ? $recipe['RecipeName'] : 'Recipe Details'; ?></title>
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
            <a href="pantry.php">What's In Your Pantry?</a>
        </nav>
    </header>

    <div class="title-h1">
        <h1><?php echo isset($recipe) ? $recipe['RecipeName'] : 'Recipe Details'; ?></h1>
    </div>

    <div class="recipe-details">
        <?php if (isset($recipe['RecipeImage'])): ?>
        <div class="recipe-image">
            <img src="images/<?php echo $recipe['RecipeImage']; ?>" alt="<?php echo htmlspecialchars($recipe['RecipeName']); ?>">
        </div>
        <?php endif; ?>

        <h2>Description:</h2>
        <p><?php echo isset($recipe) ? $recipe['Description'] : 'No description available.'; ?></p>

        <h2>Ingredients:</h2>
            <ul class="ingredients-list">
                <?php
                $ingredient_query = "SELECT i.IngredientName, ri.Quantity
                                    FROM recipeingredients ri
                                    JOIN ingredients i ON ri.IngredientID = i.IngredientID
                                    WHERE ri.RecipeID = '$recipeID'"; 
                $ingredient_result = mysqli_query($conn, $ingredient_query);

                if ($ingredient_result && mysqli_num_rows($ingredient_result) > 0) {
                    while ($ingredient = mysqli_fetch_assoc($ingredient_result)) {
                        echo "<li>" . htmlspecialchars($ingredient['IngredientName']) . " - " . htmlspecialchars($ingredient['Quantity']) . "</li>";
                    }
                } else {
                    echo "<li>No ingredients listed or invalid RecipeID.</li>";
                }
                ?>
            </ul>



        <h2>Steps:</h2>
        <ol class="steps-list">
            <?php
                $step_query = "SELECT StepNumber, StepDescription FROM steps WHERE RecipeID = '$recipeID' ORDER BY StepNumber";
                $step_result = mysqli_query($conn, $step_query);
                if (mysqli_num_rows($step_result) > 0) {
                    while ($step = mysqli_fetch_assoc($step_result)) {
                        echo "<li>" . $step['StepDescription'] . "</li>";
                    }
                } else {
                    echo "<li>No steps available.</li>";
                }
            ?>
        </ol>
    </div>

    <footer>
        <div class="footer">
            <div class="topFooter">
                <div class="footerLinks">
                <nav>
                    <a href="recipe.php">Home</a>
                    <a href="cuisine.php">Cuisines</a>
                    <a href="meals.php">Meals</a>
                    <a href="pantry.php">What's In Your Pantry?</a>
                </nav>
                </div>
                <div class="social">
                    <a href=""><i class="fa-brands fa-facebook"></i></a>
                    <a href=""><i class="fa-brands fa-youtube"></i></a>
                    <a href=""><i class="fa-brands fa-x-twitter"></i></a>
                    <a href=""><i class="fa-brands fa-instagram"></i></a>
                </div>              
            </div>
            <div class="footnote">
                <p>© 2024 PantryPal. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>

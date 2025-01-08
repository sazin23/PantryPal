<?php
// Include the database connection
include('db_connect.php');

// Query to fetch recipe details from the 'recipes' table
$query = "SELECT * FROM recipes";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PantryPal - Meals</title>
    <link rel="stylesheet" href="recipe.css">
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <header>
        <div class="logo"><img src="images/logo.png" alt="logo" >
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
        <h1>Meals</h1>
    </div>
    <div class="title-h2">Browse 1170+ recipes and find a new favorite.</div>

    <section>
        <div class="wrapper">
            <?php
                // Check if there are any rows to display
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="card">';
                        echo '<a href="recipe_details.php?RecipeID=' . $row['RecipeID'] . '">';                         
                        $imagePath = 'images/' . $row['RecipeImage'];
                        if (file_exists($imagePath)) {
                            echo '<img src="' . $imagePath . '" alt="Card image" class="card-img">';
                        } else {
                            echo '<img src="images/default.webp" alt="Card image" class="card-img">'; 
                        }
                        echo '<div class="card-content">';
                        echo '<h2 class="card-title">' . $row['RecipeName'] . '</h2>';
                        echo '<p class="card-description">' . $row['Description'] . '</p>';
                        echo '</div>';
                        echo '</a>'; 
                        echo '</div>';
                    }
                } else {
                    echo '<p>No recipes found.</p>';
                }
            ?>
        </div>        
    </section>

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

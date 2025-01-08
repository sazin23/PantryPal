<?php
// Include database connection
include('db_connect.php');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipeName = mysqli_real_escape_string($conn, $_POST['recipe_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $imagePath = mysqli_real_escape_string($conn, $_POST['image']);
    $cuisine = mysqli_real_escape_string($conn, $_POST['cuisine']);
    $mealType = mysqli_real_escape_string($conn, $_POST['meal_type']);
    $ingredients = $_POST['ingredients']; // Array of ingredients
    $quantities = $_POST['quantities'];   // Array of quantities
    $steps = $_POST['steps'];             // Array of steps

    // Start a transaction for safe inserts
    mysqli_begin_transaction($conn);

    try {
        // Insert recipe into recipes table
        $insertRecipeQuery = "INSERT INTO recipes (RecipeName, Description, RecipeImage, Cuisine, MealType) 
                              VALUES ('$recipeName', '$description', '$imagePath', '$cuisine', '$mealType')";
        if (!mysqli_query($conn, $insertRecipeQuery)) {
            throw new Exception("Error inserting recipe: " . mysqli_error($conn));
        }

        // Get the inserted RecipeID
        $recipeID = mysqli_insert_id($conn);

        // Insert ingredients and quantities into recipeingredients table
        for ($i = 0; $i < count($ingredients); $i++) {
            $ingredient = mysqli_real_escape_string($conn, $ingredients[$i]);
            $quantity = mysqli_real_escape_string($conn, $quantities[$i]);

            // Check if the ingredient exists in the ingredients table
            $checkIngredientQuery = "SELECT IngredientID FROM ingredients WHERE IngredientName = '$ingredient'";
            $ingredientResult = mysqli_query($conn, $checkIngredientQuery);

            if ($ingredientResult && mysqli_num_rows($ingredientResult) > 0) {
                $ingredientRow = mysqli_fetch_assoc($ingredientResult);
                $ingredientID = $ingredientRow['IngredientID'];
            } else {
                // Insert the ingredient into the ingredients table if it doesn't exist
                $insertIngredientQuery = "INSERT INTO ingredients (IngredientName) VALUES ('$ingredient')";
                if (!mysqli_query($conn, $insertIngredientQuery)) {
                    throw new Exception("Error inserting ingredient: " . mysqli_error($conn));
                }
                $ingredientID = mysqli_insert_id($conn);
            }

            // Insert into recipeingredients table with quantity
            $insertRecipeIngredientQuery = "INSERT INTO recipeingredients (RecipeID, IngredientID, Quantity) 
                                            VALUES ('$recipeID', '$ingredientID', '$quantity')";
            if (!mysqli_query($conn, $insertRecipeIngredientQuery)) {
                throw new Exception("Error inserting into recipeingredients: " . mysqli_error($conn));
            }
        }

        // Insert steps into steps table
        $stepNumber = 1;
        foreach ($steps as $step) {
            $step = mysqli_real_escape_string($conn, $step);
            $insertStepQuery = "INSERT INTO steps (RecipeID, StepNumber, StepDescription) VALUES ('$recipeID', '$stepNumber', '$step')";
            if (!mysqli_query($conn, $insertStepQuery)) {
                throw new Exception("Error inserting step: " . mysqli_error($conn));
            }
            $stepNumber++;
        }

        
        mysqli_commit($conn);
        echo "<p class='success'>Recipe created successfully!</p>";
    } catch (Exception $e) {        
        mysqli_rollback($conn);
        echo "<p class='error'>Failed to create recipe: " . $e->getMessage() . "</p>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Recipe</title>
    <link rel="stylesheet" href="recipe.css">
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

<main class="content-container">
    <div class="title-h1">
        <h1>Create a New Recipe</h1>
    </div>

    <div class="form-container">
        <form method="POST" action="create_recipe.php" class="recipe-form">
            <div class="form-group">
                <label for="recipe_name">Recipe Name:</label>
                <input type="text" id="recipe_name" name="recipe_name" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="image">Image Path:</label>
                <input type="text" id="image" name="image" required>
            </div>
            <div class="form-group">
                <label for="cuisine">Cuisine:</label>
                <input type="text" id="cuisine" name="cuisine" placeholder="e.g., Italian, Mexican" required>
            </div>
            <div class="form-group">
                <label for="meal_type">Meal Type:</label>
                <input type="text" id="meal_type" name="meal_type" placeholder="e.g., Breakfast, Dinner" required>
            </div>

            <div class="form-group">
            <label for="ingredients">Ingredients and Quantities:</label>
            <div id="ingredients-container" class="dynamic-container">
                <div class="ingredient-row">
                    <input type="text" name="ingredients[]" placeholder="Ingredient 1" required>
                    <input type="text" name="quantities[]" placeholder="Quantity 1 (e.g., 1 cup)" required>
                </div>
            </div>
            <button type="button" class="add-button" onclick="addIngredient()">+ Add Ingredient</button>
            </div>


            <div class="form-group">
                <label for="steps">Steps:</label>
                <div id="steps-container" class="dynamic-container">
                    <textarea name="steps[]" placeholder="Step 1" rows="3" required></textarea>
                </div>
                <button type="button" class="add-button" onclick="addStep()">+ Add Step</button>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Create Recipe</button>
            </div>
        </form>
    </div>
</main>

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
        </div>
        <div class="footnote">
            <p>© 2024 PantryPal. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<script>
    function addIngredient() {
    const container = document.getElementById('ingredients-container');
    const row = document.createElement('div');
    row.classList.add('ingredient-row');

    const ingredientInput = document.createElement('input');
    ingredientInput.type = 'text';
    ingredientInput.name = 'ingredients[]';
    ingredientInput.placeholder = `Ingredient ${container.children.length + 1}`;
    ingredientInput.required = true;

    const quantityInput = document.createElement('input');
    quantityInput.type = 'text';
    quantityInput.name = 'quantities[]';
    quantityInput.placeholder = `Quantity ${container.children.length + 1} (e.g., 1 cup)`;
    quantityInput.required = true;

    row.appendChild(ingredientInput);
    row.appendChild(quantityInput);
    container.appendChild(row);
}


    function addStep() {
        const container = document.getElementById('steps-container');
        const textarea = document.createElement('textarea');
        textarea.name = 'steps[]';
        textarea.placeholder = `Step ${container.children.length + 1}`;
        textarea.rows = 3;
        textarea.required = true;
        container.appendChild(textarea);
    }
</script>
</body>
</html>

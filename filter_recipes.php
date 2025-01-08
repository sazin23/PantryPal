<?php
include('db_connect.php');

// Debugging: check if ingredients are received
if (isset($_POST['ingredients']) && !empty($_POST['ingredients'])) {
    $ingredientIDs = $_POST['ingredients'];

    // Debugging: log the selected ingredients
    error_log("Selected Ingredients: " . implode(', ', $ingredientIDs));

    $ingredientIDsList = implode(',', $ingredientIDs);

    $query = "
        SELECT DISTINCT r.RecipeID, r.RecipeName, r.Description, r.RecipeImage 
        FROM recipes r
        JOIN recipeingredients ri ON r.RecipeID = ri.RecipeID
        WHERE ri.IngredientID IN ($ingredientIDsList)
        GROUP BY r.RecipeID
        HAVING COUNT(DISTINCT ri.IngredientID) = " . count($ingredientIDs) . "
    ";

    $result = $conn->query($query);

    // Debugging: check if the query executed successfully
    if (!$result) {
        error_log("SQL Error: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $imagePath = 'images/' . $row['RecipeImage']; 
            $recipePageLink = "recipe_details.php?RecipeID=" . $row['RecipeID']; // Generate link to the recipe details page

            echo "
            <div class='recipe-card'>
                <a href='$recipePageLink'>
                    <img src='$imagePath' alt='{$row['RecipeName']}' class='filter-recipe-image'>
                </a>
                <h2><a href='$recipePageLink'>{$row['RecipeName']}</a></h2>
                <p>{$row['Description']}</p>
            </div>
            ";
        }
    } else {
        echo "<p>No recipes found matching the selected ingredients.</p>";
    }
} else {
    echo "<p>Please select ingredients to find recipes.</p>";
}
?>

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2025 at 08:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cookingrecipedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `IngredientID` int(11) NOT NULL,
  `IngredientName` varchar(100) NOT NULL,
  `Unit` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`IngredientID`, `IngredientName`, `Unit`) VALUES
(1, 'Flour', NULL),
(2, 'Sugar', NULL),
(3, 'Milk', NULL),
(4, 'Eggs', NULL),
(5, 'Salt', NULL),
(6, 'Butter', NULL),
(7, 'Cocoa Powder', NULL),
(12, 'Instant Coffee', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `recipeingredients`
--

CREATE TABLE `recipeingredients` (
  `RecipeID` int(11) NOT NULL,
  `IngredientID` int(11) NOT NULL,
  `Quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipeingredients`
--

INSERT INTO `recipeingredients` (`RecipeID`, `IngredientID`, `Quantity`) VALUES
(1, 1, 2),
(1, 2, 2),
(1, 3, 1),
(1, 4, 1),
(1, 5, 1),
(2, 1, 3),
(2, 2, 1.5),
(2, 4, 2),
(2, 6, 1),
(2, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `RecipeID` int(11) NOT NULL,
  `RecipeName` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `Cuisine` varchar(50) DEFAULT NULL,
  `MealType` varchar(50) DEFAULT NULL,
  `CookingTime` int(11) DEFAULT NULL,
  `RecipeImage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`RecipeID`, `RecipeName`, `Description`, `Cuisine`, `MealType`, `CookingTime`, `RecipeImage`) VALUES
(1, 'Pancakes', 'Fluffy and delicious pancakes made with simple ingredients.', NULL, NULL, 15, 'pancakes.webp'),
(2, 'Chocolate Cake', 'Rich and moist chocolate cake perfect for celebrations.', NULL, NULL, 45, 'chocolatecake.webp');

-- --------------------------------------------------------

--
-- Table structure for table `steps`
--

CREATE TABLE `steps` (
  `StepID` int(11) NOT NULL,
  `RecipeID` int(11) NOT NULL,
  `StepNumber` int(11) NOT NULL,
  `StepDescription` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `steps`
--

INSERT INTO `steps` (`StepID`, `RecipeID`, `StepNumber`, `StepDescription`) VALUES
(1, 1, 1, 'Mix flour, sugar, and salt in a bowl.'),
(2, 1, 2, 'Add milk and egg, and whisk until smooth.'),
(3, 1, 3, 'Heat a skillet and pour the batter.'),
(4, 1, 4, 'Flip pancakes when bubbles form, and cook until golden.'),
(5, 2, 1, 'Preheat the oven to 350°F (175°C).'),
(6, 2, 2, 'Mix flour, sugar, cocoa powder, and salt in a bowl.'),
(7, 2, 3, 'Add eggs and butter, and whisk until smooth.'),
(8, 2, 4, 'Pour the batter into a greased pan and bake for 45 minutes.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `JoinDate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `JoinDate`) VALUES
(1, 'john_doe', 'hashed_password_here', 'john@example.com', '2025-01-08 12:51:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`IngredientID`);

--
-- Indexes for table `recipeingredients`
--
ALTER TABLE `recipeingredients`
  ADD PRIMARY KEY (`RecipeID`,`IngredientID`),
  ADD KEY `IngredientID` (`IngredientID`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`RecipeID`);

--
-- Indexes for table `steps`
--
ALTER TABLE `steps`
  ADD PRIMARY KEY (`StepID`),
  ADD KEY `RecipeID` (`RecipeID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `IngredientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `RecipeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `steps`
--
ALTER TABLE `steps`
  MODIFY `StepID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recipeingredients`
--
ALTER TABLE `recipeingredients`
  ADD CONSTRAINT `recipeingredients_ibfk_1` FOREIGN KEY (`RecipeID`) REFERENCES `recipes` (`RecipeID`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipeingredients_ibfk_2` FOREIGN KEY (`IngredientID`) REFERENCES `ingredients` (`IngredientID`) ON DELETE CASCADE;

--
-- Constraints for table `steps`
--
ALTER TABLE `steps`
  ADD CONSTRAINT `steps_ibfk_1` FOREIGN KEY (`RecipeID`) REFERENCES `recipes` (`RecipeID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

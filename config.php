<?php
session_start();

// Database configuration
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "youtube-clone";

// Create a new MySQLi connection
$con = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
if ($con->connect_errno) {
    // Log the error message to a file
    error_log("Failed to connect to MySQL: " . $con->connect_error);
    // Display a user-friendly message
    echo "Sorry, this website is experiencing problems.";
    exit();
}

// Function to pretty print variables for debugging
function prettyDump($var) {
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}

// Function to sanitize user input
function sanitizeInput($input) {
    global $con;
    return $con->real_escape_string(htmlspecialchars($input));
}

// Function to close the database connection
function closeConnection() {
    global $con;
    $con->close();
}
?>
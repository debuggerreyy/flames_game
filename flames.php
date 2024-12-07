<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flames_hope_game";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$name1 = $_POST['name1'];
$name2 = $_POST['name2'];

// FLAMES HOPE Logic
$flames = ["Friendship", "Love", "Affection", "Marriage", "Enemy", "Sibling", "Hope", "Opportunity", "Prosperity", "Eternity"];
$name1 = strtolower(preg_replace('/\s+/', '', $name1));
$name2 = strtolower(preg_replace('/\s+/', '', $name2));

$commonLetters = array_intersect(str_split($name1), str_split($name2));
$remainingCount = strlen($name1) + strlen($name2) - 2 * count($commonLetters);

$resultIndex = ($remainingCount % count($flames)) - 1;
if ($resultIndex < 0) {
    $resultIndex = count($flames) - 1;
}
$result = $flames[$resultIndex];

// Save result in the database
$sql = "INSERT INTO results (name1, name2, result) VALUES ('$name1', '$name2', '$result')";
if ($conn->query($sql) === TRUE) {
    echo "<div style='background-color:#ffc0cb; padding:20px; text-align:center; font-size:1.5rem;'>";
    echo "<h1>FLAMES HOPE Result</h1>";
    echo "<p><strong>$name1</strong> and <strong>$name2</strong> = <strong>$result</strong></p>";
    echo "<a href='index.html' style='color: #fff; background-color: #ff69b4; padding: 10px; text-decoration: none; border-radius: 5px;'>Try Again</a>";
    echo "</div>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

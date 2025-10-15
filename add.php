<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Listing</title>
</head>
<body>
    <h1>Just Added</h1>

    <?php
    // Enable error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // See the contents of $_POST, submitted from index.html
    var_dump($_POST);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstname = htmlspecialchars($_POST['first']);
        $lastname  = htmlspecialchars($_POST['last']);
        $country   = htmlspecialchars($_POST['country']);

        echo "<p>Adding <strong>$firstname $lastname</strong> from $country.</p>";

        // Database credentials
        $servername = "localhost";
        $username = "user36";
        $password = "36oxon";
        $dbname = "db36";

        try {
            // Create PDO connection
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Insert record
            $stmt = $conn->prepare("INSERT INTO randuser (first, last, country) VALUES (:firstname, :lastname, :country)");
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':country', $country);

            echo "<div>";
            if ($stmt->execute()) {
                echo "<p>✅ New record created successfully</p>";
            } else {
                echo "<p>❌ Error: Unable to create a new record.</p>";
            }
            echo "</div>";

            // Retrieve all users
            $sql = "SELECT first, last, country FROM randuser";
            $result = $conn->query($sql);

            echo "<div>";
            echo "<table border='1' cellpadding='8'>";
            echo "<thead><tr><th>First Name</th><th>Last Name</th><th>Country</th></tr></thead><tbody>";

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['first']) . "</td>";
                echo "<td>" . htmlspecialchars($row['last']) . "</td>";
                echo "<td>" . htmlspecialchars($row['country']) . "</td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
            echo "</div>";

        } catch (PDOException $e) {
            echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
        }

        $conn = null;

    } else {
        echo "<p>No data was submitted.</p>";
    }
    ?>
</body>
</html>
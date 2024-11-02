<?php
session_start(); // Start the session to store user data

// Database configuration
$db_username = 'root';
$db_password = '';
$db_name = 'kibweziwest';
$db_host = 'localhost';

// Create a new MySQLi connection
$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check for connection errors
if ($mysqli->connect_error) {
    die("Connection failed: Please try again later.");
}

// Initialize message variable
$message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input data
    $id_number = $mysqli->real_escape_string(trim($_POST['id_number']));
    $first_name = $mysqli->real_escape_string(trim($_POST['first_name']));
    $last_name = $mysqli->real_escape_string(trim($_POST['last_name']));
    $ward = $mysqli->real_escape_string(trim($_POST['ward']));
    $email = $mysqli->real_escape_string(trim($_POST['email']));
    $phone = $mysqli->real_escape_string(trim($_POST['phone']));
    $password = $mysqli->real_escape_string(trim($_POST['password']));

    // Validate the inputs
    if (empty($id_number) || empty($first_name) || empty($last_name) || empty($ward) || empty($email) || empty($phone) || empty($password)) {
        $_SESSION['registration_message'] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['registration_message'] = "Invalid email format.";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $_SESSION['registration_message'] = "Phone number should be 10 digits.";
    } elseif (strlen($password) < 8) {
        $_SESSION['registration_message'] = "Password should be at least 8 characters.";
    } else {
        // Check for duplicates using a single query with UNION to combine the checks
        $check_duplicates_sql = "SELECT * FROM applicants WHERE id_number = ? OR email = ? OR phone = ?";
        $check_duplicates_stmt = $mysqli->prepare($check_duplicates_sql);
        $check_duplicates_stmt->bind_param("sss", $id_number, $email, $phone);
        $check_duplicates_stmt->execute();
        $duplicates_result = $check_duplicates_stmt->get_result();

        // Check if there are any duplicates
        if ($duplicates_result->num_rows > 0) {
            $_SESSION['registration_message'] = "Details  already exists.Try again please";
        } else {
            // If no duplicates, insert the new user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password before storing

            $sql = "INSERT INTO applicants (id_number, first_name, last_name, ward, email, phone, password) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("sssssss", $id_number, $first_name, $last_name, $ward, $email, $phone, $hashed_password);

            // Execute the statement
            if ($stmt->execute()) {
                // Store a success message in session
                $_SESSION['registration_message'] = "User registered successfully.";
            } else {
                // Store a failure message in session
                $_SESSION['registration_message'] = "Error: Please try again later.";
            }

            // Close the statement
            $stmt->close();
        }

        // Close the prepared statement for duplicate check
        $check_duplicates_stmt->close();
    }

    // Redirect to registration_page.php to display messages
    header("Location: registration_page.php");
    exit();
}

// Close the database connection
$mysqli->close();
?>

<?php 
// Database configuration
$db_username = 'root';
$db_password = '';
$db_name = 'kibweziwest';
$db_host = 'localhost';

// Create a new MySQLi connection
$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check for connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Initialize message variable
$message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input data
    $email = $mysqli->real_escape_string(trim($_POST['email']));
    $password = $mysqli->real_escape_string(trim($_POST['password']));

    // Check if the user exists
    $sql = "SELECT * FROM applicants WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables
            session_start();
            $_SESSION['user_id'] = $user['id']; // Assuming you have an 'id' field
            header("Location: dashboard.php"); // Redirect to dashboard
            exit();
        } else {
            $message = "Invalid email or password.";
        }
    } else {
        $message = "No user found with this email.";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bursary Application System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Include your stylesheet here -->
    <style>
        .login-container {
        width: 34%;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: wheat;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add shadow */
    }
    

        .login-container h2 {
            text-align: center;
            color: black;
            margin-bottom: 20px;
        }

        .login-container label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bolder;
            color: black; /* Set label color to black */
            text-align: center; /* Center align the labels */
        }

        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            border-color: #007BFF;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Add focus effect */
        }

        .login-container input[type="submit"] {
            width: 85%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            margin-left: 5%;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-container input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            width: 89%;
            text-align: center;
        }


        /* Responsive Design */
        @media (max-width: 768px) {
            .login-container {
                width: 60%;
                padding: 7px;
            }

            .login-container h2 {
                font-size: 1.5em;
            }

            .login-container input[type="email"],
            .login-container input[type="password"] {
                padding: 6px;
            }

            .login-container input[type="submit"] {
                padding: 8px;
                font-size: 1em;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                width: 75%;
                padding: 10px;
            }

            .login-container h2 {
                font-size: 1.2em;
            }

            .login-container input[type="email"],
            .login-container input[type="password"] {
                padding: 6px;
            }

            .login-container input[type="submit"] {
                padding: 6px;
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <img src="image/cdflogo.png" alt="CDF Logo" style="margin-bottom: -6%;">
            <h1 style="color: rgb(15, 15, 15); margin-left: 10%; font-size: 20px;">Kibwezi West Constituency Bursary Application</h1>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="#about">About</a></li> 
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
    <section> <!-- Login Form -->
    <div class="login-container">
        <h2>Login</h2>
        <?php if ($message): ?>
            <p class="error"><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="password">Password:</label>
            <div style="display: flex; align-items: center;">
                <input type="password" id="password" name="password" required>
                <i class="fas fa-eye" id="togglePassword" onclick="togglePassword('password', this)" style="cursor: pointer; margin-left: 10px;"></i>
            </div>
            <p style="margin-left:25%;"> Not registered. <a href="registration.php" class="btn" >Register</a></p>
            <input type="submit" value="Login">
        </form>
    </div>
</section>


<script>
function togglePassword(fieldId, icon) {
    const passwordField = document.getElementById(fieldId);
    const type = passwordField.type === "password" ? "text" : "password";
    passwordField.type = type;

    // Change the icon based on the visibility
    icon.classList.toggle("fa-eye");
    icon.classList.toggle("fa-eye-slash");
}
</script>


        <section id="about">
            <div class="container">
                <h2 class="center-text">About the Bursary Program</h2>
                <p class="center-text">The Kibwezi West Constituency Bursary program aims to assist students in need of financial aid to further their education.</p>
                <!-- Add more information as needed -->
            </div>
        </section>
    </main>

    <footer id="contact">
        <div class="container">
            <p>Contact us at: Cell: 0720104432 &nbsp; <br>Email: <b><a href="mailto:cdfkibweziwest@cdf.go.ke">cdfkibweziwest@cdf.go.ke</a></b> <br> <b>
                NG-CDF-Kibwezi West Constituency<br>
                Makindu Sub-County Headquarter.<br>
                P.O Box 136-90138
                Makindu, Kenya
            </b></p>
        </div>
        <p>&copy; 2024 Kibwezi West Constituency. All rights reserved.</p>
    </footer>
</body>
</html>

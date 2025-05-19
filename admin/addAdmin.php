<?php
//Including database connection
include '../databaseConnection.php';

//Check if user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

//Function to insert admin
function insertAdmin($conn, $email, $password)
{
    //Hashing the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO administrators (email, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $hashed_password);

    if ($stmt->execute()) {
        return "Admin inserted successfully";
    } else {
        return "Error inserting admin: " . $stmt->error;
    }
}

//Processing form submission
$message = '';
$alertClass = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    //Validating email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
        $alertClass = "alert-danger";
    } else {
        $message = insertAdmin($conn, $email, $password);
        $alertClass = strpos($message, "Error") !== false ? "alert-danger" : "alert-success";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Add Administrator</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../CSS/adminStyle.css">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }

    body {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f2f2f2;
    }

    .container {
        width: 100%;
        max-width: 600px;
        padding: 20px;
    }

    .login-box {
        background-color: #f2f2f2;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .login-box h2 {
        margin: 0 0 15px;
        padding: 0;
        color: #333;
        text-align: center;
        text-transform: uppercase;
    }

    .user-box {
        position: relative;
        margin-bottom: 30px;
    }

    .user-box input {
        width: 100%;
        padding: 12px 20px;
        font-size: 16px;
        color: #333;
        margin-bottom: 30px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background: white;
    }

    .user-box label {
        position: absolute;
        top: -20px;
        left: 0;
        font-size: 16px;
        color: black;
    }

    .login-submit {
        width: 100%;
        background-color: #4CAF50;
        color: white;
        font-size: 16px;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .login-submit:hover {
        background-color: #45a049;
    }

    .password-toggle-icon {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .password-toggle-icon i {
        font-size: 18px;
        line-height: 1;
        color: #666;
        transition: color 0.3s ease-in-out;
        margin-bottom: 20px;
    }

    .password-toggle-icon i:hover {
        color: #333;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
</style>

<body>

    <div class="admin-nav">
        <div class="admin-nav-brand">
            <i class="fa fa-lock"></i> Admin Portal
        </div>
        <div class="admin-nav-links">
            <a href="adminPanel.php"><i class="fa fa-dashboard"></i> Dashboard</a>
            <a href="addAdmin.php" class="active"><i class="fa fa-user-plus"></i> Add Admin</a>
            <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="login-box">
            <h2>Add Administrator</h2>
            <br>
            <?php if (!empty($message)): ?>
                <div class="alert <?php echo $alertClass; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <form method="post">
                <div class="user-box">
                    <label>Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter email address..." required>
                </div>
                <div class="user-box">
                    <label>Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password..." required>
                    <span class="password-toggle-icon"><i class="fas fa-eye"></i></span>
                </div>
                <input type="submit" value="Add Administrator" class="login-submit">
            </form>
        </div>
    </div>
    <script>
        const passwordField = document.getElementById("password");
        const togglePassword = document.querySelector(".password-toggle-icon i");

        togglePassword.addEventListener("click", function() {
            if (passwordField.type === "password") {
                passwordField.type = "text";
                togglePassword.classList.remove("fa-eye");
                togglePassword.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                togglePassword.classList.remove("fa-eye-slash");
                togglePassword.classList.add("fa-eye");
            }
        });

        //Auto hide alert messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            var alert = document.querySelector('.alert');
            if (alert) {
                setTimeout(function() {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }, 5000);
            }
        });
    </script>
</body>

</html>
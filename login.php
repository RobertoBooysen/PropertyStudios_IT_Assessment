<?php
//Including database connection
include 'databaseConnection.php';

$message = '';
$alertClass = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    //Preparing SQL statement
    $sql = "SELECT id, email, password FROM administrators WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            //Starting session and store user data
            session_start();
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_email'] = $user['email'];
            
            //Redirecting to admin panel
            header("Location: admin/adminPanel.php");
            exit();
        } else {
            $message = "Invalid password";
            $alertClass = "alert-danger";
        }
    } else {
        $message = "Email not found";
        $alertClass = "alert-danger";
    }
    
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

    /*Form container styling*/
    .container {
        width: 100%;
        max-width: 600px;
        padding: 20px;
    }

    /*Form input styling*/
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

    /*Submit Button Styling*/
    .login-submit {
        width: 100%;
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-transform: uppercase;
        text-decoration: none;
        text-align: center;
        display: inline-block;
        transition: background-color 0.3s;
    }

    .login-submit:hover {
        background-color: #45a049;
    }

    /*Password input styling*/
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

    /*Login submit button styling*/
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

    /*Alert message styling*/
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
    <div class="container">
        <div class="login-box">
            <h2>Login</h2>
            <br>
            <?php if (!empty($message)): ?>
                <div class="alert <?php echo $alertClass; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <form action="" method="post">
                <div class="user-box">
                    <label>Email</label>
                    <input type="email" id="email" name="email" placeholder="Your email.." required />
                </div>
                <div class="user-box">
                    <label>Password</label>
                    <input type="password" id="password" name="password" placeholder="Your password..." required />
                    <span class="password-toggle-icon"><i class="fas fa-eye"></i></span>
                </div>

                <input type="submit" value="Submit" class="login-submit">
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
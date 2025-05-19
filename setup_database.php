<?php
//Including database connection
include 'databaseConnection.php';

//Function to create tables
function createTables($conn)
{
    //Creating contact form table
    $contact_form_sql = "CREATE TABLE IF NOT EXISTS contact_form (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        date_submitted DATETIME DEFAULT CURRENT_TIMESTAMP
    )";

    //Creating administrators table
    $administrators_sql = "CREATE TABLE IF NOT EXISTS administrators (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    //Execute table creation queries
    if ($conn->query($contact_form_sql) === TRUE && $conn->query($administrators_sql) === TRUE) {
        return "Tables created successfully";
    } else {
        return "Error creating tables: " . $conn->error;
    }
}

//Function to insert preloaded administrators
function insertPreloadedAdmins($conn)
{
    $admins = [
        [
            'email' => 'robertobooysen11@gmail.com',
            'password' => 'Roberto11'
        ],
        [
            'email' => 'nadia@propertystudios.co.uk',
            'password' => 'Nadia2025'
        ]
    ];

    $success = true;
    $message = "";

    foreach ($admins as $admin) {
        //Hashing the password
        $hashed_password = password_hash($admin['password'], PASSWORD_DEFAULT);

        //Checking if admin already exists
        $check_sql = "SELECT id FROM administrators WHERE email = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $admin['email']);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        if ($result->num_rows === 0) {
            //Inserting new admin
            $sql = "INSERT INTO administrators (email, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $admin['email'], $hashed_password);

            if (!$stmt->execute()) {
                $success = false;
                $message .= "Error inserting admin {$admin['email']}: " . $stmt->error . "<br>";
            }
            $stmt->close();
        }
        $check_stmt->close();
    }

    if ($success) {
        return "Preloaded administrators added successfully";
    } else {
        return $message;
    }
}

//Running the setup automatically
$table_message = createTables($conn);
if (strpos($table_message, "Error") === false) {
    $admin_message = insertPreloadedAdmins($conn);
    $message = $table_message . "<br>" . $admin_message;
    $alertClass = strpos($admin_message, "Error") !== false ? "alert-danger" : "alert-success";
} else {
    $message = $table_message;
    $alertClass = "alert-danger";
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Database Setup</title>
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

        /*Container styling*/
        .container {
            width: 100%;
            max-width: 600px;
            padding: 20px;
        }

        .setup-container {
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .setup-container h2 {
            margin: 0 0 15px;
            padding: 0;
            color: #333;
            text-align: center;
            text-transform: uppercase;
        }

        /*Button styling*/
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            text-transform: uppercase;
            transition: background-color 0.3s;
        }

        .btn:hover {
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

        .preloaded-admins {
            margin: 20px 0;
            padding: 15px;
            background-color: #fff;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .preloaded-admins h3 {
            margin-top: 0;
            color: #333;
            font-size: 16px;
        }

        .preloaded-admins ul {
            list-style: none;
            padding: 0;
        }

        .preloaded-admins li {
            margin: 10px 0;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="setup-container">
            <h2>Database Setup Complete</h2>

            <?php if (!empty($message)): ?>
                <div class="alert <?php echo $alertClass; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="preloaded-admins">
                <h3>Preloaded Administrators:</h3>
                <ul>
                    <li>Email: robertobooysen11@gmail.com</li>
                    <li>Email: nadia@propertystudios.co.uk</li>
                </ul>
            </div>

            <a href="index.php" class="btn">Go to Home Page</a>
        </div>
    </div>

    <script>
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
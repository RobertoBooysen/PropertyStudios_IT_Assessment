<?php
//Including database connection
include 'databaseConnection.php';

//Initializing variables for message handling
$message = '';
$alertClass = '';

//Processing form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Getting form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message_text = $_POST['message'];
    
    //Validating email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
        $alertClass = "alert-danger";
    } else {
        //Preparing and executing database insertion
        $sql = "INSERT INTO contact_form (name, email, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $message_text);
        
        //Checking if insertion was successful
        if ($stmt->execute()) {
            $message = "Thank you for your message! We will get back to you soon.";
            $alertClass = "alert-success";
        } else {
            $message = "Sorry, there was an error sending your message. Please try again later.";
            $alertClass = "alert-danger";
        }
        
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="CSS/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
/*Form input styling*/
.contact-input {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

/*Submit button styling*/
.contact-submit {
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

.contact-submit:hover {
  background-color: #45a049;
}

/*Form container styling*/
.contact-container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
  max-width: 600px;
  margin: 20px auto;
}

/*Alert container styling*/
.alert-container {
  max-width: 600px;
  margin: 20px auto;
}

/*Introduction text styling*/
.contact-intro {
  text-align: center;
  max-width: 600px;
  margin: 0 auto 20px;
  color: #666;
  font-size: 16px;
  line-height: 1.5;
}

/*Alert message styling*/
.custom-alert {
  padding: 15px;
  margin-bottom: 20px;
  border: 1px solid transparent;
  border-radius: 4px;
  position: relative;
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

/*Alert close button styling*/
.alert-close {
  position: absolute;
  right: 10px;
  top: 10px;
  color: inherit;
  text-decoration: none;
  font-size: 20px;
  font-weight: bold;
  cursor: pointer;
}

.alert-close:hover {
  opacity: 0.7;
}
</style>
</head>
<body>

<div class="topnav" id="myTopnav">
  <a href="index.php"><i class="fa fa-home"></i> Home</a>
  <a href="aboutUs.php"><i class="fa fa-info-circle"></i> About Us</a>
  <a href="contactUs.php"><i class="fa fa-envelope"></i> Contact Us</a>
  <a href="login.php"><i class="fa fa-sign-in"></i> Login</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>

<h1>Contact Us</h1>

<p class="contact-intro">Fill out the form below to get in touch with us. We'll get back to you as soon as possible.</p>

<?php if (!empty($message)): ?>
    <div class="alert-container">
        <div class="custom-alert <?php echo $alertClass; ?>" id="messageAlert">
            <a href="#" class="alert-close" onclick="this.parentElement.style.display='none';">&times;</a>
            <?php echo $message; ?>
        </div>
    </div>
<?php endif; ?>

<div class="contact-container">
    <form action="contactUs.php" method="post">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" class="contact-input" placeholder="Your full name.." required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" class="contact-input" placeholder="Your email.." required>

        <label for="message">Message</label>
        <textarea id="message" name="message" class="contact-input" placeholder="Write something.." required></textarea>
      
        <input type="submit" value="Submit" class="contact-submit">
    </form>
</div>

<div class="footer">
    <p>Footer</p>
  </div>

<script>
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}

//Showcasing active link
document.addEventListener("DOMContentLoaded", function () {
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll(".topnav a");

    navLinks.forEach(link => {
        const linkHref = link.getAttribute("href");
        if (linkHref === currentPage || 
            (currentPage === "" && linkHref === "index.html") ||
            (currentPage === "index.html" && linkHref === "index.html")) {
            link.classList.add("active");
        }
    });
});

// Auto dismiss alert after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    var alert = document.getElementById('messageAlert');
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
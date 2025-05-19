<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="CSS/style.css">
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

  <h1>Home</h1>

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
    document.addEventListener("DOMContentLoaded", function() {
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
  </script>

</body>

</html>
<?php
    if(isset($_COOKIE["userID"]))
    {
        header("Location:accounthome.php");
    }
?>

<html>

    <head>
        <title>Eat&Rate.com</title>
        <link rel="stylesheet" type="text/css" href="css/homepage.css">
    </head>

    <body>

        <header>
            <a class="logo" href="homepage.php">
                <img src="images/logo.png" alt="Eat&Rate.com Logo" height="100" width="420">
            </a>
            <nav>
                <ul>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="">About</a></li>
                </ul>
            </nav>
        </header>

        <section class="homepage-section-1">
            <div class="container">
                <h1 class="quote">
                    Share your experiences through posts
                    <span>and let others know what every bite tastes like</span>
                </h1>
                <a class="button button-accent" href="usersignup.php">Sign Up</a>
            </div>
        </section>

        <section class="homepage-section-2">
            <div class="container">
                <h1 class="quote">
                    Create and manage your restaurant profile
                    <span>and give updates about delicious food, exciting offers and discounts</span>
                </h1>
                <a class="button button-accent" href="restaurantsignup.php">Sign Up</a>
            </div>
        </section>

        <footer>
            <div class="container">
                <hr>

                <p class="contact-us">
                    For any inquiry or to send your feedback<br>
                    Email us at
                    <span>eat&rate@business.official.com</span>
                </p>

                <p class="docs">
                    <a href="">Terms & Conditions</a> | <a href="">Privacy Policy</a>
                </p>

                <p class="copyright">
                    © 2020 Eat&Rate.com . All Rights Reserved
                </p>

                <hr class="bottomline">
            </div>
        </footer>

    </body>

</html>

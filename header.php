<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name=viewport content="width=device-width, initial-scale=1">
        <title></title>
        <link rel="stylesheet" href="loginStyle.css">

        
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <!-- Compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="sidenav_init.js"></script>

    </head>
    <body>  

        <header>
            <nav>
                <div class="nav-wrapper">
                    <a href="#!" class="brand-logo">Logo</a>
                    <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                    <ul class="right hide-on-med-and-down">
                        <li><a href="index.php">HOME</a></li>
                        <li><a href="#">MENU 1</a></li>
                        <li><a href="#">MENU 2</a></li>
                        <li><a href="#">CONTACT</a></li>
                        <li>

                        <?php
                            if (isset($_SESSION["userId"])) {
                                echo '
                                    <a href="includes/logout.inc.php" class="btn" >LOGOUT</a>
                                    <a class="right">Logged in as: '.$_SESSION["userUid"].'<a>';
                                }
                                else {
                                    echo '<a href="signup.php" class="btn" >SIGN UP</a>
                                          <a href="login.php" class="btn" >LOGIN</a>
                                    ';
                            }
                        ?>

                        </li>

                    </ul>

                    <ul class="sidenav" id="mobile-demo">
                        <li><a href="index.php">HOME</a></li>
                        <li><a href="#">MENU 1</a></li>
                        <li><a href="#">MENU 2</a></li>
                        <li><a href="#">CONTACT</a></li>
                        <li>

                        <?php
                            if (isset($_SESSION["userId"])) {
                                echo '
                                    <a href="includes/logout.inc.php" class="btn" >LOGOUT</a>
                                    ';
                                }
                                else {
                                    echo '<a href="signup.php" class="btn" >SIGN UP</a>
                                          <a href="login.php" class="btn" >LOGIN</a>
                                    ';
                            }
                        ?>

                        </li>
                    </ul>

                </div>

            </nav>
        </header>

        
    </body>
</html>
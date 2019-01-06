<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr" xml:lang="en"> <!-- prevents Chrome thinking pages are in Luxembourgish! -->
    <head>
        <meta charset="utf-8">
        <meta name="description">

        <!-- stops auto resizing on mobile when moving to lanscape -->
        <meta name=viewport content="width=device-width, initial-scale=1 user-scalable=yes, maximum-scale=1.6, minimum-scale=0.6 "> 
        
        <title></title>
        
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <!-- Compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="materialize_init.js"></script>

        <link rel="stylesheet" href="stylesheet.css">
        <link rel="stylesheet" href="loginStyle.css">

    </head>
    <body>  

        <header>
            <nav>
                <div class="nav-wrapper">
                    <a href="index.php" class="brand-logo">RowAndGo!</a>
                    <a href="#.php" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                    <ul class="right hide-on-med-and-down">
                        <li><a href="index.php">HOME</a></li>
                        <li><a href="addScore.php">ADD SCORE</a></li>
                        <li><a href="seeLog.php">SEE LOG</a></li>
                        <li><a href="contact.php">CONTACT</a></li>
                        <li>

                        <?php
                            if (isset($_SESSION["userId"])) {
                                echo '
                                    <a href="includes/logout.inc.php" class="btn" >LOGOUT</a>
                                    <a class="right">Logged in as: '.$_SESSION["userEmail"].'<a>';
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
                        <li><a href="addScore.php">ADD SCORE</a></li>
                        <li><a href="seeLog.php">SEE LOG</a></li>
                        <li><a href="contact.php">CONTACT</a></li>
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
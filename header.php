<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr" xml:lang="en"> <!-- prevents Chrome thinking pages are in Luxembourgish! -->
    <head>

        <title>Row&Go! - Erg score tracking and compare to other rowers!</title>
        <meta charset="utf-8">
        <meta name="description" content="(Test app) Rowing app for recording your rowing machine erg scores and comparing to others. Row&Go!">

        <!-- stops auto resizing on mobile when moving to lanscape -->
        <meta name=viewport content="width=device-width, initial-scale=1 user-scalable=yes, maximum-scale=1.6, minimum-scale=0.6 "> 
        
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <!-- Compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">        
        <script src="materialize_init.js"></script>

        <link rel="stylesheet" href="stylesheet.css">     
        <link rel="shortcut icon" href="pics/favRowAndGoIcon3.png" type="image/x-icon">

    </head>

    <body>  

        <header>

            <nav>
                <div class="nav-wrapper">
                    <a href="index.php" id="menuLogo" class="brand-logo"><img height="16px" src="pics/rowing_double.png"/>Row&Go!</a>
                    <a href="#.php" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                    <ul class="right hide-on-med-and-down">
                        <li><a href="index.php">HOME</a></li>
                        <li><a href="addScore.php">ADD SCORE</a></li>
                        <li><a href="viewScores.php">VIEW SCORES</a></li>
                        <li><a id="dload" class="tooltipped" data-position="bottom" data-tooltip="as csv (use in Excel)" href="downloadResults.php">DOWNLOAD SCORES</a></li>  
                        <li><a href="contact.php">CONTACT</a></li>
                        <li>

                        <?php
                            if (isset($_SESSION["userId"])) {
                                echo '
                                    <a href="includes/logout.inc.php" class="btn" >LOGOUT</a></li>
                                    <li><a href="signup.php?edit=y" class="right nilLM">'.$_SESSION["userEmail"].'</a><i class="material-icons right nilLM">account_circle</i>';
                                    
                                }
                                else {
                                    echo '<a href="signup.php" class="btn" >SIGN UP</a></li>
                                          <li><a href="login.php" class="btn" >LOGIN</a>
                                    ';
                            }
                        ?>

                        </li>

                    </ul>

                    <ul class="sidenav" id="mobile-demo">
                        <li><a href="index.php" id="mobileMenu" class="red lighten-2"><img height="16px" src="pics/rowing_double.png"/>Row&Go!</a><li>
                        <li><a href="index.php">HOME</a></li>
                        <li><a href="addScore.php">ADD SCORE</a></li>
                        <li><a href="viewScores.php">VIEW SCORES</a></li>
                        <li><a id="dload" class="tooltipped" data-position="bottom" data-tooltip="as csv (use in Excel)" href="downloadResults.php">DOWNLOAD SCORES</a></li>   
                        <li><a href="contact.php">CONTACT</a></li>
                        <li>

                        <?php
                            if (isset($_SESSION["userId"])) {
                                echo '
                                    <a href="includes/logout.inc.php" class="btn" >LOGOUT</a></li>
                                    <li class="valign-wrapper"><i class="material-icons nilLM left ablack">account_circle</i><a id="acName" href="signup.php?edit=y"> '.$_SESSION["userEmail"].'</a>'; 
                                }
                                else {
                                    echo '<a href="signup.php" class="btn" >SIGN UP</a></li>
                                          <li><a href="login.php" class="btn" >LOGIN</a>
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

<!-- <a href="#" class="right">Logged in as: '.$_SESSION["userEmail"].'</a>'; -->
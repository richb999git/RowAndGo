<?php
    require "header.php";
?>

    <main>
        <?php
            //if (isset($_SESSION["userId"])) {
            //    echo "<p>You are logged in ".$_SESSION["userUid"]."!</p>";
            //}
            //else {
            //    echo "<p>You are logged out!</p>";
            //}
            if (isset($_GET["error"])) {
                
                if ($_GET["error"] == "notloggedin") {
                    echo '

                    <div class="row">
                        <div class="col s12 m4 offset-m4">
                        <div class="card-panel teal center-align z-depth-3">
                            <span class="white-text">You need to be logged in!
                            
                            </span>
                        </div>
                        </div>
                    </div>

                    '
                    ;
                }

            } else {

            }

            echo '
                <div class="center-align">
                    <img width=100% widtht=1000px  src="pics/r2.jpg" alt="">
                    <h4>Enter your scores and see how you improve!</h4>
                </div>
            '
            

        ?>
        
        
        
        

    </main>

<?php
    require "footer.php";
?>

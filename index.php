<?php
    require "header.php";
?>

    <main>
        <?php

            if (isset($_GET["error"])) {                

                if ($_GET["error"] == "notloggedin") {
                    $errorMessage = "You need to be logged in!";
                } else if ($_GET["error"] == "DELETE_OK") {
                    $errorMessage = "Score deleted successfully";
                } else if ($_GET["error"] == "DELETE_ERROR") {
                    $errorMessage = "Error deleting score";
                } else if ($_GET["error"] == "nodirectaccess") {
                    $errorMessage = "Access denied";
                } else if ($_GET["error"] == "sqlerror") {
                    $errorMessage = "Database error when updating. Please try again.";
                } else if ($_GET["error"] == "REPORT_ERROR") {
                    $errorMessage = "Database error when reporting. Please try again.";
                } else if ($_GET["error"] == "invalidScoreID") {
                    $errorMessage = "Invalid score ID";
                } else { $errorMessage = "Error";} ?>
                    
                    <div class="row">
                        <div class="col s12 m4 offset-m4">
                            <div class="card-panel teal center-align z-depth-3">
                                <span class="white-text"><?= $errorMessage ?></span>

                     
                    <?php if ($errorMessage == "Score deleted successfully") { ?>
                        
                        <p><a class="btn white-text" href="javascript:history.go(-2)">Back to scores</a></p>

                    <?php } ?>
                    
                            </div>
                        </div>
                    </div>

                    <?php
                    require "seeLog/sqlSpinner.php";

            } else if (isset($_GET["update_success"])) { ?>
                    
                    <div class="row">
                        <div class="col s12 m4 offset-m4">
                            <div class="card-panel teal center-align z-depth-3">
                                <span class="white-text">Score update successful</span> 
                            </div>
                        </div>
                    </div>
                    
            <?php
            } else if (isset($_GET["edit_success"])) { ?>
                    
                    <div class="row">
                        <div class="col s12 m6 l4 offset-m3 offset-l4" >
                            <div class="card-panel teal center-align z-depth-3">
                                <p class="white-text">Score update successful</p> 
                                <p><a class="btn white-text" href="javascript:history.go(-2)">Back to scores</a></p>
                            </div>
                        </div>
                    </div>
            <?php
                    require "seeLog/sqlSpinner.php";
            }
            ?>
                <div class="center-align">
                    <img width=100% src="pics/r2.jpg" alt="personRowing">
                    <h4>Log your training scores and compare with other rowers!</h4>
                </div>
        <br/>
        <div class="center-align"><img width=95% id="screenshot" src="pics/screen5.png" alt=""></div>
        <br/>
    </main>
    
<?php
    require "footer.php";

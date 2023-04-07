<?php
    require "header.php";
?>

<img width=100% src="pics/header2.jpg" alt="rowing 8 header">

<?php
    if (isset($_SESSION["userId"])) { ?>

    <!-- // get method used so that back button works. Data is not sensitive. -->
     
    <h4 id="SignUpTitle">View Erg Scores</h4>
    <div class="row">
        <br/>
        <form class="col s10 m6 l6" action="seeLog.php" method="get">

            <div class="row">
                <div class="input-field col s10 m10 l6 offset-s2 offset-m7 offset-l9 marginReduce20 radBox"> 
                    <p>
                        <label>
                            <input name="whichErgs" class="with-gap" type="radio" value="Mine" checked/>
                            <span>Mine</span>
                        </label>
                    </p>
                    <p>
                        <label>
                            <input name="whichErgs" class="with-gap" type="radio" value="Club" />
                            <span>Club</span>
                        </label>
                    </p>
                    <p>
                        <label>
                            <input name="whichErgs" class="with-gap" type="radio" value="All" />
                            <span>All</span>
                        </label>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s10 m10 l6 offset-s2 offset-m7 offset-l9 marginReduce20 radBox">
                    <p>
                        <label>
                            <input name="reportType" class="with-gap" type="radio" value="Calendar" checked/>
                            <span>Calendar</span>
                        </label>
                    </p>
                    <p>
                        <label>
                            <input name="reportType" class="with-gap" type="radio" value="BestAll" />
                            <span>All time bests</span>
                        </label>
                    </p>
                    <p>
                        <label>
                            <input name="reportType" class="with-gap" type="radio" value="BestYear" />
                            <span>Year's best (Calendar year)</span>
                        </label>
                    </p>
                </div>
            </div>



            <div class="row">
                <div class="input-field col s12 m12 l8 offset-s1 offset-m6 offset-l8 marginReduce20">
                    <button class="btn btn100" type="submit" name="log-submit">VIEW SCORES</button>
                </div>
            </div>

        </form>
    </div>

    <?php
    require "seeLog/sqlSpinner.php";

    } else {
        // header("Location: index.php?error=notloggedin");
        // exit();
        if (headers_sent()) {
            die("Redirect failed. Please click on this link: <a href=...>");
        }
        else{
            exit(header("Location: index.php?error=notloggedin"));
        }
    }
?>

<?php
    require "footer.php";

<?php
    require "header.php";
?>

<?php
    if (isset($_SESSION["userId"])) {
?>
    
        <main>
            <img width=100% src="pics/header2.jpg" alt="rowing 8 header">
            <h4 id="SignUpTitle">Add Erg Score</h4>
            <div class="row">
                    <br/>
                    <form class="col s8 m5 l4" action="addScoreMain.php" method="post">

                        <div class="row">    
                            <div class="input-field col s12 offset-s3 offset-m8 offset-l12 marginReduce20">
                                <select name="distOrTime">                             
                                    <option value="distance">Distance</option>
                                    <option value="time">Time</option>
                                </select>
                                <label>Distance or Time?</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12 offset-s3 offset-m8 offset-l12 marginReduce20">
                                <div class="input-field col s6">
                                    <button class="btn btn100" type="submit" name="scoreType-submit">ENTER SCORE</button>
                                </div>
                                <div class="input-field col s6">
                                    <a href="index.php" class="btn btn100" type="button" name="log-cancel">CANCEL</a>
                                </div>
                            </div>
                        </div>

                    </form>
            </div>
            <br><br><br><br><br><br><br>

        </main>

<?php
    // } else {
    //     header("Location: index.php?error=notloggedin");
    //     exit();
    // }
    } else {
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

<?php
    require "header.php";
?>

    <main>
        
        <h4 id="SignUpTitle">LOGIN</h4>
        <?php
            $userEmail = "";
            if (isset($_GET["mailuid"])) {
                $userEmail = $_GET["mailuid"];
            }
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyfields") {
                    echo "<p class='errorSignUp'>Fill in all fields!</p>";
                }
                else if ($_GET["error"] == "wrongpwd") {
                    echo "<p class='errorSignUp'>Wrong password!</p>";
                }
                else if ($_GET["error"] == "nouser") {
                    echo "<p class='errorSignUp'>No such user!</p>";
                }               
            }
            else if (isset($_GET["login"])) { // == "success")) {
                echo "<p class='successSignUp'>Login successful!</p>"; // just for illustration
            }
        echo '
            <div class="row">
                <br/>
                <form class="col s8 m5 l4" action="includes/login.inc.php" method="post">
                
                    <div class="row">
                        <div class="input-field col s12 offset-s3 offset-m8 offset-l12 marginReduce20">
                            <input id="user-email" type="text" class="validate" name="mailuid" value="'.$userEmail.'" required>
                            <label for="user-email">Username/Email</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12 offset-s3 offset-m8 offset-l12 marginReduce20">
                            <input id="password" type="password" class="validate" name="pwd" required>
                            <label for="password">Password</label>
                            <br/><br/><br/>
                            <button class="btn btn100" type="submit" name="login-submit">LOGIN</button>
                        </div>
                    </div>

                </form>
            </div>
            '
        ?>
    </main>

<?php
    require "footer.php";
?>


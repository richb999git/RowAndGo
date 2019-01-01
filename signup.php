<?php
    require "header.php";
?>

    <main>
        
        <h4 id="SignUpTitle">SIGN UP</h4>
        <?php
            $username = "";
            if (isset($_GET["uid"])) {
                $username = $_GET["uid"];
            }
            $email = "";
            if (isset($_GET["mail"])) {
                $email = $_GET["mail"];
            }
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyfields") {
                    echo "<p class='errorSignUp'>Fill in all fields!</p>";
                }
                else if ($_GET["error"] == "invalidmailuid") {
                    echo "<p class='errorSignUp'>Invalid username and email!</p>";
                }
                else if ($_GET["error"] == "invaliduid") {
                    echo "<p class='errorSignUp'>Invalid username!</p>";
                }
                else if ($_GET["error"] == "invalidmail") {
                    echo "<p class='errorSignUp'>Invalid email!</p>";
                }
                else if ($_GET["error"] == "passwordcheck") {
                    echo "<p class='errorSignUp'>Your passwords do not match!</p>";
                }
                else if ($_GET["error"] == "usernametaken") {
                    echo "<p class='errorSignUp'>Username is already taken!</p>";
                }
            }
            else if (isset($_GET["signup"])) { // == "success")) {
                echo "<p class='successSignUp'>Sign up successful!</p>";
            }
        echo '
            <div class="row">
                <br/>
                <form class="col s8 m5 l4" action="includes/signup.inc.php" method="post">
                
                    <div class="row">
                        <div class="input-field col s12 offset-s3 offset-m8 offset-l12 marginReduce20">
                            <input id="username" type="text" class="validate" name="uid" value="'.$username.'" required>
                            <label for="username">Username</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12 offset-s3 offset-m8 offset-l12 marginReduce20">
                            <input id="email" type="email" class="validate" name="mail" value="'.$email.'" required>
                            <label for="email">Email</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12 offset-s3 offset-m8 offset-l12 marginReduce20">
                            <input id="password" type="password" class="validate" name="pwd" required>
                            <label for="password">Password</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12 offset-s3 offset-m8 offset-l12 marginReduce20">
                            <input id="password-repeat" type="password" class="validate" name="pwd-repeat" required>
                            <label for="password-repeat">Repeat Password</label>
                            <br/><br/><br/>
                            <button class="btn btn100" type="submit" name="signup-submit">SIGN UP</button>
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

         <!--   <div class="row">
                <br/><br/>
                <form class="col s8 m5 l4" action="includes/signup.inc.php" method="post">
                
                    <div class="row">
                        <div class="input-field col s12 offset-s3 offset-m8 offset-l12">
                            <input id="username" type="text" class="validate" name="uid" value="'.$username.'" required>
                            <label for="username">Username</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12 offset-s3 offset-m8 offset-l12">
                            <input id="email" type="email" class="validate" name="mail" value="'.$email.'" required>
                            <label for="email">Email</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12 offset-s3 offset-m8 offset-l12">
                            <input id="password" type="password" class="validate" name="pwd" required>
                            <label for="password">Password</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12 offset-s3 offset-m8 offset-l12">
                            <input id="password-repeat" type="password" class="validate" name="pwd-repeat" required>
                            <label for="password-repeat">Password</label>
                            <br/><br/><br/>
                            <button class="btn" type="submit" name="signup-submit">SIGN UP</button>
                        </div>
                    </div>

                </form>
            </div>

        -->
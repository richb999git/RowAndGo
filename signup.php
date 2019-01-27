<?php
    require "header.php";

    // need to check if editing or adding and change the title
    // if editing need to be logged in

    if (isset($_GET["edit"])) {
        if ($_GET["edit"] == "y") {
            if (isset($_SESSION["userId"])) {
                $edit = "y";
                echo '<main>
                            <img width=100% src="pics/header2.jpg" alt="">    
                                <h4 id="SignUpTitle">EDIT ACCOUNT</h4>';
            } else {
                header("Location: index.php?error=notloggedin");
                exit();
            }
        } else {
            $edit= "n";
            echo '<main>
                        <img width=100% src="pics/header2.jpg" alt="">    
                            <h4 id="SignUpTitle">SIGN UP</h4>';
        }
    } else {
        $edit= "n";
        echo '<main>
                    <img width=100% src="pics/header2.jpg" alt="">    
                        <h4 id="SignUpTitle">SIGN UP</h4>';
    }        

    $username = "";
    if (isset($_SESSION["username"])) {
        $username = $_SESSION["username"];
    }
    if (isset($_GET["uid"])) {
        $username = $_GET["uid"];
    }

    $email = "";
    if (isset($_SESSION["userEmail"])) {
        $email = $_SESSION["userEmail"];
    }
    if (isset($_GET["mail"])) {
        $email = $_GET["mail"];
    }

    $club = "";
    if (isset($_SESSION["club"])) {
        $club = $_SESSION["club"];
    }
    if (isset($_GET["club"])) {
        $club = $_GET["club"];
    }

    $gender = "";
    if (isset($_SESSION["male"])) {
        $_SESSION["male"] == 1 ? $gender = "M" : $gender = "F";
    }
    if (isset($_GET["gender"])) {
        $gender = $_GET["gender"];
    }

    $weight = "";
    if (isset($_SESSION["weight"])) {
        $_SESSION["weight"] == 1 ? $weight = "L" : $weight = "H";
    }
    if (isset($_GET["weight"])) {
        $weight = $_GET["weight"];
    }

    $dob = "";
    if (isset($_SESSION["dob"])) {
        $dob = $_SESSION["dob"];
    }
    if (isset($_GET["dob"])) {
        $dob = $_GET["dob"];
    }
    
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyfields") {
            echo "<p class='errorSignUp'>Please fill in all fields!</p>";
        }
        else if ($_GET["error"] == "invalidmail") {
            echo "<p class='errorSignUp'>Invalid email!</p>";
        }
        else if ($_GET["error"] == "invaliddate") {
            echo "<p class='errorSignUp'>Invalid date!</p>";
        }
        else if ($_GET["error"] == "passwordcheck") {
            echo "<p class='errorSignUp'>Your passwords do not match!</p>";
        }
        else if ($_GET["error"] == "emailtaken") {
            echo "<p class='errorSignUp'>Email is already taken!</p>";
        }
    }
    else if (isset($_GET["success"])) { 
        if ($_GET["success"] == "signup") {
            echo "<p class='successSignUp'>Sign up successful!</p>";
        } else if ($_GET["success"] == "editAccount") {
            echo "<p class='successSignUp'>Account edit successful!</p>";
        } else {
            echo "<p class='errorSignUp'>Something went wrong!</p>";
        }
        
    }
    echo '
        <div class="row">
            <br/>
            <form class="col s10 m5 l4" action="includes/signup.inc.php?edit='.$edit.'" method="post">
            


                <div class="row">
                    <div class="input-field col s12 offset-s1 offset-m8 offset-l12 marginReduce20">
                        <input id="email" type="email" class="validate" name="mail" value="'.$email.'" required>
                        <label for="email"><i class="material-icons">email</i> Email</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12 offset-s1 offset-m8 offset-l12 marginReduce20">
                        <input id="username" type="text" class="validate" name="uid" value="'.$username.'" required>
                        <label for="username"><i class="material-icons">person_outline</i> Full name</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12 offset-s1 offset-m8 offset-l12 marginReduce20">
                        <input id="club" type="text" class="validate" name="club" value="'.$club.'" required>
                        <label for="club"><i class="material-icons">people</i> Club</label>
                    </div>
                </div>';

    // don't ask for passwords when editing account. User has to be logged in. Add password change option separately
    if ($edit == "n") {
        echo '
            <div class="row">
                <div class="input-field col s12 offset-s1 offset-m8 offset-l12 marginReduce20">
                    <input id="password" type="password" class="validate" name="pwd" required>
                    <label for="password"><i class="material-icons">lock_outline</i> Password</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12 offset-s1 offset-m8 offset-l12 marginReduce20">
                    <input id="password-repeat" type="password" class="validate" name="pwd-repeat" required>
                    <label for="password-repeat"><i class="material-icons">lock</i> Repeat Password</label>
                </div>
            </div>';
    } 

    echo '
            <div class="row">
                <div class="input-field col s12 offset-s1 offset-m8 offset-l12 marginReduce20">
                    <input id="dob" type="text" class="datepicker" name="dob" value="'.$dob.'" required>
                    <label for="dob"><i class="material-icons">date_range</i> Date of birth</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12 offset-s1 offset-m8 offset-l12 marginReduce20">
                    <p>
                    <label>';

    // don't allow gender change when editing account. User may have added scores already   
    $edit == "y" ? $genderDisableString = "disabled" :  $genderDisableString = "";
    if ( $gender != "F" ) {
    echo '
                            <input name="gender" type="radio" value="M" checked '.$genderDisableString.'/>
                            <span>Male</span>
                        </label>

                        <label>
                            <input name="gender" type="radio" value="F" '.$genderDisableString.'/>';

    } else {
        echo '
                            <input name="gender" type="radio" value="M" '.$genderDisableString.'/>
                            <span>Male</span>
                        </label>

                        <label>
                            <input name="gender" type="radio" value="F" checked '.$genderDisableString.'/>';                
    }

    echo '                        
                            <span>Female</span>
                        </label>
                        </p>
                        <p class="tooltipped" data-position="top" data-tooltip="Junior weight N/A so will be ignored">
                        <label>';
    
    if ( $weight != "L" ) {
        echo '
                            <input name="weight" type="radio" value="H" checked />
                            <span>Heavyweight</span>
                        </label>

                        <label>
                            <input name="weight" type="radio" value="L" />';
    } else {
        echo '
                            <input name="weight" type="radio" value="H" />
                            <span>Heavyweight</span>
                        </label>

                        <label>
                            <input name="weight" type="radio" value="L" checked />';
    }

    echo '
                            <span>Lightweight</span>
                        </label>
                        </p>
                    </div>
                </div>';

    // need to check if editing or adding and change form button accordingly
    if ($edit == "y") {
        echo '
                <div class="row">
                    <div class="input-field col s12 offset-s1 offset-m8 offset-l12 marginReduce20">
                        <button class="btn btn100" type="submit" name="signup-submit">EDIT</button>
                    </div>
                </div>';
    } else {
        echo '
                <div class="row">
                    <div class="input-field col s12 offset-s1 offset-m8 offset-l12 marginReduce20">
                        <button class="btn btn100" type="submit" name="signup-submit">SIGN UP</button>
                    </div>
                </div>';
    }

    echo   '</form>
        </div>
        <br>
        ';
?>

</main>

<?php
    require "footer.php";
?>

<?php
    require "header.php";
?>

    <main>
    <img width=100% src="pics/header2.jpg" alt="rowing 8 header">
    <?php

        $distOrTime = "";
        // test if coming from prior screen or returning with error. If not then access not allowed to page
        if (isset($_POST["distOrTime"]) || isset($_GET["error"])) { 

            if (isset($_POST["distOrTime"])) {
                $distOrTime = $_POST["distOrTime"]; // will be "distance" or "time"
            }
            if (isset($_GET["distOrTime"])) {
                $distOrTime = $_GET["distOrTime"]; // if page returned because of error
            }
            $timeMin = "";
            if (isset($_GET["scoreMinutes"])) {
                $timeMin = $_GET["scoreMinutes"]; // if page returned because of error
            }
            $timeSec = "";
            if (isset($_GET["scoreSeconds"])) {
                $timeSec = $_GET["scoreSeconds"]; // if page returned because of error
            }
            $scoreDistance = "";
            if (isset($_GET["scoreDistance"])) {
                $scoreDistance = $_GET["scoreDistance"]; // if page returned because of error
            }
            $event1 = "";
            if (isset($_GET["event1"])) {
                $event1 = $_GET["event1"]; // if page returned because of error
            }
            $rate = 0;
            if (isset($_GET["rate"])) {
                $rate = $_GET["rate"]; // if page returned because of error
            }
            $dynamic = "";
            if (isset($_GET["dynamic"])) {
                $dynamic = $_GET["dynamic"]; // if page returned because of error
            }
            $weight = "";
            if (isset($_GET["weight"])) {
                $weight = $_GET["weight"]; // if page returned because of error
            }

            echo '<h4 id="SignUpTitle">Add Erg Score - '.$distOrTime.'</h4>';

            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyfields") {
                    echo "<p class='errorSignUp'>Fill in all fields!</p>";
                } else if ($_GET["error"] == "invaliddate") {
                    echo "<p class='errorSignUp'>Invalid future date!</p>";
                }
            }
            
            echo ' 
                <div class="row">
                        <br/>
                        <form class="col s10 m6 l4" action="includes/addScore.inc.php" method="post">

                            <div class="row">
                                <div class="input-field col s12 offset-s1 offset-m6 offset-l12 marginReduce20">
                                    <input id="ergDate" type="text" class="datepicker" name="ergDate" required>
                                    <label for="ergDate">Date of Erg score</label>
                                </div>
                            </div>';

            if ($distOrTime == "distance") {
                echo '
                            <div class="row">
                                <div class="input-field col s12 offset-s1 offset-m6 offset-l12 marginReduce20">
                                    <select name="event1" required>';
                                    
            if ($event1 != "") {
                            echo '<option value="'.$event1.'">'.$event1.'</option>';
            } else {
                            echo '<option value="" disable selected>Select distance...</option>';
            }            
                                    
            echo '                            
                                    <option value="100m">100m</option>
                                    <option value="250m">250m</option>
                                    <option value="500m">500m</option>
                                    <option value="1000m">1000m</option>
                                    <option value="1500m">1500m</option>
                                    <option value="2000m">2000m</option>
                                    <option value="2500m">2500m</option>
                                    <option value="3000m">3000m</option>
                                    <option value="4000m">4000m</option>
                                    <option value="5000m">5000m</option>
                                    <option value="6000m">6000m</option>
                                    <option value="10000m">10000m</option>
                                    <option value="12000m">12000m</option>
                                    <option value="15000m">15000m</option>
                                    <option value="20000m">200m0m</option>
                                    <option value="21097m">21097m</option>
                                    <option value="42195m">42195m</option>
                                </select>
                                <label>Distance</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12 offset-s1 offset-m6 offset-l12 marginReduce20">
                                <div class="input-field col s6">
                                    <input id="timeMin" type="number" class="validate" name="timeMin" value='.$timeMin.' min=0 required />
                                    <label for="timeMin">Score - minutes</label>
                                </div>
                                <div class="input-field col s6">
                                    <input id="timeSec" type="number" class="validate" name="timeSec" step=0.1 min=0 max=59.9 required value='.$timeSec.' />
                                    <label for="timeSec">Score - seconds</label>
                                </div>
                            </div>
                        </div>
                ';    
            } else {
                echo '
                            <div class="row">
                                <div class="input-field col s12 offset-s1 offset-m6 offset-l12 marginReduce20">
                                    <select name="event1" required>';  

                if ($event1 != "") {
                                echo '<option value="'.$event1.'">'.$event1.'</option>';
                } else {
                                echo '<option value="" disabled selected>Select...</option>';
                }
                echo '                          
                                        <option value="1min">1min</option>
                                        <option value="2mins">2mins</option>
                                        <option value="3mins">3mins</option>
                                        <option value="4mins">4mins</option>
                                        <option value="5mins">5mins</option>
                                        <option value="6mins">6mins</option>
                                        <option value="8mins">7mins</option>
                                        <option value="10mins">10mins</option>
                                        <option value="12mins">12mins</option>
                                        <option value="15mins">15mins</option>
                                        <option value="20mins">20mins</option>
                                        <option value="25mins">25mins</option>
                                        <option value="30mins">30mins</option>
                                        <option value="40mins">40mins</option>
                                        <option value="45mins">45mins</option>
                                        <option value="50mins">50mins</option>
                                        <option value="60mins">60mins</option>
                                        <option value="90mins">90mins</option>
                                        <option value="120mins">120mins</option>
                                    </select>
                                    <label>Time</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12 offset-s1 offset-m6 offset-l12 marginReduce20">
                                    <input id="distance" type="number" class="validate" name="distance" value="'.$scoreDistance.'" required>
                                    <label for="distance">Score in metres</label>
                                </div>
                            </div>
                ';
            }           

            echo '
                            <div class="row">    
                                <div class="input-field col s12 offset-s1 offset-m6 offset-l12 marginReduce40">
                                    <select name="rate" required>';
                                    
            if ($rate != "" && $rate != "Free rate") {
                                echo '<option value="'.$rate.'">'.$rate.' spm</option>';
            } else {
                                echo '<option value="Free rate">Free rate</option>';
            }
            echo '
                                    <option value="16">16 spm</option>
                                    <option value="17">17 spm</option>
                                    <option value="18">18 spm</option>
                                    <option value="19">19 spm</option>
                                    <option value="20">20 spm</option>
                                    <option value="21">21 spm</option>
                                    <option value="22">22 spm</option>
                                    <option value="23">23 spm</option>
                                    <option value="24">24 spm</option>
                                    <option value="25">25 spm</option>
                                    <option value="26">26 spm</option>
                                    <option value="27">27 spm</option>
                                    <option value="28">28 spm</option>
                                    <option value="29">29 spm</option>
                                    <option value="30">30 spm</option>
                                    <option value="31">31 spm</option>
                                    <option value="32">32 spm</option>
                                </select>
                                <label>Free rate or capped?</label>
                            </div>
                        </div>
                        
                        <div class="row">
                        <div class="input-field col s12 offset-s1 offset-m6 offset-l12 marginReduce40">
                            <p>
                            <label>';
            
            if ( $dynamic != "Dynamic" ) {
                echo '
                                        <input name="dynamic" class="with-gap" type="radio" value="Standard" checked/>
                                        <span>Standard Erg</span>
                                    </label>
        
                                    <label>
                                        <input name="dynamic" class="with-gap" type="radio" value="Dynamic" />
                                        <span>Dynamic Erg</span>
                                    </label>';
        
                } else {
                    echo '
                                        <input name="dynamic" class="with-gap" type="radio" value="Standard"/>
                                        <span>Standard Erg</span>
                                    </label>
        
                                    <label>
                                        <input name="dynamic" class="with-gap" type="radio" value="Dynamic" checked />
                                        <span>Dynamic Erg</span>
                                    </label>';                
                }
            echo '
                        
                            </p>
                        </div>
                        </div>

                        <div class="row">
                        <div class="input-field col s12 offset-s1 offset-m6 offset-l12 marginReduce20">
                            <p>
                            <label>';
            
            if ( $weight != "Light" ) {
                echo '
                                        <input name="weight" class="with-gap" type="radio" value="Heavy" checked/>
                                        <span>Heavy weight</span>
                                    </label>
        
                                    <label>
                                        <input name="weight" class="with-gap" type="radio" value="Light" />
                                        <span>Light weight</span>
                                    </label>';
        
                } else {
                    echo '
                                        <input name="weight" class="with-gap" type="radio" value="Heavy"/>
                                        <span>Heavy weight</span>
                                    </label>
        
                                    <label>
                                        <input name="weight" class="with-gap" type="radio" value="Light" checked />
                                        <span>Light weight</span>
                                    </label>';                
                }
            echo '
                        
                            </p>
                        </div>
                        </div>


                            <div class="row">
                                <div class="input-field col s12 offset-s1 offset-m6 offset-l12 marginReduce20">
                                    <button class="btn btn100" type="submit" name="log-submit">LOG SCORE</button>
                                </div>
                            </div>

                    </form>
            </div>
            ';
        
        } else {
            header("Location: index.php?error=nodirectaccess");
            exit(); 
        }

    ?>

    </main>

<?php
    require "footer.php";
?>

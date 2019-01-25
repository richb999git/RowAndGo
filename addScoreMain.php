<?php
    require "header.php";
?>

    <main>
    <img width=100% src="pics/header2.jpg" alt="rowing 8 header">
    <?php

        $distOrTime = "";
        // test if coming from prior screen or returning with error. If not then access not allowed to page
        if (isset($_POST["distOrTime"]) || isset($_GET["error"]) || isset($_GET["edit"])) { 

            if (isset($_POST["distOrTime"])) {
                $distOrTime = $_POST["distOrTime"]; // will be "distance" or "time"
            }
            if (isset($_GET["distOrTime"])) {
                $distOrTime = $_GET["distOrTime"]; // if page returned because of error/edit
            }
            $timeMin = "";
            if (isset($_GET["scoreMinutes"])) {
                $timeMin = $_GET["scoreMinutes"]; // if page returned because of error/edit
            }
            $timeSec = "";
            if (isset($_GET["scoreSeconds"])) {
                $timeSec = $_GET["scoreSeconds"]; // if page returned because of error/edit
            }
            $scoreDistance = "";
            if (isset($_GET["scoreDistance"])) {
                $scoreDistance = $_GET["scoreDistance"]; // if page returned because of error/edit
            }
            $event1 = "";
            if (isset($_GET["event1"])) {
                $event1 = $_GET["event1"]; // if page returned because of error/edit
            }
            $rate = 0;
            if (isset($_GET["rate"])) {
                $rate = $_GET["rate"]; // if page returned because of error/edit
            }
            $dynamic = "";
            if (isset($_GET["dynamic"])) {
                $dynamic = $_GET["dynamic"]; // if page returned because of error/edit
            }
            $_SESSION["weight"] == 1 ? $weight = "Light" : $weight = "Heavy" ; // default to user's weight on their account
            if (isset($_GET["weight"])) {
                $weight = $_GET["weight"]; // if page returned because of error/edit
            }
            $ergDate = date("Y-m-d"); // today as default 
            if (isset($_GET["date"])) {
                $ergDate = $_GET["date"]; // if page returned because of error/edit
            }
            $ergDate = date('d-M-Y', strtotime($ergDate)); // put in easier to read format on form

            if (isset($_GET["edit"])) {
                $titleType = "Edit";
                $edit = "y";
            } else {
                $titleType = "Add";
                $edit = "n";
            }

            $ageCat = "";
            if (isset($_GET["ageCat"])) {
                $ageCat = $_GET["ageCat"];
            } else {
                // work out age category based on DOB
                // U23 19-22, SEN 23-26 (and above), a 27-35, b 36-42, c 43-49, d 50-54, e 55-59, f 60-64, g 65-69, h 70-74, i 75-79, j 80-
                // on or before 31st December
                // Junior categories based on academic year, i.e. From Sep 1st to Aug 31st e.g if you turn 16 in that period you are J16
                $year = date("Y", strtotime(date("Y-m-d")));
                $endOfYear = $year."-12-31"; // calendar year end for non juniors
                $dobYear = date("Y", strtotime(date("Y-m-d", strtotime($_SESSION["dob"]))));
                $NonJuniorAge = $year - $dobYear;
                $currentMonth = date("m", strtotime(date("Y-m-d")));
                if ($currentMonth > 8) { $year++; } // use with acedemic year
                $endOfYearJuniors = $year."-08-31";  // acedemic year end
                $juniorAge = strtotime($endOfYearJuniors) - strtotime($_SESSION["dob"]);  // in seconds. 365.25 for leap years
                $juniorAge = floor($juniorAge / (60*60*24*365.25)); // in years
                $juniorAge <= 18 ? $NonJuniorAge = 0 : $juniorAge = 0;
                $ages = array(79, 74, 69, 64, 59, 54, 49, 42, 35, 26, 22, 18, 17, 16, 15, 14, 13, 12, 11, 1);
                $ageCats = array("VTJ", "VTI", "VTH", "VTG", "VTF", "VTE", "VTD", "VTC", "VTB", "VTA", "SEN", "U23", "J18", "J17", "J16", "J15", "J14", "J13", "J12", "J11" );
                $i = 0;
                while ($ageCat == "") {
                    if ($NonJuniorAge > $ages[$i]) { // 79 first
                        $NonJuniorAge == 18 ? $ageCat = "U23" : $ageCat = $ageCats[$i];
                    } else if ($juniorAge > $ages[$i]) { 
                        $ageCat = $ageCats[$i];
                    }
                    $i++;
                }
            }


            $scoreID = "";
            if (isset($_GET["scoreID"])) {
                $scoreID = $_GET["scoreID"];
            }

            echo '<h4 id="SignUpTitle">'.$titleType.' Erg Score - '.$distOrTime.'</h4>';

            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyfields") {
                    echo "<p class='errorSignUp'>Please fill in all fields!</p>";
                } else if ($_GET["error"] == "invaliddate") {
                    echo "<p class='errorSignUp'>Invalid future date!</p>";
                }
            }

            echo ' 
                <div class="row">
                        <br/>
                        <form class="col s10 m6 l4 " action="includes/addScore.inc.php?edit='.$edit.'&scoreID='.$scoreID.'" method="post">

                            <div class="row">
                                <div class="input-field col s12 offset-s1 offset-m6 offset-l12 marginReduce20">
                                    <input id="ergDate" type="text" class="datepicker" name="ergDate" value="'.$ergDate.'" required>
                                    <label for="ergDate">Date of Erg score</label>
                                </div>
                            </div>';

            if ($distOrTime == "distance") {
                echo '
                            <div class="row">
                                <div class="input-field col s12 offset-s1 offset-m6 offset-l12 marginReduce40">
                                    <select name="event1">';  // can't use required because it is effectively selected automatically with "Select..."
                                    
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
                                    <option value="20000m">20000m</option>
                                    <option value="21097m">21097m</option>
                                    <option value="42195m">42195m</option>
                                </select>
                                <label>Distance</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12 offset-s1 offset-m6 offset-l12 marginReduce40">
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
                                    <select name="event1">';  // can't use required because it is effectively selected automatically with "Select..."

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
                                <div class="input-field col s12 offset-s1 offset-m6 offset-l12 marginReduce40">
                                    <input id="distance" type="number" class="validate" name="distance" value="'.$scoreDistance.'" required>
                                    <label for="distance">Score in metres</label>
                                </div>
                            </div>
                ';
            }           

            echo '
                            <div class="row">    
                                <div class="input-field col s12 offset-s1 offset-m6 offset-l12 marginReduce40">
                                    <div class="input-field col s6">
                                        <select name="rate" required>';
                                    
            if ($rate != "" && $rate != "Free rate" && $rate !=0) {
                                echo '      <option value="'.$rate.'">'.$rate.' spm</option>
                                            <option value="Free rate">Free rate</option>';
            } else {
                                echo '      <option value="Free rate">Free rate</option>';
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
                                    
                                    <div class="input-field col s6">
                                        <select name="ageCat" required>'; 
            
            if ($ageCat != "") {
                                $ageCatD = $ageCat;
                                if (substr($ageCat, 0, 1) == "V") {
                                    $ageCatD = "Masters ".substr($ageCat,-1);
                                }  
                                echo '      <option value="'.$ageCat.'">'.$ageCatD.'</option>
                                            <option value="SEN">SEN</option>';
            } else {
                                echo '      <option value="SEN">SEN</option>';
            }
            echo '      
                                            <option value="U23">U23</option>
                                            <option value="VTA">Masters A</option>
                                            <option value="VTB">Masters B</option>
                                            <option value="VTC">Masters C</option>
                                            <option value="VTD">Masters D</option>
                                            <option value="VTE">Masters E</option>
                                            <option value="VTF">Masters F</option>
                                            <option value="VTG">Masters G</option>
                                            <option value="VTH">Masters H</option>
                                            <option value="VTI">Masters I</option>
                                            <option value="VTJ">Masters J</option>
                                            <option value="J18">J18</option>
                                            <option value="J17">J17</option>
                                            <option value="J16">J16</option>
                                            <option value="J15">J15</option>
                                            <option value="J14">J14</option>
                                            <option value="J13">J13</option>
                                            <option value="J12">J12</option>
                                            <option value="J11">J11</option>                                            
                                        </select>
                                        <label>Age Category</label>
                                    </div>

                                </div>
                            </div>     

            ';

            echo '      <div class="row">
                        <div class="input-field col s12 offset-s0 offset-m5 offset-l11 marginReduce40">
                        <div class="col offset-s1">
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
                        </div>

                        <div class="row">
                        <div class="input-field col s12 offset-s0 offset-m5 offset-l11 marginReduce20">
                        <div class="col offset-s1">
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
                        </div>

                        <div class="row">
                            <div class="input-field col s12 offset-s1 offset-m6 offset-l12 marginReduce20">';
            
            if ($edit == "n") {
                echo '
                                <div class="input-field col s6">
                                    <button class="btn btn100" type="submit" name="log-submit">LOG SCORE</button>
                                </div>
                                <div class="input-field col s6">
                                    <a href="javascript:history.go(-1)" class="btn btn100" type="button" name="log-cancel">CANCEL</a>
                                </div>';
            } else {
                echo '
                                <div class="input-field col s4">
                                    <button class="btn btn100" type="submit" name="log-submit">UPDATE</button>
                                </div>
                                <div class="input-field col s4">
                                    <button class="btn btn100" type="submit" name="log-submit" value="log-delete">DELETE</button>
                                </div>
                                <div class="input-field col s4">
                                    <a href="javascript:history.go(-1)" class="btn btn100" type="text" name="log-cancel">CANCEL</a>
                                </div>';
            }

            echo '
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

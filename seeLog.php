<?php
    require "header.php";
?>

<?php
    if (isset($_SESSION["userId"])) {

    echo '
        <main>
        <!-- show a section of buttons for various reports?
        just use as a testing file for now -->
            <h4>Calendar View</h4>

            <table style="min-width: 750px" class="striped" >
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Event</th>
                        <th>Time/Dist</th>
                        <th>/500m</th>
                        <th>Name</th>
                        <th>Club</th>
                        <th>Gender</th>
                        <th>Weight</th>
                        <th>Age Cat</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>9/12/18</td>
                        <td>2000m R24</td>
                        <td>07:14.0</td>
                        <td>1:48.5</td>
                        <td class="tdWidth">John Gibbers ddddddddddddddddddddddddddddddddddddddddddddddd</td>
                        <td class="tdWidth">London Jokers jjjjjjjjjjjjjjjjjjjj kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkrrrrrrrrrrrrrrrrrrrkkkkkkkk</td>
                        <td>Male</td>
                        <td>Heavy</td>
                        <td>Senior</td>
                    </tr>
                    <tr>
                        <td>29/12/18</td>
                        <td>120 minutes R20</td>
                        <td>28000</td>
                        <td>2:02.8</td>
                        <td class="tdWidth">Richard Braunton gggggggggggggggggggggggggggggggggggggggggggggg</td>
                        <td class="tdWidth">Greenbank Falmouth ffffff hhhh eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee</td>
                        <td>Male</td>
                        <td>Light</td>
                        <td>D</td>
                    </tr>
                    <tr>
                        <td>29/12/18</td>
                        <td>120 minutes R20</td>
                        <td>28000</td>
                        <td>2:02.8</td>
                        <td>Richard Braunton</td>
                        <td>Greenbank Falmouth</td>
                        <td>Male</td>
                        <td>Light</td>
                        <td>D</td>
                    </tr>
                    <tr>
                        <td>2/12/18</td>
                        <td>2000m</td>
                        <td>06:52.0</td>
                        <td>1:43.0</td>
                        <td>John Gibbers</td>
                        <td>London Jokers</td>
                        <td>Male</td>
                        <td>Heavy</td>
                        <td>Senior</td>
                    </tr>
                    <tr>
                        <td>29/12/18</td>
                        <td>120 minutes R20</td>
                        <td>28000</td>
                        <td>2:02.8</td>
                        <td>Richard Braunton</td>
                        <td>Greenbank Falmouth</td>
                        <td>Male</td>
                        <td>Light</td>
                        <td>D</td>
                    </tr>
                    <tr>
                        <td>29/12/18</td>
                        <td>120 minutes R20</td>
                        <td>28000</td>
                        <td>2:02.8</td>
                        <td>Richard Braunton</td>
                        <td>Greenbank Falmouth</td>
                        <td>Male</td>
                        <td>Light</td>
                        <td>D</td>
                    </tr>
                    <tr>
                        <td>29/12/18</td>
                        <td>20 minutes R20</td>
                        <td>2000</td>
                        <td>8:02.8</td>
                        <td>Billy Whizz</td>
                        <td>Greenbank Falmouth</td>
                        <td>Male</td>
                        <td>N/A</td>
                        <td>J15</td>
                    </tr>
                    <tr>
                        <td>29/12/18</td>
                        <td>120 minutes R20</td>
                        <td>28000</td>
                        <td>2:02.8</td>
                        <td>Richard Braunton</td>
                        <td>Greenbank Falmouth</td>
                        <td>Male</td>
                        <td>Light</td>
                        <td>D</td>
                    </tr>
                </tbody>
            </table>

            

            

        </main>
    ';

    } else {
        header("Location: index.php?error=notloggedin");
        exit(); 
    }
?>

<?php
    require "footer.php";
?>
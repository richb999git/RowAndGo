<?php
    require "header.php";
?>

    <main>
        
        <div class="center-align">

<?php
    
    switch (rand(1,5) )
    {
        case 1:
        echo '<img width=100% src="pics/e.jpg" alt="woman on erg">';
        break;
        case 2:
        echo '<img width=100% src="pics/f.jpg" alt="roomfull of rowers on ergs rowing together">';
        break;
        case 3:
        echo '<img width=100% src="pics/g.jpg" alt="woman on erg">';
        break;
        case 4:
        echo '<img width=100% src="pics/h.jpg" alt="woman on erg (behind)">';
        break;
        case 5:
        echo '<br/><img id="super4" src="pics/super4.png" alt="super heroes on rowing machines (joke)">';
        break;
        default;
        echo '<img width=100% src="pics/h.jpg" alt="woman on erg (behind)">';
    }      
?>   
            <br/>
            <h4>Enter your erg scores and compare with other rowers!</h4>
            <br/>
            <div><img width=95% id="screenshot" src="pics/row&go_example.png" alt="example screen shot of Row&Go!"></div>
            <br/>
            <p>If you have any problems please email me at <a href="mailto:richb999@tiscali.co.uk">richb999@tiscali.co.uk</a></p>
            <br/>
        </div>
        
    </main>

<?php
    require "footer.php";

<?php
    require "header.php";
?>

    <main>

        
        <div class="center-align">

<?php
    
    switch (rand(1,5) )
    {
        case 1:
        echo '<img width=100% src="pics/e.jpg" alt="">';
        break;
        case 2:
        echo '<img width=100% src="pics/f.jpg" alt="">';
        break;
        case 3:
        echo '<img width=100% src="pics/g.jpg" alt="">';
        break;
        case 4:
        echo '<img width=100% src="pics/h.jpg" alt="">';
        break;
        case 5:
        echo '<br/><img id="super4" src="pics/super4.png" alt="">';
        break;
        default;
        echo '<img width=100% src="pics/h.jpg" alt="">';
    }      
?>   

            <br/>
            <h4>Enter your training scores and compare with other rowers!</h4>
            <br/>
            <div><img width=95% id="screenshot" src="pics/screen5.png" alt=""></div>
            <br/>
            <p>If you have any problems please email me at <a href="mailto:richb999@tiscali.co.uk">richb999@tiscali.co.uk</a></p>
            <br/>
        </div>
        

    </main>


<?php
    require "footer.php";
?>
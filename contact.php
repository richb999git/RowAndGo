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
            <h4>Enter your training scores and compare to other rowers!</h4>
            <br>
            <p>If you have any problems please email me at richb999@tiscali.co.uk</p>
            <br/>
        </div>
        

    </main>


<?php
    require "footer.php";
?>
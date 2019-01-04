<?php
    require "header.php";
?>

<?php
    if (isset($_SESSION["userId"])) {

    echo '
        <main>
            
            

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
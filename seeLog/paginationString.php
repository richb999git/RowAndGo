<?php
// no direct access allowed
if (isset($linesPerPage)) {
    ////////////////////////////////////////////////    PAGINATION CONTROLS STRING CREATION  //////////////////////////

    //////////////////////////////////////////////////////////  spinner
    require "seeLog/sqlSpinner.php";

    // Very complicated to use prepared statements. SQL statements are complicated and change.
    // User input is from drop down so SQL injection risk is small. All input is checked or cleaned.
    // Would have to have ? for all WHERE and HAVING options and the weight and age categories have dynamic code
    // Therefore I would probably need to have more than one statement to deal with weight and age variation combinations
    // $result = mysqli_query($conn, $sql);
    
    if (mysqli_query($conn, $sql)) {
        $result = mysqli_query($conn, $sql);  
    } else {
        //echo "Error deleting record: " . mysqli_error($conn);
        mysqli_close($conn);
        header("Location: index.php?error=REPORT_ERROR");
        exit(); 
    }
    
    $noOfLines = mysqli_num_rows($result);

    $maxPagesEitherSide = 3; // 3 is max to comfortable fit on mobile screen (3 + selection + 3 = 7 numbers in pagination control) when numbers get large
    $page = 1;
    if(isset($_GET["page"])) {
        $page = $_GET["page"];
        if( !ctype_digit($page) ) { // check to ensure only a number is created, i.e. no injection
            $page = 1;
        }
    }
    $lastPage = ceil($noOfLines / $linesPerPage); // rounds up
    $lastPage < 1 ? $lastPage = 1: $lastPage = $lastPage;
    if($page < 1) {
        $page = 1;
    } else if ($page > $lastPage) {
        $page = $lastPage;
    }
    $limit = " LIMIT ". ($page -1) * $linesPerPage.",".$linesPerPage; // from x, and linesPerPage
    $sql .= $limit;
    $result = mysqli_query($conn, $sql);
    $scoresNum = "Scores: $noOfLines";
    $pageNum = "Page $page of $lastPage";
    $pageControls = "";
    $qstring = '&sortType='.$sortType.'&sortDir='.$sortDir.'&male='.$male.'&weight='.$weight.'&eventType='.$eventType.'&dynamic='.$dynamic.'&event2='.$event2.'&ageCat='.$ageCat; // use this to pass query string data from sorts and filters
    $qstring .= '&whichErgs='.$whichErgs.'&reportType='.$reportType.'&linesPerPage='.$linesPerPage;

    if ($lastPage != 1) { // if more than one page render controls else nothing to render
        // show previous pages on control
        if ($page == 1) {
            $pageControls .= '<li class="disabled"><a href="#"><i class="material-icons">chevron_left</i></a></li>';
        } else {
            $prev = $page - 1;
            $pageControls .= '<li class="waves-effect"><a href="'.$_SERVER["PHP_SELF"].'?page='.$prev.$qstring.'"><i class="material-icons">chevron_left</i></a></li>';
            for ($i=$page-$maxPagesEitherSide; $i<$page; $i++) {
                if ($i > 0) {
                    $pageControls .= '<li class="waves-effect"><a href="'.$_SERVER["PHP_SELF"].'?page='.$i.$qstring.'">'.$i.'</a></li>';
                }
            }
        }
        // show target page number with link on control
        $pageControls .= '<li class="active"><a href="'.$_SERVER["PHP_SELF"].'?page='.$page.$qstring.'">'.$page.'</a></li>';
        // show next pages on control
        for ($i=$page+1; $i<=$lastPage; $i++) {
            $pageControls .= '<li class="waves-effect"><a href="'.$_SERVER["PHP_SELF"].'?page='.$i.$qstring.'">'.$i.'</a></li>';
            if ($i >= $page + $maxPagesEitherSide) {
                break;
            }
        }
        if ($page != $lastPage) {
            $nextPage = $page + 1;
            $pageControls .= '<li class="waves-effect"><a href="'.$_SERVER["PHP_SELF"].'?page='.$nextPage.$qstring.'"><i class="material-icons">chevron_right</i></a></li>';
        } else {
            $pageControls .= '<li class="disabled"><a href="#"><i class="material-icons">chevron_right</i></a></li>';
        }
    } 



} else {
    header("Location: ../index.php?error=nodirectaccess");
    exit(); 
}    

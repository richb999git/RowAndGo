<?php

///////////////    PAGINATION CONTROLS STRING CREATION  //////////////////////////

$result = mysqli_query($conn, $sql);  // <<<<<<< Need to use prepared statements? Is sql injection a risk? No user text can be entered.
////////////////////////////////////////////// check for error and handle  <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
$noOfLines = mysqli_num_rows($result);

$linesPerPage = 15;
$page = 1;
if(isset($_GET["page"])) {
    $page = $_GET["page"];
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
$qstring = '&sortType='.$sortType.'&sortDir='.$sortDir.'&male='.$male.'&weight='.$weight.'&eventType='.$eventType.'&dynamic='.$dynamic; // use this to pass query string data from sorts and filters
$qstring .= '&whichErgs='.$whichErgs.'&reportType='.$reportType;

if ($lastPage != 1) { // if more than one page render controls else nothing to render
    // show previous pages on control
    if ($page == 1) {
        $pageControls .= '<li class="disabled"><a href="#"><i class="material-icons">chevron_left</i></a></li>';
    } else {
        $prev = $page - 1;
        $pageControls .= '<li class="waves-effect"><a href="'.$_SERVER["PHP_SELF"].'?page='.$prev.$qstring.'"><i class="material-icons">chevron_left</i></a></li>';
        for ($i=$page-8; $i<$page; $i++) {
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
        if ($i >= $page + 8) {
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

?>
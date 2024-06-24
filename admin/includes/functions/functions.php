<?php
//###########################################################################################################
function getTitle(){
    global $pageTitle;
    if(isset($pageTitle)){
        echo $pageTitle;
    }else{
        echo "Default";
    };
}


//###########################################################################################################


// redirect v1.0
function redirect($errorMsg,$seconds=3){
    echo "<script>
    var timer = setInterval(function () {
    
        var count = parseInt($('.timer').html());
        if (count != 0) {
            $('.timer').html(count - 1);
        } else {
            clearInterval(timer);
        }
    }, 1000);</script>";
    echo '<div class = "alert alert-danger text-center">' . $errorMsg . '</div>';
    echo '<div class = "alert alert-info text-center">' . "you will be directed to home page in " . "<div class='timer' style='display: inline-block;'>" . $seconds ."</div>" . " " . "Seconds" ;
    header("refresh:$seconds;url=index.php");


}


//redirect v3.0

function redirectHome($theMsg, $url = null, $seconds = 3) {

    if ($url === null) {

        $url = 'index.php';

        $link = 'Homepage';

    } else {

        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

            $url = $_SERVER['HTTP_REFERER'];

            $link = 'Previous Page';

        } else {

            $url = 'index.php';

            $link = 'Homepage';

        }

    }
    echo "<script>
    var timer = setInterval(function () {
    
        var count = parseInt($('.timer').html());
        if (count != 0) {
            $('.timer').html(count - 1);
        } else {
            clearInterval(timer);
        }
    }, 1000);</script>";

    echo  $theMsg ;
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo '<div class = "alert alert-info text-center">' . "you will be directed to $link in " . "<div class='timer' style='display: inline-block;'>" . $seconds ."</div>" . " " . "Seconds" . "</div>" ;

    // echo "<div class='alert alert-info'>You Will Be Redirected to $link After $seconds Seconds.</div>";

    header("refresh:$seconds;url=$url");
    echo '
     
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="<?php echo $js; ?>bootstrap.bundle.js"></script>
    <script src="https://kit.fontawesome.com/de4baf0b3f.js" crossorigin="anonymous"></script>
    <script src="layout/js/backend.js"></script>
   </body>
</html> ';
    
    

    exit();

}


//###########################################################################################################


//check item exists in database or not 

function checkItem($select, $from, $value) {

    global $conn;

    $statement = $conn->prepare("SELECT $select FROM $from WHERE $select = ?");

    $statement->execute(array($value));

    $count = $statement->rowCount();

    return $count;

}



//###########################################################################################################


// number of rows

//v1.0

// function number_of_rows($column_name,$table){
//     global $conn;
//     $sql = "SELECT COUNT($column_name) FROM $table";
//     $stmt2 = $conn->prepare($sql);
//     $stmt2->execute();
//     $count = $stmt2->fetchColumn();
//     return $count;
// }


//v2.0
function number_of_rows($column_name,$table,$where=""){
    global $conn;
    if($where == ""){
        $sql = "SELECT COUNT($column_name) FROM $table";
    }else{
        $sql = "SELECT COUNT($column_name) FROM $table WHERE $where";
    }
    $stmt2 = $conn->prepare($sql);
    $stmt2->execute();
    $count = $stmt2->fetchColumn();
    return $count;
}


//###########################################################################################################

//get latest 


function getLatestusers($select, $table, $order, $limit = 5) {
    global $conn;

    $getStmt = $conn->prepare("SELECT $select FROM $table WHERE RegStatus=1 AND GroupID!=1 ORDER BY $order DESC LIMIT $limit ");

    $getStmt->execute();

    $rows = $getStmt->fetchAll();

    return $rows;

}

function getLatestitems($select, $table, $order, $limit = 5) {
    global $conn;

    $getStmt = $conn->prepare("SELECT $select FROM $table WHERE RegStatus=1 ORDER BY $order DESC LIMIT $limit ");

    $getStmt->execute();

    $rows = $getStmt->fetchAll();

    return $rows;

}






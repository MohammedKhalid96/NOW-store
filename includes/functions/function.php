<?php

/*
** get All function v1.0
** function to get All Records from database 
*/


function getAllfrom($tableName, $orderBy, $where = NULL){
    global $con;
    $sql = $where == NULL ? '' : $where;
    $getAll = $con->prepare("SELECT * FROM $tableName $sql ORDER BY $orderBy DESC");
    $getAll->execute();
    $all = $getAll->fetchAll();
    return $all;
}



/*
** get records function v1.0
** function to get categories from database 
*/

function getCat(){
    global $con;
    $getCat = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");
    $getCat->execute();
    $cat = $getCat->fetchAll();
    return $cat;
}

/*
** get Items function v2.0
** function to get Items from database 
*/

function getItem($where, $value, $approve = NULL){
    global $con;
    
    $sql = $approve == NULL ? 'AND Approve = 1' : '';
    
    $getItem = $con->prepare("SELECT * FROM items WHERE $where = ? $sql ORDER BY Item_ID DESC");
    $getItem->execute(array($value));
    $item = $getItem->fetchAll();
    return $item;
}

/*
** Check if user is not activated v1.0
** function to check the regstatus of the user 
*/
function checkUserStatus($user){
     global $con;
     $stmtx = $con->prepare("SELECT 
                                UserName, RegStatus 
                          FROM 
                                users 
                          WHERE 
                                UserName  = ? 
                          AND 
                                RegStatus = 0 
                          ");
    
    
    $stmtx->execute(array($user));
    $status = $stmtx->rowCount();
    return $status;
}
    
//getTitle v1.0

function getTitle()
{
    global $pageTitle;
    if(isset($pageTitle)) 
    {
        echo $pageTitle;
    }
    
    else 
    
    {
        echo 'Default';
    }
}

/*
** redirectHome V2.0
** Redirect Function [ This Function accept parameters ]
** $theMsg = Echo the Message
** $url = the link yow want to redirect to
** $seconds = seconds before redirecting 
*/
      
function redirectHome($theMsg, $url = null, $seconds = 3){
    
    if($url === null)
    {
        $url = 'dashboard.php';
        
    } 
    
       else
    {
        $url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $_SERVER['HTTP_REFERER'] : 'dashboard.php';
    }
    
    
    echo $theMsg;
    echo "<div class='alert alert-info'>You Will Be Redirected To $url After $seconds Seconds.</div>";
    
    header("refresh:$seconds;url=$url");
    exit();
    
}


/*
** Check items function v1.0
** function to check items in database [function accept parameters]
** $select = the item to select 
** $form = the table to select from
** $value = the value of select 
*/

function CheckItem($select, $from, $value){
    global $con;
    $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
    $statement ->execute(array($value));
    $count = $statement->rowCount();
    return $count;
}

/*
** count number of items function v1.0
** function to count number of items rows 
** $item = the item to count 
** $table = the table to choose from 
*/

function countItems($items, $table) {
    global $con;
    $stmt2 = $con->prepare("SELECT COUNT($items) FROM $table");
    $stmt2->execute();
    return $stmt2->fetchColumn();
}

/*
** get latest records function v1.0
** function to get latest items from data base 
** $select = field to select 
** $table = the table to choose from 
** $limit = Number of records to get
*/

function getLatest($select, $table, $order, $limit=5){
    global $con;
    $getstmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $getstmt->execute();
    $rows = $getstmt->fetchAll();
    return $rows;
}















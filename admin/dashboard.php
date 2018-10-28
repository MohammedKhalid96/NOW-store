<?php

session_start();
if (isset($_SESSION['UserName'])){
    $pageTitle = 'Dashboard';
    include 'init.php';
    
    /* Start dashboard page */    
    $latestUsers = 5;
    $theLatest   = getLatest("*", "users", "UserID", $latestUsers);
    
    $latestItems = 5;
    $theLatest_Items = getLatest("*", "items", "Item_ID", $latestItems);
?>
    <div class="home-stats">
    <div class="container text-center">
        <h1><div class="text-center Dashboard">Dashboard</div></h1>
        <div class="row">
            <div class="col-md-6">
                <div class="stat mem">
                    <span class="label label-info">Total Members</span>
                    <span><a href= "members.php"><?php echo countItems('UserID', 'users') ?></a></span>
                </div>    
            </div>
            <div class="col-md-6">
                <div class="stat mem">
                    <span class="label label-info">Pending Members</span>
                    <span><a href ="members.php?do=Manage&page=pending"><?php echo CheckItem("RegStatus", "users", 0)?></a></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat itm">
                    <span class="label label-info">Total Items</span>
                    <span><a href ="items.php"><?php echo countItems("Item_ID", "items")?></a></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat itm">
                    <span class="label label-info">Pending Items</span>
                    <span><a href ="items.php?do=Manage&page=pending"><?php echo CheckItem("Approve", "items", 0)?></a></span>
                </div>
            </div>
             <div class="col-md-6">
                <div class="stat com">
                    <span class="label label-info">Total Comments</span>
                    <span><a href ="comments.php"><?php echo CountItems("C_ID", "comments")?></a></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat com">
                    <span class="label label-info">Pending Comments</span>
                    <span><a href ="comments.php?do=Manage&page=pending"><?php echo CheckItem("Status", "comments", 0)?></a></span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    /* End dashboard page */
    
     include $tpl . "footer.php";
    
}
else 
{
    header('Location:index.php');
    exit();
}
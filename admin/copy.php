<?php
ob_start();
/*
============================================
== Copy Page
============================================
*/

session_start();
$pageTitle = '';
 if (isset($_SESSION['UserName']))
{
     include 'init.php';
    
     $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    
if($do == 'Manage'){
    
}elseif($do == 'Add'){
    
}elseif($do == 'Insert'){
    
}elseif($do == 'Edit'){
    
}elseif($do == 'Update'){
    
}elseif($do == 'Delete'){
    
}elseif($do == 'Activate'){
    
}
    
     include $tpl . "footer.php";
    
}
else 
{
    header('Location:index.php');
    exit();
}

ob_end_flush();
?>



<div class="latest">
<div class="container latest">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-users"></i> Leatest <?php echo $latestUsers ?> Registerd Users
                </div>
                    <div class="panel-body">
    <ul class="list-unstyled latest-users">
        <?php
            foreach ($theLatest as $user){
                echo '<li>';
                        echo $user['UserName'];
                echo '<a href="members.php?do=Edit&UserID=' . $user['UserID'] . '">';
                        echo '<span class="btn btn-success  pull-right  btn-latest">';
                        echo '<i class="fa fa-edit"></i> Edit';
                        echo '</span>';
                        echo '</a>';
                echo '</li>';
            }
        ?>
    </ul>                  
                    </div>
            </div>
        </div>
            <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-tag"></i> Leatest Items
                </div>
                    <div class="panel-body">
                        <ul class="list-unstyled latest-users">
        <?php
            foreach ($theLatest_Items as $item){
                echo '<li>';
                        echo $item['Name'];
                echo '<a href="items.php?do=Edit&Item_ID=' . $item['Item_ID'] . '">';
                        echo '<span class="btn btn-success  pull-right  btn-latest">';
                        echo '<i class="fa fa-edit"></i> Edit';
                        echo '</span>';
                        echo '</a>';
                echo '</li>';
            }
        ?>
    </ul>                  
                </div>
            </div>
        </div>
    </div>
</div>
</div>











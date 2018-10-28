<?php
ob_start();
session_start();
$pageTitle = 'Profile';

include "init.php"; 
if(isset($_SESSION['user'])){
    
$getUser = $con->prepare("SELECT * FROM users WHERE UserName = ?");
$getUser->execute(array($sessionUser));
$info = $getUser->fetch();
?>

 <section id="profile">
<div class="container">
    <div class="row">
    
        <div class="col-md-4 animated bounceInLeft delay-8s">
            <div class="info">
                <h4 class="list-group-item-heading text-center"><span class="label label-info">Login Name</span></h4>
                <div class="text-center"><i class="fas fa-user-tie"></i><?php echo " " . $info['UserName'] ?></div>
            </div>
        </div>

        <div class="col-md-4 animated bounceInLeft delay-6s">
            <div class="info">
                <h4 class="list-group-item-heading text-center"><span class="label label-info">Email</span></h4>
                <div class="list-group-item-text text-center"><i class="fas fa-envelope"></i><?php echo " " . $info['Email'] ?></div>
            </div>
        </div>

        <div class="col-md-4 animated bounceInLeft delay-4s">
            <div class="info">
                <h4 class="list-group-item-heading text-center"><span class="label label-info">Phone Number</span></h4>
                <div class="list-group-item-text text-center"><i class="fas fa-mobile"></i><?php echo " " . $info['Phone_Number'] ?></div>
            </div>
        </div>


        <div class="col-md-4 animated bounceInLeft delay-2s">
            <div class="info">
                <h4 class="list-group-item-heading text-center"><span class="label label-info">Registered Date</span></h4>
                <div class="list-group-item-text text-center"><i class="fas fa-calendar"></i><?php echo " " . $info['Date'] ?></div>
            </div>
        </div>
        
    </div>
</div>
</section>
<div class="clear"></div>

<div class="main-footer">
    <p>all rights reserved. copyright © 2017</p>
</div>

<?php
}else{
        header('Location : login.php');
        exit(); 
    }
include $tpl . "footer.php"; 
 ob_end_flush();
?> 


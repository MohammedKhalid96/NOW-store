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

<?php
  if (! empty(getItem('Member_ID', $info['UserID']))) {
      echo '<div class="container">';
     echo '<h2 class="text-center">MY ADS</h2>';

 echo '<div class="row">';
      foreach (getItem('Member_ID', $info['UserID'], 1) as $item){
              echo '<div class="box col-md-3 col-sm-6 col-xs-12 mb-2">';         
                echo '<div class="item-box ">';
          
            if ($item['Approve'] == 0) {
                
                echo "<span class='approve-status'>Waiting Approval</span>";
                
            }
          
                echo '<span class="price-tag">' . $item['Price'] . '</span>';
                echo '<a target="_blank" href="items.php?itemid=' . $item['Item_ID'] . '"><img class="img-item" src="' . $item['imageUrl'] . '"/>' . '</a>';
                    
                echo '<div class="caption">';
                echo '<h3 class="name"><a href="items.php?itemid=' . $item['Item_ID'] . '">' . $item['Name'] . '</a></h3>';
                echo '<p>' . $item['Description'] . '</p>';
                echo '<div class="date">' . $item['Add_Date'] . '</div>';
              
                echo '<a href="items.php?itemid=' . $item['Item_ID'] . '"><div class="btn btn-info">View</div>' . '</a>';
                
              echo '</div>';
              echo '</div>';
              echo '</div>';

            }
                echo '</div>';
            echo '</div>';


  }else{
      echo '<h1 class="text-center">Sorry There\' No Ads To Show, Create <a href="newad.php">New Ad</a></h1>';
  }

?>
<?php
}else{
        header('Location : login.php');
        exit(); 
    }
include $tpl . "footer.php";
 ob_end_flush();
?> 

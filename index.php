<?php 
ob_start();
session_start();
$pageTitle = 'NOW';
include_once 'init.php';

?>

<div class="about">
    <h3>NOW</h3>
    <p>ALL YOU WANT IN ONE PLACE</p>
</div>


<div class="container">
    <div class="row">
        <div class="wrapper">
      <?php
        $allItems = getAllfrom('items', 'Item_ID', 'where Approve = 1');
            foreach ($allItems as $item) {
              echo '<div class="box">';
                
                echo '<div class="item-box ">';
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
        ?>
        </div>
    </div>
    

    

</div>

<div class="clear"></div>
<div class="main-footer">
    <p>all rights reserved. copyright © 2017</p>
</div>


<?php


 

include $tpl . "footer.php";
ob_end_flush();
?> 


<?php 
ob_start();
session_start();
$pageTitle = 'Show Items';

include "init.php"; 
 $itemid = isset($_GET['itemid'])&&is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
        
    //select all data depend on this id  
        
      $stmt = $con->prepare("SELECT 
                                items.*,
                                categories.Name AS category_name,
                                users.UserName
                          FROM 
                                items 
                          INNER JOIN
                                categories
                            ON
                                categories.ID = items.Cat_ID
                          INNER JOIN
                                users
                            ON
                                users.UserID = items.Member_ID
                         WHERE 
                                Item_ID = ?
                         AND 
                                Approve = 1
                         ");
    //execute data
         
    $stmt->execute(array($itemid));
    $count = $stmt->rowCount();

if($count > 0){
    
    $item = $stmt->fetch();
        
?>
<h3 class="text-center"><span class="label label-danger"><?php echo $item['Name'] ?></span></h3>
<div class="container">
    <div class="row">
        <div class="item-img col-md-4">
            <?php echo '<img src="' . $item['imageUrl'] . '"/>' ?>
        </div>
        <div class="col-md-8 item-info">
            <p class="desc"><i class="fas fa-quote-left"></i><?php echo $item['Description'] ?></p>
            <ul class="list-unstyled">
                <li class="ull"><i class="fas fa-calendar-alt"></i><span>Added Date</span><i class="fas fa-chevron-right"></i><?php echo $item['Add_Date'] ?></li>
                <li class="ull"><i class="fas fa-dollar-sign"></i><span>Price</span><i class="fas fa-chevron-right"></i><?php echo $item['Price'] ?></li>
                <li class="ull"><i class="fas fa-tags"></i><span>Category</span><i class="fas fa-chevron-right"></i><a href="categories.php?pageid=<?php echo $item['Cat_ID']?>"> <?php echo $item['category_name'] ?></a></li>
                <li class="ull"><i class="fas fa-user-tie"></i><span>Added By</span><i class="fas fa-chevron-right"></i><a href="#"> <?php echo $item['UserName'] ?></a></li>
            </ul>
            
        </div>
    </div>
    
    
    <hr class="custom-hr">
    <?php if (isset($_SESSION['user'])){ ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="add-comment">
                <h3 class="text-center">ADD COMMENT</h3>
                <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID'] ?>" method="POST">
                <textarea rows="7" name="comment" id="comment_text" cols="40" class="ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true"></textarea>
                <input class="btn btn-info" type="submit" value="Add Comment"> 
                </form>
                    <?php
                         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                             
                            $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                            $itemid  = $item['Item_ID'];
                            $userid  = $_SESSION['uid'];
                           
                             
                        if (! empty($comment)){
                            $stmt = $con->prepare("INSERT INTO 
                                                        comments(Comment, Status, Comment_Date, item_id, user_id)
                                                   VALUES(:zcomment, 0, NOW(), :zitemid, :zuserid)");
                            $stmt->execute(array(
                                'zcomment' => $comment,
                                'zitemid' => $itemid,
                                'zuserid' => $userid
                            ));
                            
                            if ($stmt){
                                echo '<dive class="container">';
                                echo '<div class="alert alert-success text-center">Comment Added and waiting for approve</div>';
                                echo '</div>';
                            }
                            
                        }else
                            
                            {
                                 echo '<div class="alert alert-danger">Comment Is Empty</div>';
                            }
                             
                         }
                    ?>
                </div>
            </div>
        </div> 
    <?php }else{
      
            echo '<a href="login.php">Login</a> Or <a href="login.php">Register</a> To Add Comment';
    } ?>
    
    <hr class="custom-hr">
    
                    <?php
                 
                $stmt = $con->prepare("SELECT 
                                            comments.*, users.UserName AS Member 
                                        FROM 
                                            comments
                                        INNER JOIN
                                            users
                                        ON
                                            users.UserID = comments.user_id
                                        WHERE
                                            item_id = ?
                                        AND
                                            Status = 1
                                        ORDER BY
                                            c_id DESC
                                            ");
                $stmt->execute(array($item['Item_ID']));
             //assign to variable 
                $comments = $stmt->fetchAll();
            ?>
    
    
        <?php
            foreach($comments as $comment){ ?>
            <div class="comment-box">
                <div class="row">
                <div class="col-sm-2 text-center">
                    <img class="img-responsive img-thumbnail img-circle center-block" src="19054941_1047893368676958_2572808330654188140_o.jpg" alt="" />
                    <p><?php echo $comment['Member'] ?></p>
                </div>
                <div class="col-sm-10"> 
                    <p class = "lead text-center"> <?php echo $comment['Comment'] ?> </p>
                </div>
                </div>
          </div>
    <hr class="custom-hr">
            <?php } ?>
    </div>
<div class="clear"></div>
<div class="main-footer">
    <p>all rights reserved. copyright © 2017</p>
</div>

<?php
}else{
    echo '<div class="container">';
    echo '<div class="alert alert-danger text-center">There Is No Such ID Or This Item Is Waiting Approval</div>';
    echo '</div>';
}
include $tpl . "footer.php";
ob_end_flush();
?> 


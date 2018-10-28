<?php
ob_start();
/*
============================================
== Manage Members Page
== you can add edit delete members from here
============================================
*/

session_start();
$pageTitle = 'Comments';
 if (isset($_SESSION['UserName']))
{
     include 'init.php';
        
     $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    
 if($do == 'Manage')
{
    
    $stmt = $con->prepare("SELECT 
                                comments.*, items.Name AS Item_Name, users.UserName AS Member 
                            FROM 
                                comments
                            INNER JOIN
                                items
                            ON
                                items.Item_ID = comments.item_id
                            INNER JOIN
                                users
                            ON
                                users.UserID = comments.user_id
                            ORDER BY
                                c_id DESC
                                ");
    $stmt->execute();
 //assign to variable 
    $comments = $stmt->fetchAll();
?>
    
<!------------------------------------------------------------------------------>

      <h1 class="text-center Dashboard">Manage Comments</h1>
        <div class="container">
          <div class="table-responsive">
            <table class="main-table text-center table table-bordered">
                <tr>
                    <td>ID</td>
                    <td>Comment</td>
                    <td>Item Name</td>
                    <td>User Name</td>
                    <td>Added Date</td>                    
                    <td>Control</td>
                </tr>
                
                <?php
    
        foreach($comments as $comment)
        {
                        echo "<tr>";
                            echo "<td>" . $comment['C_ID'] . "</td>";
                            echo "<td>" . $comment['Comment'] . "</td>";
                            echo "<td>" . $comment['Item_Name'] . "</td>";
                            echo "<td>" . $comment['Member'] . "</td>";
                            echo "<td>" . $comment['Comment_Date'] . "</td>";
                            echo "<td>
                            <a href='comments.php?do=Edit&comid=" . $comment['C_ID'] ." ' class='btn btn-success btn-control'><i class= 'fa fa-edit'></i>Edit</a>      
                            
                            
                            <a href='comments.php?do=Delete&comid=" . $comment['C_ID'] . "' class='btn btn-danger confirm btn-delete'><i class= 'fa fa-close'></i>Delete</a>";
            
                            if($comment['Status'] == 0){
                                echo "<a href='comments.php?do=Approve&comid=" . $comment['C_ID'] . "' class='btn btn-info activate'><i class= 'fa fa-check'></i>Approve</a>";
                                
                                
                            }
                            echo  "</td>";    
                        echo "</tr>";
                        
        }
    
                ?>
                
          <tr>               
          </table>
      </div>    
      </div>

             
<?php    }

    
    

    elseif($do == 'Edit')
    {    
        
    //check if get request userid is numeric & get the integer value of it 
        
    $comid = isset($_GET['comid'])&&is_numeric($_GET['comid'])?intval($_GET['comid']):0;
        
    //select all data depend on this id  
        
      $stmt = $con->prepare("SELECT 
                                * 
                          FROM 
                                comments 
                          WHERE 
                                C_ID = ?
                          ");    //execute data
        
    $stmt->execute(array($comid));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
        

        
if($count > 0){ ?>
    
        <div class="container cont">
            <img src="layout/css/images/Consultant-256.png">
            <form class="" action="?do=Update" method="POST">
                <input type="hidden" name="comid" value="<?php echo $comid ?>" />

                <div class="">
                    <textarea class="form-control" name="comment"><?php echo $row['Comment'] ?></textarea>
                    <hr>
                </div>

                <div class="">
                    <input type="submit" value="Save" class="btn btn-success btn-block" />    
                </div>    
            </form>
        </div>

<!--=========================================--!>

<?php
}
    
else
{
    echo "<div class = 'container'>";
    $theMsg = '<div class="alert alert-danger">There is no such ID</div>';
    redirectHome($theMsg);
    echo "</div>";
}
        
/*---------------------------------------------------------------------------
*******************************Update****************************************
----------------------------------------------------------------------------*/
        
    }
    
    elseif ($do == 'Update')
    {
        echo "<h1 class= 'text-center  Dashboard'> Update Comment </h1>";
        echo "<div class='container'>";
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //get variables from form
                  $comid       = $_POST['comid'];
                  $comment     = $_POST['comment'];
                
                    
                     $stmt = $con->prepare("UPDATE comments SET Comment =? WHERE C_ID =?");
                     $stmt->execute(array($comment, $comid));
                
                //Echo Success Message 
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
                redirectHome($theMsg,'back');
            }
                
                
            else
            {
                
                echo "<div class = 'container'>";
                $theMsg = '<div class="alert alert-danger">Sorry You Can\'t browse this page directly</div>';
                redirectHome($theMsg);
                echo "</div>";
                
            }
        echo "</div>";
        
    /*----------------------------------------------------------------------------
    ************************************Delete************************************
    -----------------------------------------------------------------------------*/
        
    }
    elseif($do == 'Delete'){
        
        //Delete 
        echo "<h1 class= 'text-center Dashboard'> Delete Comment </h1>";
        echo "<div class='container'>";
        
                
    $comid = isset($_GET['comid'])&&is_numeric($_GET['comid'])?intval($_GET['comid']):0;
        
    //select all data depend on this id  
        
    $check = CheckItem('C_ID', 'comments', $comid);        
        
    //execute data

if($check > 0)
{
    
    $stmt = $con->prepare("DELETE FROM comments WHERE C_ID = :zid");
    $stmt->bindparam(":zid", $comid);
    $stmt->execute();
       echo "<div class = 'container'>";
       $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Deleted</div>';
       redirectHome($theMsg, 'back');
       echo "</div>";
    
}
        else
        {
                echo "<div class = 'container'>";
                $theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';
                redirectHome($theMsg);
                echo "</div>";
        }
        echo '</div>';
    }
    
    elseif($do='Approve'){
        
        echo "<h1 class= 'text-center Dashboard'> Activate Comment </h1>";
        echo "<div class='container'>";
        
                
    $comid = isset($_GET['comid'])&&is_numeric($_GET['comid'])?intval($_GET['comid']):0;
        
    //select all data depend on this id  
        
    $check = CheckItem('C_ID', 'comments', $comid);        
        
    //execute data

if($check > 0)
{
    
    $stmt = $con->prepare("UPDATE comments SET Status = 1 WHERE C_ID = ?");
    $stmt->execute(array($comid));
       echo "<div class = 'container'>";
       $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated</div>';
       redirectHome($theMsg);
       echo "</div>";
    
}
        else
        {
                echo "<div class = 'container'>";
                $theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';
                redirectHome($theMsg);
                echo "</div>";
        }
        echo '</div>';
        
        
    }
    
    
/*=========================================*/
    
     include $tpl . "footer.php";
    
}
else 
{
    header('Location:index.php');
    exit();
}

ob_end_flush();
?>
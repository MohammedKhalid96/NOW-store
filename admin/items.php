<?php
ob_start();
/*
============================================
== items Page
============================================
*/

session_start();
$pageTitle = 'Items';
 if (isset($_SESSION['UserName']))
{
     include 'init.php';
    
     $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    
if($do == 'Manage'){
    $stmt2 = $con->prepare("SELECT 
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
                                users.UserID = items.Member_ID");
    
    $stmt2->execute();
    $items = $stmt2->fetchAll(); ?>

      <h1 class="text-center Dashboard">Items</h1>
        <div class="container">
          <div class="table-responsive">
            <table class="main-table text-center table table-bordered">
                <tr>
                    <td>ID</td>
                    <td>Image</td>
                    <td>Name</td>
                    <td>Description</td>
                    <td>Price</td>
                    <td>Adding Date</td>
                    <td>Category</td>
                    <td>User Name</td>                
                    <td>Control</td>
                </tr>
                
                <?php
    
        foreach($items as $item)
        {
                        echo "<tr>";
                            echo "<td>" . $item['Item_ID'] . "</td>";
                            echo "<td><img class='imgUrl' src='" . $item['imageUrl'] . "'</td>";
                            echo "<td>" . $item['Name'] . "</td>";
                            echo "<td>" . $item['Description'] . "</td>";
                            echo "<td>" . $item['Price'] . "</td>";
                            echo "<td>" . $item['Add_Date'] . "</td>";
                            echo "<td>" . $item['category_name'] . "</td>";
                            echo "<td>" . $item['UserName'] . "</td>";
                    
            
                            echo "<td>
                             <a href='items.php?do=Edit&itemid=" . $item['Item_ID'] . "' class='btn btn-success btn-control'><i class= 'fa fa-edit'></i>Edit</a>      
                            
                            
                            <a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . "' class='btn btn-danger confirm btn-delete'><i class= 'fa fa-close'></i>Delete</a>";
            
                            echo "<br>";
                            if($item['Approve'] == 0){
                                echo "<a href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "' class='btn btn-info activate'><i class= 'fa fa-check'></i>Approve</a>";
                                
                                
                            }
            
                            echo  "</td>";    
                        echo "</tr>";
                        
        }
    
                ?>
                
          <tr>               
          </table>
      </div>
          <a href="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Item</a>    
          <a href="items.php?do=DeleteAll" class="btn btn-danger"><i class="fa fa-close"></i>Delete all</a>      
</div>

             

<?php    
}elseif($do == 'Add'){ ?>

        <div class="container cont">
            <img src="layout/css/images/shopping-cart-icon.png">
            <form class="" action="?do=Insert" method="POST">
                
                <!--start username field-->
        <div class="">
            <input type="text"  name="img" class="form-control" required="required" placeholder="Image URL"/>    
        </div>
                
        <div class="">
            <input type="text"  name="name" class="form-control" required="required" placeholder="Name"/>    
        </div>
              
                     <!--start description field-->
        <div class="">
            <input type="text" name="description" class="form-control" placeholder="Description"/>    
        </div>    
                
                     <!--start price field-->
        <div class="">
            <input type="text" name="price" class="form-control" required="required" placeholder="Price"/>    
        </div>    
                
        <div class="">
            <select name="member">
                <option value="0">Member</option>
                <?php
                    $stmt = $con->prepare("SELECT * FROM users");
                    $stmt->execute();
                    $users = $stmt->fetchAll();
                    foreach ($users as $user) {
                        echo "<option value='" . $user['UserID'] . "'>" . $user['UserName'] . "</option>";
                    }
                ?>
            </select>    
            <hr>
        </div>
                
        <div class="">
            <select name="category">
                <option value="0">Category</option>
                <?php
                    $stmt = $con->prepare("SELECT * FROM categories");
                    $stmt->execute();
                    $cats = $stmt->fetchAll();
                    foreach ($cats as $cat) {
                        echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
                    }
                ?>
            </select> 
            <hr>
        </div>


        <div class="">
            <input type="submit" value="Add Item" class="btn btn-success btn-block" />    
        </div>    
    </form>
</div>

<?php
 }elseif($do == 'Insert'){
    
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
        echo "<h1 class= 'text-center'> Add Item </h1>";
        echo "<div class='container'>";
                //get variables from form
                  $img      = $_POST['img'];
                  $name     = $_POST['name'];
                  $desc     = $_POST['description'];
                  $price    = $_POST['price'];
                  $member   = $_POST['member'];
                  $cat      = $_POST['category'];
                
                
                //validate the form
                  $formErrors = array();
                if (empty($img)){
                    $formErrors[] = 'Image Url Can\'t Be<strong> Empty</strong>';
                }
                
                
                if (empty($name)){
                    $formErrors[] = 'Name Can\'t Be<strong> Empty</strong>';
                }
                
                if (empty($price)){
                    $formErrors[] = 'Price Can\'t Be<strong> Empty</strong>';
                }            
                
                if ($member == 0){
                    $formErrors[] = 'You Must Choose the<strong> Member</strong>';
                }           
                
                if ($cat == 0){
                    $formErrors[] = 'You Must Choose the<strong> Category</strong>';
                }           
                
                    foreach($formErrors as $error){
                        echo '<div class="alert alert-danger">' . $error . '</div>';
                       
                  }
                   
                //check if there is no errors proced the update operation 
                if (empty($formErrors)) {   
                //insert userinfo in database
                $stmt = $con->prepare("INSERT INTO 
                                      items(imageUrl, Name, Description, Price, Add_Date, Cat_ID, Member_ID) 
                                      VALUES(:zimg, :zname, :zdesc, :zprice, now(), :zcat, :zmember)");
                $stmt->execute(array(
                'zimg'          => $img,    
                'zname'         => $name,
                'zdesc'         => $desc,
                'zprice'        => $price,
                'zcat'          => $cat,
                'zmember'       => $member
                ));
                    
                //Echo Success Message 
                        echo "<div class = 'container'>";
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
                        redirectHome($theMsg,'back'); 
                        echo "</div>";
                    }
                    
            }
                
                else
            {
                echo "<div class= 'container'>";
               $theMsg = '<div class="alert alert-danger">Sorry You Can\'t browse this page directly</div>';
                
               redirectHome($theMsg);    
                echo "</div>";
            }
        echo "</div>";
    
    
    
}elseif($do == 'Edit'){
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
                          ");
    //execute data
        
    $stmt->execute(array($itemid));
    $item = $stmt->fetch();
    $count = $stmt->rowCount();
        

        
if($count > 0){ ?>


    <div class="container cont">
            <img src="layout/css/images/shopping-cart-icon.png"> 
            <form class="" action="?do=Update" method="POST">
                <input type="hidden" name="itemid" value="<?php echo $itemid ?>" />
                
        <div class="">
            <input type="text" name="img" class="form-control" placeholder="Image URL" value="<?php echo $item['imageUrl']?>"/>    
        </div>
                
        <div class="">
            <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo $item['Name']?>"/>    
        </div>
              
        <div class="">
            <input type="text" name="description" class="form-control" placeholder="Description" value="<?php echo $item['Description']?>"/>    
        </div>  
                
        <div class="">
            <input type="text" name="price" class="form-control" placeholder="Price" value="<?php echo $item['Price']?>"/>    
        </div>
                
        <div class="">
            <select name="member">
                <option value="0">Member</option>
                <?php
                    $stmt = $con->prepare("SELECT * FROM users");
                    $stmt->execute();
                    $users = $stmt->fetchAll();
                    foreach ($users as $user) {
                        echo "<option value='" . $user['UserID'] . "'"; 
                        if($item['Member_ID'] == $user['UserID']){echo 'selected';}
                        echo ">" . $user['UserName'] . "</option>";
                    }
                ?>
            </select>    
            <hr>
        </div>
                
        <div class="">
            <select name="category">
                <option value="0">Category</option>
                <?php
                    $stmt = $con->prepare("SELECT * FROM categories");
                    $stmt->execute();
                    $cats = $stmt->fetchAll();
                    foreach ($cats as $cat) {
                       echo "<option value='" . $cat['ID'] . "'"; 
                        if($item['Cat_ID'] == $cat['ID']){echo 'selected';}
                        echo ">" . $cat['Name'] . "</option>";
                    }
                ?>
            </select>  
            <hr>
        </div>


        <div class="">
            <input type="submit" value="Update Item" class="btn btn-success btn-block" />    
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
        
    
}elseif($do == 'Update'){
      echo "<h1 class= 'text-center  Dashboard'> Update Item </h1>";
        echo "<div class='container'>";
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //get variables from form
                  $id       = $_POST['itemid'];
                  $img      = $_POST['img'];
                  $name     = $_POST['name'];
                  $desc     = $_POST['description'];
                  $price    = $_POST['price'];
                  $cat      = $_POST['category'];
                  $member   = $_POST['member'];
                  
                
                
                     $stmt = $con->prepare("UPDATE items SET imageUrl =?, Name =?, Description= ?, Price =?, Cat_ID =?, Member_ID=? WHERE Item_ID =?");
                     $stmt->execute(array($img, $name, $desc, $price, $cat, $member, $id));
                
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
        
    
}elseif($do == 'Delete'){
     echo "<h1 class= 'text-center Dashboard'> Delete Item </h1>";
        echo "<div class='container'>";
        
                
    $itemid = isset($_GET['itemid'])&&is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
        
    //select all data depend on this id  
        
    $check = CheckItem('Item_ID', 'items', $itemid);        
        
    //execute data

if($check > 0)
{
    
    $stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zid");
    $stmt->bindparam(":zid", $itemid);
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
//-----------------------------------------------
    
    elseif($do == 'DeleteAll'){
     echo "<h1 class= 'text-center Dashboard'> Delete All </h1>";
        echo "<div class='container'>";
        
                        
    //select all data depend on this id  
                
    //execute data
 
    $stmt = $con->prepare("DELETE FROM items");
    $stmt->execute();
       echo "<div class = 'container'>";
       $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'All Deleted</div>';
       redirectHome($theMsg, 'back');
       echo "</div>";
        echo '</div>'; 
}
    
    
//-----------------------------------------
    
    elseif($do == 'Approve'){
     echo "<h1 class= 'text-center Dashboard'> Approve Item </h1>";
        echo "<div class='container'>";
        
                
    $itemid = isset($_GET['itemid'])&&is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
        
    //select all data depend on this id  
        
    $check = CheckItem('Item_ID', 'items', $itemid);        
        
    //execute data

if($check > 0)
{
    
    $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");
    $stmt->execute(array($itemid));
       echo "<div class = 'container'>";
       $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated</div>';
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
    
     include $tpl . "footer.php";
    
}
else 
{
    header('Location:index.php');
    exit();
}

ob_end_flush();
?>








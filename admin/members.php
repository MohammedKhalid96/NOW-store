<?php
ob_start();
/*
============================================
== Manage Members Page
== you can add edit delete members from here
============================================
*/

session_start();
$pageTitle = 'Members';
 if (isset($_SESSION['UserName']))
{
     include 'init.php';
        
     $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    
 if($do == 'Manage')
{
    $query = '';
    if(isset($_GET['page']) && $_GET['page'] == 'pending') {
        
        $query = 'AND RegStatus = 0';
    }   
    
    $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query");
    $stmt->execute();
 //assign to variable 
    $rows = $stmt->fetchAll();
?>
    
<!------------------------------------------------------------------------------>

      <h1 class="text-center Dashboard">Manage Members</h1>
        <div class="container">
          <div class="table-responsive">
            <table class="main-table manage-members text-center table table-bordered">
                <tr>
                    <td>ID</td>
                    <td>Avatar</td>
                    <td>UserName</td>
                    <td>Email</td>
                    <td>Full Name</td>
                    <td>Phone Number</td>
                    <td>Address</td>
                    <td>Registerd Date</td>                    
                    <td>Control</td>
                </tr>
                
                <?php
    
        foreach($rows as $row)
        {
                        echo "<tr>";
                            echo "<td>" . $row['UserID'] . "</td>";
            
                            echo "<td>";
                                if (empty($row['avatar'])) {
                                    echo "No Image";
                                }else{
                                    echo "<img class='img-circle' src='uploads/avatars/" . $row['avatar'] . "' alt='' />";
                                }
                            echo "</td>";
                            
                            echo "<td>" . $row['UserName'] . "</td>";
                            echo "<td>" . $row['Email'] . "</td>";
                            echo "<td>" . $row['FullName'] . "</td>";
                            echo "<td>" . $row['Phone_Number'] . "</td>";
                            echo "<td>" . $row['Address'] . "</td>";
                            echo "<td>" . $row['Date'] . "</td>";
                            echo "<td>
                            <a href='members.php?do=Edit&UserID=" . $row['UserID'] ." ' class='btn btn-success btn-control'><i class= 'fa fa-edit'></i>Edit</a>      
                            
                            
                            <a href='members.php?do=Delete&UserID=" . $row['UserID'] . "' class='btn btn-danger confirm btn-delete'><i class= 'fa fa-close'></i>Delete</a>";
            
                            if($row['RegStatus'] == 0){
                                echo "<a href='members.php?do=Activate&UserID=" . $row['UserID'] . "' class='btn btn-info activate'><i class= 'fa fa-check'></i>Activate</a>";
                                
                                
                            }
                            echo  "</td>";    
                        echo "</tr>";
                        
        }
    
                ?>
                
          <tr>               
          </table>
      </div>
          <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Member</a>      
      </div>

             
<?php    }
    
/*-----------------------------------------------------------------------------
*******************************Add*********************************************
------------------------------------------------------------------------------*/
    
    
    elseif($do== 'Add')
    {
?>


 <div class="container cont">
     <img src="layout/css/images/malecostume-512.png">
    <form  class="" action="?do=Insert" method="POST" enctype="multipart/form-data">
        
        <div class="">    
              <input type="text" name="UserName" class="form-control" autocomlete="off" required="required" placeholder="User Name"/> 
        </div>
        
        
        
        <div class="">
              <input type="password" name="password" class="form-control" autocomplete='new-password' required="required" placeholder="Password"/> 
        </div>
            
        <div class="">
              <input type="email" name="email" class="form-control" required="required" placeholder="Email Must Be Valid" />  
        </div>
        
        
        <div class="">
            <input type="text" name="Full" class="form-control" required="required" placeholder="Full Name"/>    
        </div>
        
        
        <div class="">
            <input type="Number" name="phone" class="form-control" required="required" placeholder="Phone Number"/>
        </div>
        
        
        <div class="">
            <input type="text" name="address" class="form-control" required="required" placeholder="Address"/>    
        </div>
        
        
        <div class="">
            <input type="file" name="avatar" class="form-control" required="required"/>    
        </div>

        <div class="">
            <input type="submit" value="Add Member" class="btn btn-success btn-block" />    
        </div>
     </form>
</div>

        
         


<!------------------------------------------------------------------------------>
<!----------------------------Insert--------------------------------------------
<!------------------------------------------------------------------------------>

<?php
        
    }
    elseif($do == 'Insert')
    {
    
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
        echo "<h1 class= 'text-center'> Add Member </h1>";
        echo "<div class='container'>";
                  $avatarName               = $_FILES['avatar']['name'];
                  $avatarSize               = $_FILES['avatar']['size'];
                  $avatarTmp                = $_FILES['avatar']['tmp_name'];
                  $avatarType               = $_FILES['avatar']['type'];
                  $avatarAllowedExtension   = array("jpeg", "jpg", "png", "gif"); 
                  
                  $avatarExtension = strtolower(end(explode('.', $avatarName)));
                
                //get variables from form
                  $user     = $_POST['UserName'];
                  $pass     = $_POST['password'];
                  $email    = $_POST['email'];
                  $name     = $_POST['Full'];
                  $phone    = $_POST['phone'];
                  $address   = $_POST['address'];
                  $hashpass = sha1($_POST['password']);
                
                //validate the form
                  $formErrors = array();
                
                if (strlen($user) < 6){
                    $formErrors[] = 'Username Can\'t Be Less Than <strong> 6 Characters</strong>';
                }
                
                 if (strlen($user) > 20){
                    $formErrors[] = 'Username Can\'t Be More Than <strong> 20 Characters</strong>';
                }
           
                 if (empty($user)){
                     $formErrors[] = 'UserName Cant Be <strong>Empty</strong>';
                 }
                
                
                  if (empty($pass)){
                     $formErrors[] = 'Password Cant Be <strong>Empty</strong>';
                 }
                
                
                  if (empty($email)){
                     $formErrors[] = 'Email Cant Be <strong>Empty</strong>';
                 }
                
                
                  if (empty($name)){
                     $formErrors[] = 'FullName Cant Be <strong>Empty</strong>';
                 }
                
                 if (empty($phone)){
                     $formErrors[] = 'PhonNumber Cant Be <strong>Empty</strong>';
                 }
                
                if (empty($address)){
                     $formErrors[] = 'Address Cant Be <strong>Empty</strong>';
                 }
                
                
                if(! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)){
                     $formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';   
                  }
                
                if(empty($avatarName)){
                     $formErrors[] = 'Avatar Is <strong>Required</strong>';   
                  }
                
                  if($avatarSize > 4194304){
                     $formErrors[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';   
                  }
                
                
                    foreach($formErrors as $error){
                        echo '<div class="alert alert-danger">' . $error . '</div>';
                       
                  }
                   
                //check if there is no errors proced the update operation 
                if (empty($formErrors)) {
                
                $avatar = rand(0, 10000000000) . '_' . $avatarName;    
                move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatar);
                //check if user exist in database
                $check = checkItem("UserName", "users", $user);
                    if($check == 1){
                          $theMsg = "<div class='alert alert-danger'>"  . 'Sorry This UserName Is Exist</div>';
                        redirectHome($theMsg,'back');
                    }else {
                        
                    
                   
                //insert userinfo in database
                $stmt = $con->prepare("INSERT INTO 
                                      users(UserName, Password, Email, FullName, Phone_Number, Address, RegStatus, Date, avatar) 
                                      VALUES(:zuser, :zpass, :zmail, :zfullname, :zphone, :zaddress, 1, now(), :zavatar)");
                $stmt->execute(array(
                'zuser'         => $user,
                'zpass'         => $hashpass,
                'zmail'         => $email,    
                'zfullname'     => $name,
                'zphone'        => $phone,
                'zaddress'      => $address,
                'zavatar'       => $avatar
                ));
                    
                //Echo Success Message 
                        echo "<div class = 'container'>";
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
                        redirectHome($theMsg,'back'); 
                        echo "</div>";
                    }
                    
            }
                
                }else
            {
                echo "<div class= 'container'>";
               $theMsg = '<div class="alert alert-danger">Sorry You Can\'t browse this page directly</div>';
                
               redirectHome($theMsg);    
                echo "</div>";
            }
        echo "</div>";
        
/*-------------------------------------------------------------------------
**********************************Edit*************************************
--------------------------------------------------------------------------*/
        
    }
    elseif($do == 'Edit')
    {    
        
    //check if get request userid is numeric & get the integer value of it 
        
    $userid = isset($_GET['UserID'])&&is_numeric($_GET['UserID'])?intval($_GET['UserID']):0;
        
    //select all data depend on this id  
        
      $stmt = $con->prepare("SELECT 
                                * 
                          FROM 
                                users 
                          WHERE 
                                UserID = ?
                          LIMIT 1");
    //execute data
        
    $stmt->execute(array($userid));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
        

        
if($count > 0){ ?>
    
    
    <div class="container cont">
            <img src="layout/css/images/malecostume-512.png">
            <form class="" action="?do=Update" method="POST">
            <input type="hidden" name="userid" value="<?php echo $userid ?>" />
                
                
         <div class="">
            <input type="text" name="UserName" placeholder="UserName" value="<?php echo $row['UserName'] ?>" class="form-control" autocomlete="off" />
         </div>

        <div class="">
            <input type="hidden" placeholder="Password" name="oldpassword" value="<?php echo $row['password']?>"/>
            <input type="password" name="newpassword" class="form-control" autocomplete='new-password' />    
        </div>

        <div class="">
            <input type="email" placeholder="Email" name="email" value="<?php echo $row['Email'] ?>" class="form-control"/>    
        </div>    

        <div class="">
            <input type="text" placeholder="Full Name" name="Full" value="<?php echo $row['FullName'] ?>" class="form-control"/>    
        </div>    
                
        <div class="">
            <input type="Number" placeholder="Phone Number" name="phone" value="<?php echo $row['Phone_Number'] ?>" class="form-control"/>    
        </div>
                
        <div class="">
            <input type="text" placeholder="Address" name="address" value="<?php echo $row['Address'] ?>" class="form-control"/>    
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
        echo "<h1 class= 'text-center  Dashboard'> Update Member </h1>";
        echo "<div class='container'>";
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //get variables from form
                  $id       = $_POST['userid'];
                  $user     = $_POST['UserName'];
                  $email    = $_POST['email'];
                  $name     = $_POST['Full'];
                  $phone    = $_POST['phone'];
                  $address    = $_POST['address'];
                //Pass trick
                  $pass='';
                  $pass = empty($_POST['newpassword']) ?  $_POST['oldpassword'] : sha1($_POST['newpassword']);
                
                //validate the form
                  $formErrors = array();
                
                if (strlen($user) < 6){
                    $formErrors[] = 'Username Can\'t Be Less Than <strong> 6 Characters</strong>';
                }
                 if (strlen($user) > 20){
                    $formErrors[] = '<div class="alert alert-danger">Username Can\'t Be More Than <strong> 20 Characters</strong>';
                }
           
                
                    foreach($formErrors as $error){
                        echo '<div class="alert alert-danger">' .  $error . '</div>';
                  }
                   
                
                //check if there is no errors proced the update operation 
                if (empty($formErrors)) {
                    
                     $stmt2 = $con->prepare("SELECT * FROM users WHERE UserName = ? AND UserID != ?");
                     $stmt2->execute(array($user, $id));
                     $count = $stmt2->rowCount();
                    
                     if ($count == 1){
                         echo '<div class="alert alert-danger">Sorry This UserName Is Exist</div>';
                         redirectHome($theMsg,'back');
                         
                     }else{
                     $stmt = $con->prepare("UPDATE users SET UserName =?, Email= ?, FullName =?, Phone_Number =?, Address =?, Password= ? WHERE UserID =?");
                     $stmt->execute(array($user, $email, $name, $phone, $address, $pass, $id));
                
                //Echo Success Message 
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
                redirectHome($theMsg,'back');
            }
                }
                
                }else
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
        echo "<h1 class= 'text-center Dashboard'> Delete Member </h1>";
        echo "<div class='container'>";
        
                
    $userid = isset($_GET['UserID'])&&is_numeric($_GET['UserID'])?intval($_GET['UserID']):0;
        
    //select all data depend on this id  
        
    $check = CheckItem('userid', 'users', $userid);        
        
    //execute data

if($check > 0)
{
    
    $stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");
    $stmt->bindparam(":zuser", $userid);
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
    
    elseif($do='Activate'){
        
        echo "<h1 class= 'text-center Dashboard'> Activate Member </h1>";
        echo "<div class='container'>";
        
                
    $userid = isset($_GET['UserID'])&&is_numeric($_GET['UserID'])?intval($_GET['UserID']):0;
        
    //select all data depend on this id  
        
    $check = CheckItem('userid', 'users', $userid);        
        
    //execute data

if($check > 0)
{
    
    $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");
    $stmt->execute(array($userid));
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
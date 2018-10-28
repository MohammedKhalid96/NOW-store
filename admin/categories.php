<?php
ob_start();
/*
============================================
== categories Page
============================================
*/

session_start();
$pageTitle = 'Categories';
 if (isset($_SESSION['UserName']))
{
     include 'init.php';
    
     $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    
    
if($do == 'Manage'){
    $stmt2 = $con->prepare("SELECT * FROM categories");
    $stmt2 ->execute();
    $cats = $stmt2->fetchAll(); ?>

      <h1 class="text-center Dashboard">Categories</h1>
        <div class="container">
          <div class="table-responsive">
            <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>ID</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Visibility</td>
                        <td>Comment</td>
                        <td>Ads</td>                    
                        <td>Control</td>
                    </tr>

                <?php
    
        foreach($cats as $cat)
        {
                        echo "<tr>";
                            echo "<td>" . $cat['ID'] . "</td>";
                            echo "<td>" . $cat['Name'] . "</td>";
                            echo "<td>" . $cat['Description'] . "</td>";

                            echo "<td>";
                                if($cat['Visibility']==1){echo '<span class="Visibility cat-span">Hidden</span>';}elseif($cat['Visibility']==0){
                                    echo '<span class="Visibility cat-span">Visible</span>';
                                } 
                            echo "</td>";
            
                            echo "<td>";
                                if($cat['Allow_Comment']==1){echo '<span class="All_Comment cat-span">Disabled</span>';}elseif($cat['Allow_Comment']==0){
                                    echo '<span class="Dis_Comment cat-span">Allowed</span>';
                                } 
                            echo "</td>";
            
                             echo "<td>";
                                if($cat['Allow_Ads']==1){echo '<span class="All_Ads cat-span">Disabled</span>';}elseif($cat['Allow_Ads']==0){
                                    echo '<span class="Dis_Ads cat-span">Allowed</span>';
                                } 
                            echo "</td>";
            
                            echo "<td>
                             <a href='categories.php?do=Edit&catid=" . $cat['ID'] ." ' class='btn btn-success btn-control'><i class= 'fa fa-edit'></i>Edit</a>      
                            
                            
                            <a href='categories.php?do=Delete&catid=" . $cat['ID'] . "' class='btn btn-danger confirm btn-delete'><i class= 'fa fa-close'></i>Delete</a>";
            
                            echo  "</td>";    
                        echo "</tr>";
                        
        }
    
                ?>
                
          <tr>   
          </table>
      </div>
          <a href="categories.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Category</a>      
      </div>

             

    <?php
}elseif($do == 'Add'){?>
     <!--Add categories page--> 
        <div class="container cont">
            <img src="layout/css/images/Shopping-basket-add-icon.png">
            <form class="" action="?do=Insert" method="POST">
                
            <div class="">
                <input type="text" name="name" class="form-control" autocomlete="off" required placeholder="Name"/>    
            </div>

            <div class="">
                <input type="text" name="description" class="form-control" placeholder="Description" /> 
            </div>

            <div class="">
                <input type="text" name="ordering" class="form-control" placeholder="Number to arrange the categories" />   
                <hr>
            </div>

            <div class="">
                <div>
                    <input id="Vis-yes" type="radio" name="Visibility" value="0" checked/>
                    <label for="Vis-yes"><span class="label label-info">Visible</span></label>
                </div>
                <div>
                    <input id="Vis-no" type="radio" name="visibility" value="1"/>
                    <label for="Vis-no"><span class="label label-danger">No</span></label>
                </div>
                <hr>
            </div>    

            <div class="">
                <div>
                    <input id="com-yes" type="radio" name="comment" value="0" checked/>
                    <label for="com-yes"><span class="label label-info">Allow Commenting</span></label>
                </div>
                <div>
                    <input id="com-no" type="radio" name="comment" value="1"/>
                    <label for="com-no"><span class="label label-danger">No</span></label>
                </div>
                <hr>
            </div>    

            <div class="">
                <div>
                    <input id="Ads-yes" type="radio" name="ads" value="0" checked/>
                    <label for="Ads-yes"><span class="label label-info">Allow Ads</span></label>
                </div>
                <div>
                    <input id="Ads-no" type="radio" name="ads" value="1"/>
                    <label for="Ads-no"><span class="label label-danger">No</span></label>
                </div>
                <hr>
            </div>    
                
            <div class="">
                <input type="submit" value="Add Category" class="btn btn-success btn-block" />    
            </div>    
     </form>
</div>


<?php
    
    
}elseif($do == 'Insert'){
    
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
        echo "<h1 class= 'text-center'> Insert Category </h1>";
        echo "<div class='container'>";
                //get variables from form
                  $name        = $_POST['name'];
                  $desc        = $_POST['description'];
                  $order       = $_POST['ordering'];
                  $visible     = $_POST['Visibility'];
                  $comment     = $_POST['comment'];
                  $ads         = $_POST['ads'];
                
              
                //check if category exist in database
                $check = checkItem("Name", "categories", $name);
                    if($check == 1){
                          $theMsg = "<div class='alert alert-danger'>"  . 'Sorry This Category Is Exist</div>';
                        redirectHome($theMsg,'back');
                    }else {
                        
                    
                   
                //insert category in database
                $stmt = $con->prepare("INSERT INTO 
                                      categories(Name, Description, Ordering, Visibility, Allow_Comment, Allow_Ads) 
                                      VALUES(:zname, :zdesc, :zorder, :zvisible, :zcomment, :zads) ");
                $stmt->execute(array(
                'zname'             => $name,
                'zdesc'             => $desc,
                'zorder'            => $order,
                'zvisible'          => $visible,
                'zcomment'          => $comment,
                'zads'              => $ads
                ));
                    
                //Echo Success Message 
                        echo "<div class = 'container'>";
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
                        redirectHome($theMsg,'back'); 
                        echo "</div>";
                    }
                
                }else
            {
                echo "<div class= 'container'>";
               $theMsg = '<div class="alert alert-danger">Sorry You Can\'t browse this page directly</div>';
                
               redirectHome($theMsg,'back');    
                echo "</div>";
            }
        echo "</div>";
         
    
    
}elseif($do == 'Edit'){
      $catid = isset($_GET['catid'])&&is_numeric($_GET['catid'])?intval($_GET['catid']):0;
        
    //select all data depend on this id  
        
      $stmt = $con->prepare("SELECT 
                                * 
                          FROM 
                                categories 
                          WHERE 
                                ID = ?
                          ");
    //execute data
        
    $stmt->execute(array($catid));
    $cat = $stmt->fetch();
    $count = $stmt->rowCount();
        

        
if($count > 0){ ?>
    
        <div class="container cont">
            <div class="col-xs-12 img-edit">
                <img src="layout/css/images/images5B5YPJO1.jpg">
            </div>
            
            <div class="col-xs-12">
                <div class="row">
                    <form class="" action="?do=Update" method="POST">
                        <input type=hidden name="catid" value="<?php echo $catid ?>" />          
                    
                        <div class="col-xs-12">
                            <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo $cat['Name']?>"/>    
                        </div>


                        <div class="col-xs-12">
                            <input type="text" name="description" class="form-control" placeholder="Description" value="<?php echo $cat['Description']?>"/> 
                        </div>

                        <div class="col-xs-12">
                            <input type="text" name="ordering" class="form-control" placeholder="Number to arrange the categories" value="<?php echo $cat['Ordering']?>"/>  
                            <hr>
                        </div>

                        <div class="col-xs-12">
                            <div>
                                <input id="Vis-yes" type="radio" name="Visibility" value="0" <?php if ($cat['Visibility'] == 0){echo'checked';} ?>/>
                                <label for="Vis-yes"><span class="label label-info">Visible</span></label>
                            </div>
                            <div>  
                                <input id="Vis-no" type="radio" name="visibility" value="1" <?php if ($cat['Visibility'] == 1){echo'checked';} ?>/>
                                <label for="Vis-no"><span class="label label-danger">No</span></label>
                             </div>
                            <hr>
                        </div>
                        
                        <div class="col-xs-12">
                            <div>                
                                <input id="com-yes" type="radio" name="comment" value="0" <?php if ($cat['Allow_Comment'] == 0){echo'checked';} ?>/>
                                <label for="com-yes"><span class="label label-info">Allow Commenting</span></label>
                            </div>
                            <div>
                                <input id="com-no" type="radio" name="comment" value="1" <?php if ($cat['Allow_Comment'] == 1){echo'checked';} ?>/>
                                <label for="com-no"><span class="label label-danger">No</span></label>
                            </div>
                            <hr>
                        </div>
                        

                        
                        <div class="col-xs-12">
                            <div>
                                <input id="Ads-yes" type="radio" name="ads" value="0" <?php if ($cat['Allow_Ads'] == 0){echo'checked';} ?>/>
                                <label for="Ads-yes"><span class="label label-info">Allow Ads</span></label>
                            </div>
                            <div>
                                <input id="Ads-no" type="radio" name="ads" value="1" <?php if ($cat['Allow_Ads'] == 1){echo'checked';} ?>/>
                                <label for="Ads-no"><span class="label label-danger">No</span></label>
                            </div>
                            <hr>
                        </div>
                        
                        <div class="form-input form-group">
                            <input type="submit" value="Update Category" class="btn btn-success btn-block" />    
                        </div>    
                    </form>
                </div>
            </div>
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
    
}elseif($do == 'Update'){
    
    echo "<h1 class= 'text-center  Dashboard'> Update Category </h1>";
        echo "<div class='container'>";
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //get variables from form
                  $id           = $_POST['catid'];
                  $name         = $_POST['name'];
                  $desc         = $_POST['description'];
                  $order        = $_POST['ordering'];
                  $visible      = $_POST['Visibility'];
                  $comment      = $_POST['comment'];
                  $ads          = $_POST['ads'];
                   
                     $stmt = $con->prepare("UPDATE categories SET Name =?, Description= ?, Ordering =?, Visibility =?, Allow_Comment =?, Allow_Ads =? WHERE ID =?");
                     $stmt->execute(array($name, $desc, $order, $visible, $comment, $ads, $id));
                
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
    
    echo "<h1 class= 'text-center Dashboard'> Delete Category </h1>";
        echo "<div class='container'>";
        
                
    $catid = isset($_GET['catid'])&&is_numeric($_GET['catid'])?intval($_GET['catid']):0;
        
    //select all data depend on this id  
        
    $check = CheckItem('ID', 'categories', $catid);        
        
    //execute data

if($check > 0)
{
    
    $stmt = $con->prepare("DELETE FROM categories WHERE ID = :zid");
    $stmt->bindparam(":zid", $catid);
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
    
   
      
     include $tpl . "footer.php";
    
}
else 
{
    header('Location:index.php');
    exit();
}

ob_end_flush();
?>
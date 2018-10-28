<?php 
ob_start();
session_start();
$pageTitle = 'Create New Item';

include_once "init.php"; 
if(isset($_SESSION['user'])){
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
     $formErrors = array();
     $name     = filter_var($_POST['img'], FILTER_SANITIZE_STRING);    
     $name     = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
     $desc      = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
     $price     = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
     $category  = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
     $member    =  filter_var($_SESSION['uid'], FILTER_SANITIZE_NUMBER_INT);
        
        
    if (empty($img)){
         $formErrors[] = 'Item Image Must Be Not Empty'; 
     }      
        
     if (strlen($name) < 4){
         $formErrors[] = 'Item Title Must Be At Least 4 Chars'; 
     }  
        
        if (strlen($desc) < 15){
         $formErrors[] = 'Item Description Must Be At Least 15 Chars'; 
     }    
        
        if (empty($price)){
         $formErrors[] = 'Item Price Must Be Not Empty'; 
     }    
        
         if (empty($category)){
         $formErrors[] = 'Item Category Must Be Not Empty'; 
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
                'zcat'          => $category,
                'zmember'       => $_SESSION['uid']
                ));
                    
                    if ($stmt){
                        $successMsg = 'Item Has Been Added And waiting For Approve';
                    }
            }
    }
?>

<div class="create-ad block">
 <div class="container">
     <div class="row">
         
        <div class="col-md-6 col-xs-12">
            <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <h3 class="text-center">ITEM DETAILS</h3>
                
                
            <div class="form-input form-group">
                <input type="text" name="img" class="form-control live-img" required="required" placeholder="Image URL"/>    
            </div>    
                
                    <!--start username field-->
            <div class="form-input form-group">
                <input pattern=".{4,}" title="This Filed Require At Least 4 Characters" type="text" name="name" class="form-control live-name" required="required" placeholder="Name"/>    
            </div>

                         <!--start description field-->
            <div class="form-input form-group">
                <input pattern=".{15,}" title="This Filed Require At Least 15 Characters" type="text" name="description" class="form-control live-description" required placeholder="Description"/>    
            </div>    

                         <!--start price field-->
            <div class="form-input form-group">
                <input type="text" name="price" class="form-control live-price" required="required" placeholder="Price"/>    
            </div>


            <div class="form-input form-group">
                <select class="form-control" name="category" required>
                    <option value="0">Choose Category</option>
                    <?php
                        $cats = getAllfrom('categories', 'ID');
                        foreach ($cats as $cat) {
                            echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
                        }
                    ?>
                </select>    
            </div>    


        <div class="form-input form-group">
            <input type="submit" value="Add Item" class="btn btn-success btn-block" />    
        </div>    
        </form>
    </div>
          
                    
            <div class="col-md-6 col-xs-12 prev">
                <h3 class="text-center">LIVE PREVIEW</h3>
                <div class="box item-box live-preview">
                 <span class="price-tag">$0</span>
                  <img class="img-responsive new" src="http://mafua.ufsc.br/wp-content/themes/mafua/img/no-image.jpg" alt="" />
                    <div class="caption">
                      <h3>Name</h3>
                        <p>Description</p>
                    </div>
                </div>
            </div>            
        </div>
         <?php
            if (! empty($formErrors)){
                foreach($formErrors as $error){
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }
            } 
    
               if(isset($successMsg)){
              echo '<div class="alert alert-wait alert-success text-center">' . $successMsg . '</div>';
          }
         ?>      
    </div>
  </div>
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


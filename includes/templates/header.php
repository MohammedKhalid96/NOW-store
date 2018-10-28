<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php getTitle() ?></title>
        <!-- mada=arabic, tajawal=arabic -->
        <link href="https://fonts.googleapis.com/css?family=Mada|Monoton|Open+Sans|Tajawal|Montserrat" rel="stylesheet">  
        <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@3.5.2/animate.min.css">
        <link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.css" />
        <link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
        <link rel="stylesheet" href="<?php echo $css; ?>front.css" />
        
    </head>
<body>
<div class="upper-bar">
    <div class="container text-right">
            <!-- Button trigger modal -->
            <button type="button" class="btn" data-toggle="modal" data-target="#myModal">
              CONTACT
            </button>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-left" id="myModalLabel">Send Message To Us</h4>
                  </div>
                  <div class="modal-body">
                    <section id="form">    
                        <form action="https://formspree.io/nowstore18@outlook.com" method="POST">
                            <input class="form-control form-group" type="text" name="name" placeholder="Your Name" required>
                            <input class="form-control form-group" type="email" name="_replyto" placeholder="Your Email" required>
                            <input class="form-control form-group" type="text" name="msg" placeholder="Your Message" required>
                            <input type="submit" class="form-control form-group btn-success" value="Send">
                        </form>
                    </section>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send</button>
                  </div>
                </div>
              </div>
            </div>
        
    <?php
        if(isset($_SESSION['user'])){ ?>
    
        <div class="btn-group my-info">
            <span class="btn btn-warning dropdown-toggle user" data-toggle="dropdown">
                <?php echo $_SESSION['user'] ?>
                <span class="caret"></span>
            </span>
                <ul class="dropdown-menu">
                    <li><a href="profile.php">My Profile</a></li>
                    <li><a href="newad.php">New Item</a></li>
                    <li><a href="myads.php">My Items</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            
        </div>
        
        <?php
            
            $userStatus = checkUserStatus($sessionUser);
            if ($userStatus == 1) {
                
            }
    }
        else{    
    ?>
        <a href="login.php">
          <span class="pull-right btn">Login/SignUp</span> 
        </a>
        <?php } ?>
    </div>
</div>
<nav class="navbar navbar-inverse">
  <div class="container">
      
    <!-- Brand and toggle get grouped for better mobile display -->
      
    <div class="navbar-header">   
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        <a  class="navbar-brand" href="index.php">NOW</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">
          <?php
            foreach (getCat() as $cat) {
                echo '<li>
                <a href="categories.php?pageid=' . $cat['ID'] . '">' . $cat['Name'] . '
                    </a>
                    </li>';
            }
        ?>
        </ul> 
    </div>
  </div>
</nav>
   

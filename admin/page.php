<?php

/* 
Categories => [Manage Edit Update Add Insert Delete Stats] 
condition ? True : False 
*/

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


//if the page is main page 

if ($do == 'Manage') 
{
    echo 'Welcome You Are In Manage Category page </br>';
    echo '<a href="?do=Add"> Add New Category + </a>';
} 

else if ($do == 'Add')
{
    echo "Welcome You Are In Add Category page";
}

else if ($do == 'Insert') 
{
    echo "Welcome You Are In Insert Category page";
}

else if ($do == 'Edit') 
{
    echo "Welcome You Are In Edit Category page";
}

else if ($do == 'Delete') 
{
    echo "Welcome You Are In Delete Category page";
}

else
{
    echo "ERROR There\'s No Page With This Name";
}
<?php

function lang($phrase){
    static $lang = array(
    'MESSAGE' => 'اهلا بك'
    );
    return $lang[$phrase];
}
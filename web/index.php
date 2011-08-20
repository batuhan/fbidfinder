<?php

require_once '../includes/silex.phar';
include_once '../includes/functions.php';

$app = new Silex\Application();

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->post('/get_id', function(Request $request) use($app) { 
    
    $id = $request->get('fbid');
    return $app->redirect('/'.$id);
    
}); 


$app->get('/{username}', function($username) use($app) { 
    
    $username = $app->escape($username);
    
    echo 'Your username is '.$app->escape($username); 
    if(get_fb_info($username)){
    print_r (get_fb_info($username));
    }else{
        echo 'you don\'t exist';
    }
    
}); 

$app->run();
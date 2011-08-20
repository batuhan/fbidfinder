<?php

require_once '../includes/silex.phar';
include_once '../includes/functions.php';

$app = new Silex\Application();

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->register(new Silex\Extension\TwigExtension(), array(
    'twig.path'       => '../views',
    'twig.class_path' => '../includes/Twig',
));

$app->get('/', function (Request $request) use ($app) {
    
    if($request->get('error')){
        $data = array(
            'error' => $request->get('error')      
        );
    }else{
        $data = NULL;
    }
    
    return $app['twig']->render('homepage.twig', $data);
    
});

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
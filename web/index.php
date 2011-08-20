<?php

require_once '../includes/silex.phar';
include_once '../includes/functions.php';

require_once '../includes/lib/twig/Autoloader.php';

$app = new Silex\Application();
$app['debug'] = true;

Twig_Autoloader::register();

$app->register(new Silex\Extension\TwigExtension(), array(
    'twig.path'       => '../views',
));

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


$app->get('/', function (Request $request) use ($app) {
    
    if($request->get('error')){
        $data = array(
            'error' => $request->get('error')      
        );
    }else{
        $data = array(
            'error' => NULL     
        );
    }
    
    return $app['twig']->render('homepage.twig', $data);
    
});

$app->post('/get_id', function(Request $request) use($app) { 
    
    $fbid = $request->get('fbid');
    
    if( ! isset($fbid) ){ return $app->redirect('/?error=empty'); }
    
    $id = $request->get('fbid');
    return $app->redirect('/'.$id);
    
}); 


$app->get('/{username}', function($username) use($app) { 
    
    $username = $app->escape($username);
    
    if(! get_fb_info($username) ){ return $app->redirect('/?error=notfound'); }
    
    $fb_info = get_fb_info($username);
    
    return $app['twig']->render('information.twig', $fb_info);
    
}); 

$app->run();
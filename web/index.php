<?php

require_once '../includes/silex.phar';
include_once '../includes/functions.php';

require_once '../includes/lib/Twig/Autoloader.php';

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
    
    $username = $request->get('username');
    
    if( ! isset($username) ){ return $app->redirect('/?error=empty'); }
    
    return $app->redirect('/'.$username);
    
}); 

$app->post('/who_first ', function(Request $request) use($app) { 
    
    $first = $request->get('first_person');
    $second = $request->get('second_person');
    
    if( ! isset($first) OR ! isset($second) ){ return $app->redirect('/?error=empty'); }
    
    return $app->redirect('/compare/'.$first.'/with/'.$second.'/');
    
}); 


$app->get('/{username}/and/{second_username}/', function($first_username, $second_username) use($app) { 
    
    $first_username = $app->escape($first_username);
    $second_username = $app->escape($second_username);
    
    $first_username_info = get_fb_info($first_username);

    $second_username_info = get_fb_info($second_username);

    if( ! $first_username_info OR  ! $second_username_info ){ return $app->redirect('/?error=notfound'); }
        
    return $app['twig']->render('compare.twig', $fb_info);
    
}); 

$app->get('/{username}', function($username) use($app) { 
    
    $username = $app->escape($username);
    
    $fb_info = get_fb_info($username);

    if( ! $fb_info ){ return $app->redirect('/?error=notfound'); }
        
    return $app['twig']->render('information.twig', $fb_info);
    
}); 

$app->run();
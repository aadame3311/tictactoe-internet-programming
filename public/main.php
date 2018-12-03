<?php
require '../vendor/autoload.php';
require '../generated-conf/config.php';

//////////////////////
// Slim Setup
//////////////////////

$settings = ['displayErrorDetails' => true];

$app = new \Slim\App(['settings' => $settings]);

$container = $app->getContainer();
$container['view'] = function($container) {
	$view = new \Slim\Views\Twig('../templates');
	
	$basePath = rtrim(str_ireplace('index.php', '', 
	$container->get('request')->getUri()->getBasePath()), '/');

	$view->addExtension(
	new Slim\Views\TwigExtension($container->get('router'), $basePath));
	
	return $view;
};

$app->get('/', function($request, $response, $args) {
	$this->view->render($response, 'home.html');
	return $response;
});
$app->post('/login', function($request, $response, $args) {
	$user_num = 0;
	$current_users = UserQuery::create()->find();
	echo $current_users;

	// detect which user joined first.
	if (count($current_users) == 0) $user_num = 1;
	else if (count($current_users) == 1) $user_num = 2;

	// set user.
	$new_user = new User();
	$new_user->setName($request->getParam('name'));
	$new_user->setUserNum($user_num);
	$new_user->save();

	
	return $response->withJson($current_users);
});

$app->run();
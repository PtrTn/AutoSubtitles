<?php
use Controllers\ApiController;
use Silex\Provider\ServiceControllerServiceProvider;

require(__DIR__ . '/../app/app.php');

/** @var $app Silex\Application */
$app->register(new ServiceControllerServiceProvider());

$app->post('/subtitle', ApiController::class . ':postSubtitleAction');
$app->run();

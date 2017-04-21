<?php
use Controllers\ApiController;
use Silex\Provider\ServiceControllerServiceProvider;

require(__DIR__ . '/../app/app.php');

/** @var $app Silex\Application */
$app->register(new ServiceControllerServiceProvider());
$app['api.controller'] = function () {
    return new ApiController();
};

$app->post('/subtitle', "api.controller:postSubtitleAction");
$app->run();

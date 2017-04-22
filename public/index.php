<?php
use Controllers\ApiController;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

require(__DIR__ . '/../app/app.php');

/** @var $app Silex\Application */
$app->register(new ServiceControllerServiceProvider());

// Only allow Json requests
$app->before(function (Request $request) {
    if ($request->headers->get('Content-Type') !== 'application/json') {
        throw new BadRequestHttpException('Expected "application/json" Content-Type');
    }
    $data = json_decode($request->getContent(), true);
    $request->request->replace(is_array($data) ? $data : []);
});
$app->post('/subtitle', ApiController::class . ':postSubtitleAction');
$app->run();

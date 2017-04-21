<?php
require(__DIR__ . '/../app/app.php');

$app->get('/', function () {
    return 'hello world';
});
$app->run();

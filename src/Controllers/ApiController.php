<?php

namespace Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController
{
    public function postSubtitleAction()
    {
        return new JsonResponse(['hello' => 'world']);
    }
}

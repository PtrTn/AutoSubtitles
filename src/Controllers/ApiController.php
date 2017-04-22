<?php

namespace Controllers;

use Dto\RequestParams;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ApiController
{
    public function postSubtitleAction(Request $request)
    {
        try {
            $requestParams = RequestParams::createFromRequest($request);
        } catch (\InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        return new JsonResponse(['hello' => 'world']);
    }
}

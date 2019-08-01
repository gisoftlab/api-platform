<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HealthcheckController
{
    /**
     * @Route(
     *     name="healthcheck",
     *     path="/ping",
     *     methods={"GET"},
     * )
     */
    public function __invoke(): object
    {
        return new JsonResponse('pong');
    }
}

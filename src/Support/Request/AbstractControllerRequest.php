<?php
declare(strict_types=1);

namespace App\Support\Request;

use Symfony\Component\HttpFoundation\RequestStack;

abstract class AbstractControllerRequest
{
    protected $request;

    public function __construct(RequestStack $requestStack) {
        $request = $requestStack->getCurrentRequest();
        $this->setRequest($request);
    }

    protected function setRequest($request) {
        $this->request = $request;
    }
}
<?php

namespace App\Routing\Traits;

trait RequestHelperTrait
{
    public function query(string $param, mixed $default = null)
    {
        return $this->queryParams[$param] ?? $default;
    }
}

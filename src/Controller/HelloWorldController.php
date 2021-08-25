<?php

namespace App\Controller;

use App\Routing\Request;

class HelloWorldController
{
    public function __invoke(Request $request)
    {
        return [
            'hello' => $request->query('hello', 'world')
        ];
    }
}

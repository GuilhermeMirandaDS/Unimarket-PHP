<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $agent = $this->request->getUserAgent();

        $data = [
            'isMobile' => $agent->isMobile(),
        ];

        return view('home', $data);
    }
}

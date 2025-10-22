<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $agent = $this->request->getUserAgent();

        $data = [
            'isMobile' => $agent->isMobile(),
        ];

        if (!session()->get('logged_in')){
            return redirect()->to(base_url('/enter'));
        }
        return view('home', $data);
    }
}

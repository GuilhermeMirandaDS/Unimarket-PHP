<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\ProductImages;

class Home extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')){
            return redirect()->to(base_url('/enter'));
        }

        $agent = $this->request->getUserAgent();

        $categoryId1 = getCategoryId(1);
        $categoryId2 = getCategoryId(2);

        $prodShow1 = [];
        $prodShow2 = [];
        $productModel = new Product();

        if ($categoryId1) {
            $prodShow1 = $productModel->where('categoria', $categoryId1)->findAll();
        }

        if ($categoryId2) {
            $prodShow2 = $productModel->where('categoria', $categoryId2)->findAll();
        }
        
        return view('home', [
            'isMobile' => $agent->isMobile(),
            'prodShow1' => $prodShow1,
            'prodShow2' => $prodShow2
        ]);
    }

    public function first()
    {
        if (!session()->get('logged_in')){
            return redirect()->to(base_url('/enter'));
        } else {
            return redirect()->to(base_url('/home'));
        }
    }
}

<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Avaliacao;

class Home extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')){
            return redirect()->to(base_url('/enter'));
        }

        $agent = $this->request->getUserAgent();

        $prodShow1 = [];
        $prodShow2 = [];

        $productModel = new Product();
        $userModel = new User();
        $categoryModel = new Category();

        $allCategories = $categoryModel->findAll();

        foreach ($allCategories as $key => $item) {
            if ($key == 0) {
                $categoryId1 = $item->id;
            } elseif ($key == 1) {
                $categoryId2 = $item->id;
            }
        }

        if ($categoryId1) {
            $prodShow1 = $productModel->where('categoria', $categoryId1)->findAll();
            foreach ($prodShow1 as $item){
                $item->vendedor = $userModel->where('ra', $item->vendedor)->first();
            }

            $category1 = $categoryModel->where('id', $categoryId1)->first();

        }

        if ($categoryId2) {
            $prodShow2 = $productModel->where('categoria', $categoryId2)->findAll();
            foreach ($prodShow2 as $item){
                $item->vendedor = $userModel->where('ra', $item->vendedor)->first();
            }

            $category2 = $categoryModel->where('id', $categoryId2)->first();
        }

        return view('home', [
            'isMobile' => $agent->isMobile(),
            'prodShow1' => $prodShow1,
            'category1' => $category1,
            'prodShow2' => $prodShow2,
            'category2' => $category2,
            'categories' => $allCategories
        ]);
    }

    public function myproducts($ra)
    {
        if (!session()->get('logged_in')){
            return redirect()->to(base_url('/enter'));
        }

        $agent = $this->request->getUserAgent();

        $categoryModel = new Category();

        $allCategories = $categoryModel->findAll();

        $productModel = new Product();
        $userModel = new User();

        $user = $userModel->where('ra', $ra)->first();
        $products = $productModel->where('vendedor', $ra)->findAll();

        $avalModel = new Avaliacao();
        $avaliacoes = $avalModel->where('user', $ra)->findAll();
        foreach ($avaliacoes as $key => $value) {
            $value->user = $userModel->where('ra', $value->user)->first();
        }
        $feedbackConfirmed = true;

        return view('myproducts', [
            'isMobile' => $agent->isMobile(),
            'user' => $user,
            'products' => $products,
            'categories' => $allCategories,
            'feedbackConfirmed' => $feedbackConfirmed,
            'avaliacoes' => $avaliacoes
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

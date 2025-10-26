<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\ProductImages;
use App\Models\Category;

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
        $userModel = new User();
        $imageModel = new ProductImages();
        $categoryModel = new Category();

        if ($categoryId1) {
            $prodShow1 = $productModel->where('categoria', $categoryId1)->findAll();
            foreach ($prodShow1 as $item){
                $item->vendedor = $userModel->where('ra', $item->vendedor)->first();
                $item->linked = $imageModel->where('product_id', $item->id)->findAll();
            }

            $category1 = $categoryModel->where('id', $categoryId1)->first();

        }

        if ($categoryId2) {
            $prodShow2 = $productModel->where('categoria', $categoryId2)->findAll();
            foreach ($prodShow2 as $item){
                $item->vendedor = $userModel->where('ra', $item->vendedor)->first();
                $item->linked = $imageModel->where('product_id', $item->id)->findAll();
            }

            $category2 = $categoryModel->where('id', $categoryId2)->first();
        }

        return view('home', [
            'isMobile' => $agent->isMobile(),
            'prodShow1' => $prodShow1,
            'category1' => $category1,
            'prodShow2' => $prodShow2,
            'category2' => $category2
        ]);
    }

    public function myproducts($ra)
    {
        if (!session()->get('logged_in')){
            return redirect()->to(base_url('/enter'));
        }

        $agent = $this->request->getUserAgent();


        $productModel = new Product();
        $userModel = new User();
        $imageModel = new ProductImages();

        $user = $userModel->where('ra', $ra)->first();
        $products = $productModel->where('vendedor', $ra)->findAll();

        return view('myproducts', [
            'isMobile' => $agent->isMobile(),
            'user' => $user,
            'products' => $products
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

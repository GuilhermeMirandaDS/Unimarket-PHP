<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Image;
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
        $imageModel = new Image();
        $categoryModel = new Category();

        $allCategories = $categoryModel->findAll();

        if ($categoryId1) {
            $prodShow1 = $productModel->where('categoria', $categoryId1)->findAll();
            foreach ($prodShow1 as $item){
                $item->vendedor = $userModel->where('ra', $item->vendedor)->first();
                foreach ($img as $item->images){
                    $item->imageList = $imageModel->where('path', $item->images->path)->first();
                }
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
        $imageModel = new Image();

        $user = $userModel->where('ra', $ra)->first();
        $products = $productModel->where('vendedor', $ra)->findAll();

        return view('myproducts', [
            'isMobile' => $agent->isMobile(),
            'user' => $user,
            'products' => $products,
            'categories' => $allCategories
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

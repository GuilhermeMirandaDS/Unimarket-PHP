<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\ProductImages;
use App\Models\Category;

class CategoryController extends BaseController
{
    public function search($id)
    {
        if (!session()->get('logged_in')){
            return redirect()->to(base_url('/enter'));
        }

        $agent = $this->request->getUserAgent();

        $catModel = new Category();
        $prodModel = new Product();
        $imgModel = new ProductImages();
        $userModel = new User();

        $allCategories = $catModel->findAll();

        $category = $catModel->where('id', $id)->first();

        $products = $prodModel->where('categoria', $category->id)->findAll();


        if (count($products) > 0) {
            foreach ($products as $item) {
                $item->image = $imgModel->where('product_id', $item->id)->findAll();
                $item->vendedor = $userModel->where('ra', $item->vendedor)->first();
            }

            return view('catalog', [
                'products' => $products,
                'query' => $category->nome,
                'categories' => $allCategories,
                'isMobile' => $agent->isMobile()
            ]);
        }

        
    }
}

?>
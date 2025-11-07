<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\ProductImages;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends BaseController
{

    public function productInfo($id)
    {
        $productModel = new Product();
        $product = $productModel->find($id);
        
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Produto não encontrado");
        }

        $productImageModel = new ProductImageModel();
        $image = $productImageModel->find($id);
        
        if (!empty($image)) {
            $image->image_base64 = 'data:image/jpeg;base64,' . base64_encode($image->image);
        } else {
            $image->image_base64 = base_url('/assets/img/no-image.png');
        }

        $userModel = new User();
        $user = $userModel->find($product->vendedor->id);

        if (!$user) {
            $user->name = 'Usuário não encontrado';
            $user->image = base_url('/assets/img/no-image.png');
        } else {
            $user->image_base64 = 'data:image/jpeg;base64,' . base64_encode($user->image);
        }

        // Renderiza o componente passando o produto
        return view('components/product', ['product' => $product, 'image' => $image, 'user' => $user]);
    }

    public function search()
    {
        $query = $this->request->getVar('query'); 

        $agent = $this->request->getUserAgent();
        $catModel = new Category();
        $userModel = new User();
        $categories = $catModel->findAll();

        if (!$query) {
            return view('notFind', [
                'categories' => $categories,
                'isMobile' => $agent->isMobile()
            ]);
        }

        $productModel = new Product();
        $imageModel = new ProductImages();

        $products = $productModel->like('nome', $query, 'both')->orLike('tags', $query, 'both')->findAll();

        if (count($products) > 0) {
            foreach ($products as $item) {
                $item->image = $imageModel->where('product_id', $item->id)->findAll();
                $item->vendedor =  $userModel->where('ra', $item->vendedor)->first();
            }

            return view('catalog', [
                'products' => $products,
                'query' => $query,
                'categories' => $categories,
                'isMobile' => $agent->isMobile()
            ]);

        } else {

            return view('notFind', [
                'categories' => $categories,
                'isMobile' => $agent->isMobile()
            ]);

        }
        
        
    }
}

?>
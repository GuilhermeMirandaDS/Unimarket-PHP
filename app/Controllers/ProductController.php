<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Curso;
use App\Models\Avaliacao;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends BaseController
{
    protected $Product;

    public function __construct(){
        $this->Product = new Product();
    }

    public function add(){

        $data = $this->request->getPost();

        if (!$data) {

            session()->setFlashdata('error', 'Erro ao adicionar produto!');
            
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Dados inválidos'
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        // --- INÍCIO DO TRATAMENTO DE IMAGENS ---

        $files = $this->request->getFiles();
        $imagePaths = [];
        
        $uploadDir = WRITEPATH . 'uploads/products/'; 
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $uploadedFiles = $files['images'] ?? [];

        // Se for um único arquivo, $uploadedFiles pode ser um objeto, então garantimos que seja um array
        if (!is_array($uploadedFiles)) {
            $uploadedFiles = [$uploadedFiles];
        }

        if (!empty($uploadedFiles)) {
            $imageLib = new \App\Libraries\ImageLibrary(); 

            foreach ($uploadedFiles as $file) {
                
                if ($file->getError() !== 0) {
                    // Se houver erro de upload do PHP (tamanho, tipo, etc.)
                    // Você pode logar o erro aqui ou retornar uma mensagem
                    continue;
                }
                
                if ($file->isValid() && ! $file->hasMoved()) {
                    
                    $newName = $file->getRandomName();
                    
                    if ($file->move($uploadDir, $newName)) {
                        
                        $imageLib->insertImage($newName, $uploadDir); 

                        $imagePaths[] = $newName; 
                    }
                }
            }
        }
            
        // --- FIM DO TRATAMENTO DE IMAGENS ---

        $data['images'] = $imagePaths; 
        
        $this->Product->insert($data);

        session()->setFlashdata('success', 'Produto adicionado com sucesso!');

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Produto adicionado com sucesso!',
            'redirect_url' => base_url('my-products/' . session()->get('ra')) // Envia a URL para o JS
        ])->setStatusCode(ResponseInterface::HTTP_CREATED);
    }

    public function productInfo($id){

        if (!session()->get('logged_in')){
            return redirect()->to(base_url('/enter'));
        }

        $productModel = new Product();
        $product = $productModel->where('id', $id)->first();
        
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Produto não encontrado");
        }

        $userModel = new User();
        $user = $userModel->where('ra', $product->vendedor)->first();

        $cursoModel = new Curso;
        $user->curso = $cursoModel->where('id', $user->curso)->first();

        if (!$user) {
            $user->name = 'Usuário não encontrado';
            $user->images = base_url('/assets/img/no-image.png');
        }

        $avalModel = new Avaliacao();
        $feedbackConfirmed = $avalModel->where('user', session()->get('ra'))->where('product', $product->id)->first();
        $avaliacoes = $avalModel->where('product', $product->id)->findAll();

        foreach ($avaliacoes as $key => $item) {
            $item->user = $userModel->where('ra', $item->user)->first();
        }

        $categoryModel = new Category();
        $allCategories = $categoryModel->findAll();
        $agent = $this->request->getUserAgent();

        $productTags = explode(" ", $product->tags);

        $productTags = array_filter($productTags);

        $query = $productModel->where('id !=', $product->id);

        $query = $query->groupStart();
        $firstTag = true;
        
        foreach ($productTags as $tag) {
            // Usamos orLike() para todas as tags
            // O primeiro orLike() se comporta como um Like() normal dentro do groupStart()
            $query = $query->orLike('tags', $tag, 'both');
        }

        $query = $query->groupEnd();

        $relatedProducts = $query->limit(4)->findAll();

        // Renderiza o componente passando o produto
        return view('product', [
            'product' => $product,
            'user' => $user,
            'feedbackConfirmed' => $feedbackConfirmed,
            'avaliacoes' => $avaliacoes,
            'categories' => $allCategories,
            'isMobile' => $agent->isMobile(),
            'related' => $relatedProducts
        ]);
    }

    public function avaliar()
    {
        $data = $this->request->getPost();

        if (!$data) {

            session()->setFlashdata('error', 'Erro ao adicionar avaliação!');
            
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Dados inválidos'
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $prodId = $data['product'];

        $avalModel = new Avaliacao();

        $avalModel->insert($data);

        session()->setFlashdata('success', 'Avaliação adicionada com sucesso!');

        return redirect()->to(base_url('/products/' . $prodId));
    }

    public function search(){

        if (!session()->get('logged_in')){
            return redirect()->to(base_url('/enter'));
        }

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

        $category = $catModel->like('nome', $query, 'both')->first();

        $products = $productModel->like('nome', $query, 'both')->orLike('tags', $query, 'both');

        if ($category) {
            $products = $products->orLike('categoria', $category->id, 'both')->findAll();
        } else {
            $products = $products->findAll();
        }
        

        if (count($products) > 0) {
            foreach ($products as $item) {
                $item->vendedor =  $userModel->where('ra', $item->vendedor)->first();
                $cursoModel = new Curso;
                $item->vendedor->curso = $cursoModel->where('id', $item->vendedor->curso)->first();
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

    public function delete($id){
        $productModel = new Product();

        if (!$id) {
            session()->setFlashdata('error', 'Erro ao adicionado produto!');
            
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Dados inválidos'
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $productModel->delete(['id' => $id]);

        $avalModel = new Avaliacao();
        $avalModel->where('product', $id)->delete();

        session()->setFlashdata('success', 'Produto removido com sucesso!');

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Produto removido com sucesso!',
            'redirect_url' => base_url('my-products/' . session()->get('ra'))
        ])->setStatusCode(ResponseInterface::HTTP_CREATED);
    }
}

?>
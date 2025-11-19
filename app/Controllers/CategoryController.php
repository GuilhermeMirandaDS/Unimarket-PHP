<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use CodeIgniter\HTTP\ResponseInterface;

class CategoryController extends BaseController
{
    protected $Category;

    public function __construct(){
        $this->Category = new Category();
    }

    public function get($id){
        $prodModel = new Product();
        $userModel = new User();
        $catModel = new Category();
        $categories = $catModel->findAll();
        $agent = $this->request->getUserAgent();

        $query = $catModel->where('id', $id)->first();

        if (!$query) {
            return view('notFind', [
                'categories' => $categories,
                'isMobile' => $agent->isMobile()
            ]);
        }

        $products = $prodModel->where('categoria', $id)->findAll();

        if (count($products) > 0) {
            foreach ($products as $item) {
                $item->vendedor =  $userModel->where('ra', $item->vendedor)->first();
            }

            return view('catalog', [
                'products' => $products,
                'query' => $query->nome,
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

    public function add(){

        $data = $this->request->getPost();

        if (!$data) {

            session()->setFlashdata('error', 'Erro ao adicionar categoria!');
            
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Dados inválidos'
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        // --- INÍCIO DO TRATAMENTO DE IMAGENS ---

        $files = $this->request->getFiles();
        $imagePaths = [];
        
        $uploadDir = WRITEPATH . 'uploads/categories/'; 
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $uploadedFiles = $files['image'];

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

        $data['image'] = $imagePaths; 
        
        $this->Category->insert($data);

        session()->setFlashdata('success', 'Categoria adicionada com sucesso!');

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Categoria adicionada com sucesso!'
        ])->setStatusCode(ResponseInterface::HTTP_CREATED);
    }
}

?>
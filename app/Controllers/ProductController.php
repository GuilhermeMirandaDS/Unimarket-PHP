<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\ProductImages;
use App\Libraries\ImageLibrary;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends BaseController
{
    protected $Product;

    public function __construct()
    {
        // Instancia o Model para uso em todas as funções do Controller
        $this->Product = new Product();
    }

    public function add(){

        // 1. Pega todos os dados enviados via POST
        $data = $this->request->getPost();

        // 2. Validação básica (como você fez)
        if (!$data) {
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

        // Verifica se há arquivos de imagem e processa
        if (isset($files['images'])) {
            $imageLib = new ImageLibrary();

            foreach ($files['images'] as $file) {
                if ($file->isValid() && ! $file->hasMoved()) {
                    // Move o arquivo original
                    $newName = $file->getRandomName();
                    $file->move($uploadPath, $newName);

                    // Processa e redimensiona (usando sua ImageLibrary)
                    $imageLib->insertImage($newName, $uploadPath);

                    // Armazena o caminho da imagem principal (ou o nome)
                    $imagePaths[] = $newName; 
                }
            }
        }

        // 3. Injeta o array de caminhos de imagem (convertido para JSON pelo Model)
        // Se não houver imagens, $imagePaths será um array vazio, que o Model
        // converterá para '[]' no banco (ou você pode forçar null se preferir)
        $data['images'] = $imagePaths; 
        
        // --- FIM DO TRATAMENTO DE IMAGENS ---

        // 3. Insere os dados no banco de dados
        $this->Product->insert($data);

        // 4. Retorno de sucesso (ajustado para um retorno JSON de sucesso)
        return redirect()->to(base_url('my-products/' . session()->get('ra')));

    }

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
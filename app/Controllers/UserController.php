<?php
namespace App\Controllers;

use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    protected $User;

    public function __construct()
    {
        $this->User = new User();
    }

    public function enter()
    {
        if (session()->get('logged_in')){
            return redirect()->to(base_url('/home'));
        }

        return view('register');
    }

    public function index()
    {
        $users = $this->User->findAll();

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $users
        ]);
    }

    public function login()
    {
        $ra = $this->request->getPost('ra');
        $password = $this->request->getPost('password');

        $user = $this->User->where('ra', $ra)->first();

        if ($user && password_verify($password, $user->password)){

            session()->set([
                'ra' => $user->ra,
                'name' => $user->name,
                'image' => $user->images,
                'tag' => $user->tag,
                'logged_in' => true,
            ]);

            return redirect()->to(base_url('/home'));

        } else {
            return redirect()->to(base_url('/enter'))->with('error', 'RA ou senha inválidos');
        }

        
    }

    public function logOut()
    {
        session()->remove('logged_in');

        return redirect()->to(base_url('/enter'));
    }

    public function register()
    {
        $data = $this->request->getPost();

        // Exemplo básico de validação
        if (!$data) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Dados inválidos'
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        // --- INÍCIO DO TRATAMENTO DE IMAGENS ---

        $files = $this->request->getFiles();
        $imagePaths = [];
        
        $uploadDir = WRITEPATH . 'uploads/users/'; 
        
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

        $data['images'] = $imagePaths;
            
        // --- FIM DO TRATAMENTO DE IMAGENS ---

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $this->User->insert($data);

        return redirect()->to('/enter')->with('success', 'Usuário criado com sucesso!');
    }

    public function show($ra = null)
    {
        $user = $this->User->find($ra);

        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Usuário não encontrado.'
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function delete($ra = null)
    {
        if (!$this->User->find($ra)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Usuário não encontrado.'
            ])->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        $this->User->delete($ra);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Usuário excluído com sucesso.'
        ]);
    }
}
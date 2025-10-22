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

        log_message('debug', 'RA: '.$ra);
        log_message('debug', 'Password: '.$password);

        $user = $this->User->where('ra', $ra)->first();

        if ($user && password_verify($password, $user->password)){

            log_message('error', 'Senha inválida para RA: '.$ra);

            session()->set([
                'ra' => $user->ra,
                'user_name' => $user->name,
                'logged_in' => true
            ]);

            return redirect()->to(base_url('/home'));

        } else {
            log_message('error', 'Usuário não encontrado para RA: '.$ra);
            return redirect()->back()->with('error', 'RA ou senha inválidos');
        }

        
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

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $this->User->insert($data);

        return redirect()->to('/home')->with('success', 'Usuário criado com sucesso!');
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
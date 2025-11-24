<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Category;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class EventController extends BaseController
{
    public function getAll(){
        if (!session()->get('logged_in')){
            return redirect()->to(base_url('/enter'));
        }

        $eventModel = new Event();

        $eventos = $eventModel->findAll();

        $catModel = new Category();
        $categories = $catModel->findAll();

        $proximos = [];

        $eventoDestaque = [];

        foreach ($eventos as $key => $value) {

            if($key == 0){
                $eventoDestaque[] = $value;
            }

            if (is_less_than_15_days($value->data) == true) {
                $proximos[] = $value;
            }
        }

        $agent = $this->request->getUserAgent();

        return view('eventos', [
            'eventoDestaque' => $eventoDestaque,
            'eventos' => $eventos,
            'proximos' => $proximos,
            'categories' => $categories,
            'isMobile' => $agent->isMobile()
        ]);
    }

    public function add(){
        $data = $this->request->getPost();

        if (!$data) {

            session()->setFlashdata('error', 'Erro ao adicionar evento!');
            
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Dados inválidos'
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $eventModel = new Event();

        $files = $this->request->getFiles();
        $imagePaths = [];
        
        $uploadDir = WRITEPATH . 'uploads/events/'; 
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $uploadedFiles = $files['imageEvent'] ?? [];

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

        // ----------------------------------------

        $cardPaths = [];

        $uploadedCards = $files['imageCard'] ?? [];

        if (!is_array($uploadedCards)) {
            $uploadedCards = [$uploadedCards];
        }

        if (!empty($uploadedCards)) {
            $imageLib = new \App\Libraries\ImageLibrary(); 

            foreach ($uploadedCards as $file) {
                
                if ($file->getError() !== 0) {
                    // Se houver erro de upload do PHP (tamanho, tipo, etc.)
                    // Você pode logar o erro aqui ou retornar uma mensagem
                    continue;
                }
                
                if ($file->isValid() && ! $file->hasMoved()) {
                    
                    $newName = $file->getRandomName();
                    
                    if ($file->move($uploadDir, $newName)) {
                        
                        $imageLib->insertImage($newName, $uploadDir); 

                        $cardPaths[] = $newName; 
                    }
                }
            }
        }

        $data['imageCard'] = $cardPaths; 
        
        $eventModel->insert($data);

        session()->setFlashdata('success', 'Evento adicionado com sucesso!');

        return redirect()->to(base_url('users/admin'));
    }

    public function eventInfo($id){
        if (!session()->get('logged_in')){
            return redirect()->to(base_url('/enter'));
        }

        $eventModel = new Event();

        $eventos = $eventModel->findAll();

        $catModel = new Category();
        $categories = $catModel->findAll();

        $proximos = [];

        $evento = 0;

        foreach ($eventos as $key => $value) {

            if ($value->id == $id){
                $evento = $value;
            } else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Evento não encontrado");
            }

            if (is_less_than_15_days($value->data) == true) {
                $proximos[] = $value;
            }
        }

        $agent = $this->request->getUserAgent();

        return view('evento', [
            'evento' => $evento,
            'proximos' => $proximos,
            'categories' => $categories,
            'isMobile' => $agent->isMobile()
        ]);
    }
}

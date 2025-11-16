<?php

namespace App\Libraries;
use CodeIgniter\Images\Exceptions\ImageException;

class ImageLibrary{

    private $sSize = ['64', '128', '255'];

    // public function insertImage($name, $path, $sizes = [], $origin = false){

    //     $image = \Config\Services::image();
    //     $defaultSize = 600;

    //     if(!$origin){

    //         if(!count($sizes)){
    //             $sizes = $this->sSize;
    //         }

    //         foreach($sizes as $size){
        
    //             list($nome, $ext) = explode('.', $name);

    //             $file = "{$nome}-{$size}.webp";

    //             if(!file_exists($path.'/'.$file)){
                    
    //                 try{
    //                     $image->withFile($path.''.$name)
    //                     ->resize($size, $size, true)
    //                     ->convert(IMAGETYPE_WEBP)
    //                     ->save($path.'/'.$file, 60);

    //                 }catch(\CodeIgniter\Images\Exceptions\ImageException $e){
    //                     return false;
    //                 }
    //             }
    //         }

    //         /* DEFAULT 600 */
    //         try{

    //             list($nome_, $ext_) = explode('.', $name);

    //             $image->withFile($path.'/'.$name)
    //             ->resize($defaultSize, $defaultSize, true)
    //             ->convert(IMAGETYPE_WEBP)
    //             ->save($path.'/'.$nome_.'.webp');

    //         }catch(\CodeIgniter\Images\Exceptions\ImageException $e){
    //             return false;
    //         }

    //     }else{

    //         try{

    //             list($nome_, $ext_) = explode('.', $name);

    //             if (strtolower($ext_) !== 'gif') {
    //                 $image->withFile($path.'/'.$name)
    //                   ->convert(IMAGETYPE_WEBP)
    //                   ->save($path.'/'.$nome_.'.webp');
                      
    //                 return $nome_.'.webp';
    //             } else {
    //                 $image->withFile($path.'/'.$name)
    //                 ->save($path.'/'.$name);
                    
    //               return $name;
    //             }

    //         }catch(\CodeIgniter\Images\Exceptions\ImageException $e){
    //             return false;
    //         }
    //     }

    //     return true;
    // }

    public function insertImage($name, $path, $sizes = [], $origin = false)
    {
        $imagePath = $path . $name; // Caminho completo do arquivo original
        $fileName = pathinfo($name, PATHINFO_FILENAME); // Nome do arquivo sem extensão
        
        // Definições de tamanhos (se você não as tiver na classe)
        $sizes = $sizes ?: [64, 128, 255]; 
        $defaultSize = 600;

        try {
            $image = \Config\Services::image();

            // 1. Processamento da Imagem Padrão (600px)
            $image
                ->withFile($imagePath)
                ->resize($defaultSize, $defaultSize, true, 'width')
                ->convert(IMAGETYPE_WEBP) // Converte para WebP
                ->save($path . $fileName . '-' . $defaultSize . '.webp', 80); // Salva a versão padrão

            // 2. Processamento das Imagens Menores
            foreach ($sizes as $size) {
                $image
                    ->withFile($imagePath) // Recarrega o arquivo original
                    ->resize($size, $size, true, 'width')
                    ->convert(IMAGETYPE_WEBP)
                    ->save($path . $fileName . '-' . $size . '.webp', 80);
            }

        } catch (ImageException $e) {
            // Se houver um erro na manipulação da imagem (ex: falta de memória, GD/Imagick não funciona)
            dd('ERRO CRÍTICO NA MANIPULAÇÃO DE IMAGEM: ' . $e->getMessage());
        } catch (\Throwable $e) {
            // Outros erros
            dd('ERRO DESCONHECIDO NA IMAGELIBRARY: ' . $e->getMessage());
        }
        
        // Se tudo correr bem, o método retorna sem erro
        return true;
    }

    public function getImagens($name, $path, $sizes = []){

        if(!count($sizes)){
            $sizes = $this->sSize;
        }

        $images = [];

        list($nome, $ext) = explode('.', $name);

        foreach($sizes as $size){
            $images["$size"] = $path."{$nome}-{$size}.{$ext}"; 
        }
        
        $images['default'] = $path.$name;
        $images['name'] = $name;


        return $images;

    }

    public function deleteImagens($name, $path, $sizes = []){
        if(!count($sizes)){            
            $sizes = $this->sSize;
        }

        list($nome, $ext) = explode('.', $name);

        foreach($sizes as $size){
            if (file_exists( $path."{$nome}-{$size}.{$ext}")) {
                unlink( $path."{$nome}-{$size}.{$ext}");
            }
        }

        if (file_exists( $path.$name)) {
            unlink( $path.$name);
        }

        return true;
    }
}
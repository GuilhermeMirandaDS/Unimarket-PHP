<?php

namespace App\Libraries;

class ImageLibrary{

    private $sSize = ['64', '128', '255'];

    public function insertImage($name, $path, $sizes = [], $origin = false){

        $image = \Config\Services::image();
        $defaultSize = 600;

        if(!$origin){

            if(!count($sizes)){
                $sizes = $this->sSize;
            }

            foreach($sizes as $size){
        
                list($nome, $ext) = explode('.', $name);

                $file = "{$nome}-{$size}.webp";

                if(!file_exists($path.'/'.$file)){
                    
                    try{
                        $image->withFile($path.''.$name)
                        ->resize($size, $size, true)
                        ->convert(IMAGETYPE_WEBP)
                        ->save($path.'/'.$file, 60);

                    }catch(\CodeIgniter\Images\Exceptions\ImageException $e){
                        return false;
                    }
                }
            }

            /* DEFAULT 600 */
            try{

                list($nome_, $ext_) = explode('.', $name);

                $image->withFile($path.'/'.$name)
                ->resize($defaultSize, $defaultSize, true)
                ->convert(IMAGETYPE_WEBP)
                ->save($path.'/'.$nome_.'.webp');

            }catch(\CodeIgniter\Images\Exceptions\ImageException $e){
                return false;
            }

        }else{

            try{

                list($nome_, $ext_) = explode('.', $name);

                if (strtolower($ext_) !== 'gif') {
                    $image->withFile($path.'/'.$name)
                      ->convert(IMAGETYPE_WEBP)
                      ->save($path.'/'.$nome_.'.webp');
                      
                    return $nome_.'.webp';
                } else {
                    $image->withFile($path.'/'.$name)
                    ->save($path.'/'.$name);
                    
                  return $name;
                }

            }catch(\CodeIgniter\Images\Exceptions\ImageException $e){
                return false;
            }
        }

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
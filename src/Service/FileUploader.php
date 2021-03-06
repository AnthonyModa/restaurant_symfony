<?php
/**
 * Created by PhpStorm.
 * User: anthonymodafferi
 * Date: 10/01/19
 * Time: 09:41
 */

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        try{
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e){
            //Gérer l'exception si qqchose se passe mal durant l'upload
        }
        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}

<?php

namespace App\Controller\Upload;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UploadImageService extends AbstractController
{
    public function singleImage($data)
    {
        // suppression ancien avatar
        //@unlink($this->getParameter('upload_directory') . '/' . $name . '/' . $this->user->getAvatar());

        // Nouveau nom
        //dd($file->getData()->getClientOriginalName());
        $name = $data->getName();
        dd($name);
        $fileName = $name . '.' . $data->guessExtension();
        // Déplacement 
        $data->move($this->getParameter('upload_directory') . '/' . $name, $fileName);

        return $fileName;
    }

    public function multipleImage()
    {
    }
}

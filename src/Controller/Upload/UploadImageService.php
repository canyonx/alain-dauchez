<?php

namespace App\Controller\Upload;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UploadImageService extends AbstractController
{
    public function singleImage($image, $name)
    {
        $file = $image;
        // nouveau nom unique
        $fileName = uniqid() . '.' . $file->guessExtension();
        // deplacement dans public/img/ $name / $fileName
        $file->move($this->getParameter('upload_directory') . $name . '/', $fileName);

        return $fileName;
    }

    public function multipleImage()
    {
    }
}

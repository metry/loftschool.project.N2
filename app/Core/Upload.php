<?php

namespace App\Core;

class Upload
{
    const RANDOM_LENGTH = 10;

    private $destination;
    private $maxSize = '1048576'; // bytes (1048576 bytes = 1 meg)
    private $allowedExtensions = array('jpeg','png','jpg');
    private $allowedMimeTypes = array('image/jpeg','image/png','image/gif');
    public $error = '';

    public function setDestination($newDestination)
    {
        $this->destination = $newDestination;
    }
    public function setMaxSize($newSize)
    {
        $this->maxSize = $newSize;
    }
    public function setAllowedExtensions($newExtensions)
    {
        $this->allowedExtensions = (is_array($newExtensions)) ? $newExtensions : [$newExtensions];
    }
    public function setAllowedMimeTypes($newMimeTypes)
    {
        $this->allowedMimeTypes = (is_array($newMimeTypes)) ? $newMimeTypes : [$newMimeTypes];
    }

    public function upload($file)
    {
        $this->validate($file);
        $result = [];

        if ($this->error) {
            $result['error'] = $this->error;
            $result['status'] = false;
            return $result;
        }

        $newFileName = bin2hex(random_bytes(self::RANDOM_LENGTH)) . '.' . $this->getExtension($file);
        $result['filename'] = $newFileName;
        if (move_uploaded_file($file['tmp_name'], $this->destination . '/' . $newFileName)) {
            $result['status'] = true;
        }
        return $result;
    }

    public function validate($file)
    {
        //check allowed extensions
        if (!in_array($this->getExtension($file), $this->allowedExtensions)) {
            $this->error = 'Extension is not allowed. ';
        }

        //check allowed Mime type
        if (!in_array($this->getMimeType($file), $this->allowedMimeTypes)) {
            $this->error .= 'Mime type is not allowed. ';
        }
        //check file size
        if ($file['size'] > $this->maxSize) {
            $this->error .= 'Max File Size Exceeded. Limit: '.$this->maxSize.' bytes. ';
        }
    }

    private function getExtension($file)
    {
        $pathinfo = pathinfo($file['name']);
        return mb_strtolower($pathinfo['extension']);
    }

    private function getMimeType($file)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $ext = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        return $ext;
    }
}

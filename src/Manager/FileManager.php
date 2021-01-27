<?php

namespace App\Manager;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileManager
{
    /**
     * @var string $targetDirectory
     */
    private $targetDirectory;

    /**
     * @var SluggerInterface $slugger
     */
    private $slugger;

    /**
     * @param SluggerInterface $slugger
     */
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    /**
     * @param UploadedFile $file
     * 
     * @return string
     */
    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
        $file->move($this->targetDirectory, $fileName);
  
        return $fileName;
    }

    /**
     * @param string $targetDirectory
     * 
     * @return self
     */
    public function setTargetDirectory($targetDirectory): self
    {
        $this->targetDirectory = $targetDirectory;

        return $this;
    }
}

<?php

namespace Timongo\Creatures;

use League\Flysystem\File;
use League\Flysystem\FileSystem;
use League\Flysystem\Adapter\Local;

class FileCreaturesRepository {

    protected $path;

    protected $filesystem;

    public function __construct($path = null)
    {
        $this->path = $path ?: realpath(__DIR__ . '/../data');

        $this->filesystem = new FileSystem( new Local($this->path) );
    }

    public function read($file)
    {
        return $this->filesystem->has($file) ?
            $this->filesystem->read($file) :
            false;
    }

    public function fetchAll()
    {
        $contents = [];

        foreach ($this->filesystem->listContents() as $file) {
            $content = $this->read($file['path']);

            if ($content) {
                array_push($contents, json_decode($content));
            }
        }

        return $contents;
    }

    public function fetchFiles($files)
    {
        $contents = [];

        foreach ($files as $file) {
            $content = $this->read($file);

            if ($content) {
                array_push($contents, json_decode($content));
            }
        }

        return $contents;
    }

    public function checkImages()
    {
        $imagesPath = realpath(__DIR__ . '/../img');

        $imageFileSystem = new FileSystem( new Local($imagesPath) );

        foreach($this->fetchAll() as $creature) {
            if (! $imageFileSystem->has($creature->image)) {
                die($creature->name . ' not found.');
            }
        }

        echo 'Images ok';
    }
}
<?php

namespace App\Helpers;

use App\Exceptions\AppException;
use CodeIgniter\HTTP\Exceptions\HTTPException;

class FileJsonObject
{

    /**
     * Undocumented variable
     *
     * @var array
     */
    protected $files = [];

    public function __construct($files = [])
    {
        $this->files = $files ?? [];
    }

    /**
     * Move file
     *
     * @param \CodeIgniter\HTTP\Files\UploadedFile $file
     * @return void
     */
    public function move($file, $directory = "uploads")
    {
        try {
            $filename = $file->getRandomName();
            $file->move(WRITEPATH . $directory, $filename);

            if (!$file->hasMoved())
                throw new AppException("Failed to upload image");

            $this->files[] = (object) [
                'directory' => $directory,
                'filename' => $filename,
                'extension' => $file->getClientExtension(),
                'mimetype' => $file->getClientMimeType(),
            ];
        } catch (HTTPException $e) {
            throw new AppException($e->getMessage());
        }
    }

    /**
     * Remove image from json
     *
     * @param object $file
     * @return void
     */
    public function remove($file)
    {
        $searchIndex = array_search($file, $this->files);

        if ($searchIndex != -1) {
            unset($this->files[$searchIndex]);

            if (file_exists(WRITEPATH . DIRECTORY_SEPARATOR . $file->directory . DIRECTORY_SEPARATOR . $file->filename))
                unlink(WRITEPATH . DIRECTORY_SEPARATOR . $file->directory . DIRECTORY_SEPARATOR . $file->filename);
        }
    }

    public function removeAll()
    {
        foreach ($this->files as $file) {
            $this->remove($file);
        }
    }

    public function files($index = null)
    {
        if (!is_null($index)) return $this->files[$index];

        return array_values($this->files);
    }

    public function first()
    {
        return array_shift($this->files);
    }

    public function toJson($index = null)
    {
        if (!is_null($index)) return json_encode($this->files($index) ?? null);

        return json_encode($this->files());
    }

    public function firstJson()
    {
        return json_encode($this->first());
    }
}

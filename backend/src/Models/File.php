<?php 
declare(strict_types=1);

namespace Source\Models;

class File
{
    private string $name;
    private string $path;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void {
        $this->path = $path;
    }
}

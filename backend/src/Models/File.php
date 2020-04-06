<?php declare(strict_types=1);


namespace Source\Models;

/**
 * Class File
 *
 * @package Source\Models
 */
class File
{
    /** @var string $name*/
    private string $name;

    /** @var string $path*/
    private string $path;

    /**
     * @return string
     */
    public function getName()
    : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    : void {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPath()
    : string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path)
    : void {
        $this->path = $path;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 12.03.19
 * Time: 16:04
 */

namespace Foundation\Generator\Generators;


use Illuminate\Filesystem\Filesystem;
use Nwidart\Modules\Exceptions\FileAlreadyExistException;

class FileGenerator
{
    /**
     * The path wil be used.
     *
     * @var string
     */
    protected $path;

    /**
     * The contens will be used.
     *
     * @var string
     */
    protected $contents;

    /**
     * The laravel filesystem or null.
     *
     * @var \Illuminate\Filesystem\Filesystem|null
     */
    protected $filesystem;

    /**
     * The constructor.
     *
     * @param $path
     * @param $contents
     * @param null $filesystem
     */
    public function __construct($path, $contents, $filesystem = null)
    {
        $this->path = $path;
        $this->contents = $contents;
        $this->filesystem = $filesystem ?: new Filesystem();
    }

    /**
     * Get contents.
     *
     * @return mixed
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * Set contents.
     *
     * @param mixed $contents
     *
     * @return $this
     */
    public function setContents($contents)
    {
        $this->contents = $contents;

        return $this;
    }

    /**
     * Get filesystem.
     *
     * @return mixed
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * Set filesystem.
     *
     * @param Filesystem $filesystem
     *
     * @return $this
     */
    public function setFilesystem(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;

        return $this;
    }

    /**
     * Get path.
     *
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set path.
     *
     * @param mixed $path
     *
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Generate the file.
     */
    public function generate()
    {
        if (!$this->filesystem->isDirectory($dir = dirname($this->getPath()))) {
            $this->filesystem->makeDirectory($dir, 0777, true);
        }
        if (!$this->filesystem->exists($path = $this->getPath())) {
            if (!$this->filesystem->exists($gitkeepPath = dirname($path).'/.gitkeep')) {
                $this->generateGitKeep($gitkeepPath);
            }
            return $this->filesystem->put($path, $this->getContents());
        }

        throw new FileAlreadyExistException('File already exists!');
    }

    /**
     * Generate git keep to the specified path.
     *
     * @param string $path
     */
    public function generateGitKeep($path)
    {
        $this->filesystem->put($path, '');
    }
}

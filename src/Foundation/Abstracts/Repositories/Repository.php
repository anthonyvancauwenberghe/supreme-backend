<?php


namespace Foundation\Abstracts\Repositories;

use Larapie\Repository\Eloquent\BaseRepository;
use Larapie\Repository\Exceptions\RepositoryException;

class Repository extends BaseRepository
{
    protected $eloquent;

    public function model()
    {
        if (!isset($this->eloquent) || !is_string($this->eloquent))
            throw new RepositoryException("Model not defined on " . static::class);
        return $this->eloquent;
    }
}
<?php


namespace Foundation\Abstracts\Repositories;

use Larapie\Repository\Eloquent\BaseRepository;
use Larapie\Repository\Events\RepositoryEntityUpdated;
use Larapie\Repository\Exceptions\RepositoryException;
use Modules\User\Entities\User;

class Repository extends BaseRepository
{
    protected $eloquent;

    public function model()
    {
        if (!isset($this->eloquent) || !is_string($this->eloquent))
            throw new RepositoryException("Model not defined on " . static::class);
        return $this->eloquent;
    }

    /**
     * Delete multiple entities by given criteria.
     *
     * @param array $where
     *
     * @return int
     * @throws RepositoryException
     */
    public function updateWhere(array $where, array $data)
    {
        $keys = $this->findWhere($where)->modelKeys();
        $this->model()::whereIn($this->model->getKeyName(), $keys)->update($data);
        $models = $this->model()::whereIn($this->model->getKeyName(), $keys)->get();
        foreach ($models as $model) {
            event(new RepositoryEntityUpdated($this, $model));
        }

        $this->resetModel();

        return $models;
    }
}
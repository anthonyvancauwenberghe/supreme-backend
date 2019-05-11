<?php


namespace Foundation\Abstracts\Dtos;

use Illuminate\Http\Request;
use Larapie\DataTransferObject\DataTransferObject;
use Larapie\DataTransferObject\Exceptions\PropertyNotFoundDtoException;
use Larapie\DataTransferObject\Exceptions\UnknownPropertiesDtoException;

class Dto extends DataTransferObject
{
    public function __construct($parameters)
    {
        if ($parameters instanceof Request)
            $parameters = $parameters->toArray();
        parent::__construct($parameters);
    }

    /**
     * @param string $model
     * @return static
     */
    public static function fromFactory(string $model, array $additionalData = [])
    {
        return new static(factory($model)->raw([]));
    }

    public static function make(array $data)
    {
        return new static($data);
    }

    public function exists(string $property){
        if(array_key_exists($property, $this->with))
            return true;

        if(!$this->propertyExists($property))
            return false;

        return $this->properties[$property]->isInitialized();
    }

}

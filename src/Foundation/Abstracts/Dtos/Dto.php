<?php


namespace Foundation\Abstracts\Dtos;


use Illuminate\Http\Request;
use Larapie\DataTransferObject\DataTransferObject;

class Dto extends DataTransferObject
{
    public function __construct(array $parameters)
    {
        if ($parameters instanceof Request)
            $parameters = $parameters->toArray();
        parent::__construct($parameters);
    }

}
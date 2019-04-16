<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 15.10.18
 * Time: 23:08.
 */

namespace Foundation\Abstracts\Controller;

use Foundation\Traits\HandlesNullResource;
use Foundation\Traits\HandlesOwnership;
use Foundation\Traits\MutatesRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, HandlesOwnership, HandlesNullResource, MutatesRequest;
}

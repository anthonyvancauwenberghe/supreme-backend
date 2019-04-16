<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 10.10.18
 * Time: 02:18.
 */

namespace Foundation\Controllers;

use Illuminate\Routing\Controller;

class FoundationController extends Controller
{
    public function main()
    {
        return response('welcome to '. env('APP_NAME'));
    }

    public function api()
    {
        return response(env('APP_NAME').' api');
    }

    public function authorized()
    {
        return response('authorized');
    }
}

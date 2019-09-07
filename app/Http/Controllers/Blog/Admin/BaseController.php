<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Blog\BaseController as GuestBaseController;

/**
 * Class BaseController
 * The base controller for all blog
 * controllers in the admin panel
 *
 * Must be the parent of all blog controllers
 * @package App\Http\Controllers\Blog\Admin
 */
abstract class BaseController extends GuestBaseController
{
    /**
     * BaseController constructor
     */
    public function __construct()
    {
        // Initializing General Moments for the Admin Panel
    }

}

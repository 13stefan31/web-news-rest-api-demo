<?php

namespace App\PostCategory\Controller;

use App\Base\Controller\BaseController;

use App\PostCategory\Service\PostCategoryService;

class PostCategoryController extends BaseController
{
    function __construct(PostCategoryService $service)
    {
        parent::__construct($service);
    }
}

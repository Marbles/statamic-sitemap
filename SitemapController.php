<?php

namespace Statamic\Addons\Sitemap;

use Statamic\Extend\Controller;

class SitemapController extends Controller
{
    /**
     * Maps to your route definition in routes.yaml
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        return $this->view('index');
    }
}

<?php

namespace Statamic\Addons\Sitemap;

use Statamic\Extend\Controller;

class SitemapController extends Controller
{
    /**
     * Maps to your route definition in routes.yaml
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->make($this->view('index'), '200')->header('Content-Type', 'text/xml');
    }
}

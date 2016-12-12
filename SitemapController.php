<?php

namespace Statamic\Addons\Sitemap;

use Statamic\API\Content;
use Statamic\Exceptions\InvalidEntryTypeException;
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
        $content = Content::all();

        $content = $content->filter(function ($entry) {
            return $entry->published();
        })->map(function ($entry) {

            try {
                if (method_exists($entry, 'date')) {
                    $date = $entry->date();
                }
            } catch (InvalidEntryTypeException $e) {
            }

            return [
                'url' => $entry->absoluteUrl(),
                'date' => isset($date) ? $date : null
            ];
        });

        return response()->make($this->view('index', compact('content')), '200')->header('Content-Type', 'text/xml');
    }
}

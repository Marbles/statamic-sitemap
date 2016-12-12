<?php

namespace Statamic\Addons\Sitemap;

use Statamic\API\Content;
use Statamic\Contracts\Data\Content\Content as DataContent;
use Statamic\Exceptions\InvalidEntryTypeException;
use Statamic\Extend\Controller;

class SitemapController extends Controller
{
    /**
     * Maps to your route definition in routes.yaml.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $content = Content::all();

        $content = $content->filter(function (DataContent $entry) {
            return $entry->published();
        })->map(function (DataContent $entry) {
            try {
                if (method_exists($entry, 'date')) {
                    $date = $entry->date();
                }
            } catch (InvalidEntryTypeException $e) {
                // Don't do anything when there's no date field
            }

            return [
                'url'  => $entry->absoluteUrl(),
                'date' => isset($date) ? $date : null,
            ];
        });

        return response()->make($this->view('index', compact('content')), '200')->header('Content-Type', 'text/xml');
    }
}

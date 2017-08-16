<?php

namespace Statamic\Addons\Sitemap;

use Statamic\API\Content;
use Statamic\Contracts\Data\Content\Content as DataContent;
use Statamic\Contracts\Data\Pages\Page;
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
        $defaultLocale = default_locale();

        $content = $content->filter(function (DataContent $entry) {
            /**
             * Check if the entry has a route set up
             * Only accept the front page with an empty url.
             */
            $hasRoute = $entry instanceof Page || $entry->url() !== '/';

            return $entry->published() && $hasRoute;
        })->map(function (DataContent $entry) use ($defaultLocale) {
            try {
                if (method_exists($entry, 'date')) {
                    $date = $entry->date();
                }
            } catch (InvalidEntryTypeException $e) {
                // Don't do anything when there's no date field
            }

            // set up alternate locales
            $alternates = [];
            foreach ($entry->locales() as $locale) {
                // skip default locale
                if ($locale === $defaultLocale) {
                    continue;
                }

                // locale and generate url
                $entry->locale($locale);
                $alternates[$locale] = $entry->absoluteUrl();
            }

            // reset locale of the entry to generate correct url
            $entry->locale($defaultLocale);

            return [
                'url'        => $entry->absoluteUrl(),
                'date'       => isset($date) ? $date : null,
                'alternates' => $alternates,
            ];
        })->unique('url');

        return response()->make($this->view('index', compact('content')), '200')->header('Content-Type', 'text/xml');
    }
}

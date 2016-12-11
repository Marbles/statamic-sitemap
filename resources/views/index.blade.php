<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.90">
    @foreach (\Statamic\API\Content::all() as $content)
        @if ($content->published())
            <url>
                <loc>{{ $content->absoluteUrl() }}</loc>
                <?php
                    $date = null;
                    try {
                        if (method_exists($content, 'date')) {
                            $date = $content->date();
                        }
                    } catch (ErrorException $e) {
                    } catch (Statamic\Exceptions\InvalidEntryTypeException $e) {
                    }
                ?>
                @if (!is_null($date))
                    <lastmod>
                        {{ $date->toAtomString() }}
                    </lastmod>
                @endif
            </url>
        @endif
    @endforeach
</urlset>
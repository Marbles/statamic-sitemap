<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
    @foreach ($content as $entry)
        <url>
            <loc>{{ $entry['url'] }}</loc>
            @if (!is_null($entry['date']))
                <lastmod>
                    {{ $entry['date']->toAtomString() }}
                </lastmod>
            @endif
            @foreach ($entry['alternates'] as $locale => $url)
                <xhtml:link
                        rel="alternate"
                        hreflang="{{ $locale }}"
                        href="{{ $url }}"
                />
            @endforeach
        </url>
    @endforeach
</urlset>

<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.90">
    @foreach ($content as $entry)
        <url>
            <loc>{{ $entry['url'] }}</loc>
            @if (!is_null($entry['date']))
                <lastmod>
                    {{ $entry['date']->toAtomString() }}
                </lastmod>
            @endif
        </url>
    @endforeach
</urlset>

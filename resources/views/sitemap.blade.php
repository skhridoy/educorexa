<?xml version="1.0" encoding="UTF-8"?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <url>
        <loc>https://educorexa.com</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    @foreach($schools as $school)
    <url>
        <loc>https://{{ $school->slug }}.educorexa.com</loc>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

</urlset>
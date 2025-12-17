<!-- Google Analytics -->
@if(setting('google_analytics_id'))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ setting('google_analytics_id') }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{{ setting('google_analytics_id') }}');
</script>
@endif

<!-- Google Search Console Verification -->
@if(setting('google_site_verification'))
<meta name="google-site-verification" content="{{ setting('google_site_verification') }}" />
@endif

<!-- Bing Webmaster Tools -->
@if(setting('bing_site_verification'))
<meta name="msvalidate.01" content="{{ setting('bing_site_verification') }}" />
@endif

<!-- Yandex Webmaster -->
@if(setting('yandex_verification'))
<meta name="yandex-verification" content="{{ setting('yandex_verification') }}" />
@endif

<!-- Additional SEO Meta Tags -->
<meta name="theme-color" content="#3B82F6">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="SMK Bina Mandiri">

<!-- Preload critical resources -->
<link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" as="style">
<link rel="preload" href="{{ asset('storage/' . setting('site_logo')) }}" as="image">

<!-- DNS Prefetch -->
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link rel="dns-prefetch" href="//cdn.tailwindcss.com">

<!-- Structured Data for Breadcrumbs -->
@if(isset($breadcrumbs) && count($breadcrumbs) > 1)
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        @foreach($breadcrumbs as $index => $breadcrumb)
        {
            "@type": "ListItem",
            "position": {{ $index + 1 }},
            "name": "{{ $breadcrumb['name'] }}",
            "item": "{{ $breadcrumb['url'] }}"
        }@if(!$loop->last),@endif
        @endforeach
    ]
}
</script>
@endif
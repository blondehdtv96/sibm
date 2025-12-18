<!-- Google Analytics -->
<?php if(setting('google_analytics_id')): ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e(setting('google_analytics_id')); ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '<?php echo e(setting('google_analytics_id')); ?>');
</script>
<?php endif; ?>

<!-- Google Search Console Verification -->
<?php if(setting('google_site_verification')): ?>
<meta name="google-site-verification" content="<?php echo e(setting('google_site_verification')); ?>" />
<?php endif; ?>

<!-- Bing Webmaster Tools -->
<?php if(setting('bing_site_verification')): ?>
<meta name="msvalidate.01" content="<?php echo e(setting('bing_site_verification')); ?>" />
<?php endif; ?>

<!-- Yandex Webmaster -->
<?php if(setting('yandex_verification')): ?>
<meta name="yandex-verification" content="<?php echo e(setting('yandex_verification')); ?>" />
<?php endif; ?>

<!-- Additional SEO Meta Tags -->
<meta name="theme-color" content="#3B82F6">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="SMK Bina Mandiri">

<!-- Preload critical resources -->
<link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" as="style">
<link rel="preload" href="<?php echo e(asset('storage/' . setting('site_logo'))); ?>" as="image">

<!-- DNS Prefetch -->
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link rel="dns-prefetch" href="//cdn.tailwindcss.com">

<!-- Structured Data for Breadcrumbs -->
<?php if(isset($breadcrumbs) && count($breadcrumbs) > 1): ?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        {
            "@type": "ListItem",
            "position": <?php echo e($index + 1); ?>,
            "name": "<?php echo e($breadcrumb['name']); ?>",
            "item": "<?php echo e($breadcrumb['url']); ?>"
        }<?php if(!$loop->last): ?>,<?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    ]
}
</script>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\sibm\resources\views/components/seo-head.blade.php ENDPATH**/ ?>
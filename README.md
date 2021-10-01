#Installation
1.composer 

2. in bundles.php add 
3. ```TwinElements\SocialMediaBundle\TwinElementsSocialMediaBundle::class => ['all' => true],```

3.Add to routes.yaml
```
social_media_admin:
    resource: "@TwinElementsSocialMediaBundle/Controller/"
    prefix: /admin
    type: annotation
    requirements:
        _locale: '%app_locales%'
    defaults:
        _locale: '%locale%'
        _admin_locale: '%admin_locale%'
    options: { i18n: false }
```

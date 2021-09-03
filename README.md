# Fix customer civility

If you want to fix this issue: https://github.com/magento/magento2/issues/32177

Add in your composer.json :
```json
"extra": {
    "composer-exit-on-patch-failure": true,
    "patches": {
        "magento/module-customer": {
            "Fix civility following the magento version upgrade to 2.4.2": "vendor/adexos/fixcustomercivility/patches/composer/M242/fix-civility.patch"
        }
    }
}
```

And launch this command for apply this patch
```bash
composer install
```

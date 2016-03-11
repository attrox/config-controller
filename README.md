## Laravel Config Controller

This package provides a quick front-end admin interface to update a Laravel configuration file.

This is for the lazy developers who wants a quick "CMS" like admin interface to control the display of some web-page without the use of database. Just set up the Laravel configuration file and expose the page name (slug). The admin update will write back into the Laravel configuration file keeping intact the structure and comment in the config file.

### Usage Instructions

Copy ```vendor/attrox/config-controller/config/configcontroller.php``` to Laravel ```config/``` folder.

Add ```slug``` name. This should represent the page name for both the web facing page and the admin interface page.

Add entries in ```input``` and ```content``` array for the ```slug```, see the comments in ```configcontroller.php``` for more details.

Extends ```Attrox\ConfigController\Controllers\AbstractController``` and expose ```admin($slug)```
and ```adminPost($slug)``` to your routes to provide access to the configuration admin interface.

Adjust the properties of the controller (if needed):
```php
protected $config_base = 'configcontroller'; // This is mapped to Laravel config/configcontroller.php
protected $admin_view = 'config_admin'; // This is the blade view used by the admin
protected $index_view = '';
```

Add a method in this controller to return the dynamic web page. ```getSlugContent($slug)``` will return the content that you can manipulate within your view.

Add a similar route like below:
```php
$router->get('/test/{slug}', 'YourControllerClass@admin');
$router->post('/test/{slug}', 'YourControllerClass@adminPost');
$router->get('/dynamic/{$slug}', 'YourControllerClass@index');
```

Copy ```vendor/attrox/config-controller/views/config_admin.blade.php``` to your views folder. This is a sample admin interface view that you can include in your main view.

### Dependencies

This package is dependent on ```October\Rain\Config\Repository``` package (https://github.com/attrox/laravel-config-writer). A package I fork from https://github.com/daftspunk/laravel-config-writer to work with Laravel 5.x



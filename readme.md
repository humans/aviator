## Service Providers

```php
namespace App\Providers;

use Facades\Artisan\Aviator\Aviator;

class AviatorServiceProvider extends \Artisan\Aviator\AviatorServiceProvider
{
    public function register()
    {
        parent::register();

        Aviator::resources([
            \App\Aviator\User::class,
        ]);
    }
}
```


## Resources

```php
namespace App\Aviator;

class User extends \Artisan\Aviator\Resource
{
    public static $model = 'App\User';

    public static $resourceRoute = 'users';

    public function fields()
    {
        return ['id', 'name', 'email'];
    }
}
```
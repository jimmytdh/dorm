<p align="center"><a href="https://dohcsmc.com" target="_blank"><img src="https://dohcsmc.com/csmc_laravel.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About this System

The Dormitory Management System is designed to streamline dormitory administration by automating tasks like student registrations, room assignments, and occupancy tracking. Key features include automated room allocation based on availability and preferences, real-time updates on occupancy, and efficient check-in and check-out processes. The system also manages finances, including billing, rent collection, and tracking of COOP income. It maintains detailed resident profiles and tracks transient movements and toilet usage to enhance record-keeping. To improve communication, we will use Twilio for our API in the SMS notification feature, sending important updates directly to residents. Overall, the system reduces administrative workload and improves the experience for staff and residents.

## How to Install

1. Clone the repository and navigate to the project directory:
```bash
git clone [repository link]
cd [directory]
```
2. Install the necessary dependencies using Composer:

```bash
composer update
```
3. Copy the example environment file and update the database configuration:
```bash
copy .env.example .env
```

4. Generate the application key and run the migrations:
``` bash
php artisan key:generate
php artisan migrate
```

5. (Windows only) Create a symbolic link for the public directory:
```bash
mklink /d C:\wamp64\www\[directory] C:\wamp64\server\[directory]\public
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


## Troubleshooting

### SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 1000 bytes
#### Add the following code to `App/Providers/AppServiceProvider.php`:

```bash
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
```

### Bootstrap Paginator not working
#### Add the following code to App/Providers/AppServiceProvider.php:
```bash
    public function boot()
    {
        Paginator::useBootstrap();
    }
```
###`loadPage` function not defined
1. Create a helper.php file in the app/Helper directory with the following content:
```bash
  if (! function_exists('loadPage')) {
    function loadPage($view, $title = 'Laravel SPA')
    {
        return response()->json([
            'title' => $title,
            'content' => $view
        ]);
    }
}
```
2. Update the `composer.json` file to include the helper file:
```bash
"autoload": {
    "psr-4": {
        "App\\": "app/",
        "Database\\Factories\\": "database/factories/",
        "Database\\Seeders\\": "database/seeders/"
    },
    "files": [
        "app/Helper/helper.php"
    ]
},
```
3. Regenerate the autoload files:
```bash
composer dump-autoload
```
### cURL error 60: SSL certificate in Laravel 9
- Download this file: http://curl.haxx.se/ca/cacert.pem
- Place this file in the C:\wamp64\bin\php\[php version] folder
- Open php.ini and find this line:
`;curl.cainfo`
- Change it to: `curl.cainfo = "C:\wamp64\bin\php\php7.1.9\cacert.pem"`
- Make sure you remove the semicolon at the beginning of the line.
- Save changes to `php.ini`, restart WampServer, and you're good to go!

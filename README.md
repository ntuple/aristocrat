## Integration of Aristocrat in Laraval 4.

### Installation

To get the latest version of Theme simply require it in your `composer.json` file.

~~~
"matrix/aristocrat": "dev-master"
~~~

You'll then need to run `composer install` to download it and have the autoloader updated.

Once Aristocrat is installed you need to register the service provider with the application. 

Open `app/config/app.php` and find the `providers` index and add the following line.

~~~
'providers' => [

    'Matrix\Aristocrat\ServiceProvider',

]
~~~

You need register the facade in the `aliases` index in same `app/config/app.php` file.

~~~
'aliases' => [

    'Aristocrat' => 'Matrix\Aristocrat\Facade',

]

~~~


### Usages

~~~
class HomeController extends BaseController {

    public function getIndex(){
        $restult = Aristocrat::selectData();
    }
}

~~~

# TopGamers

TopGamers is a website designed to rank the most viewed Twitch streamers supporting a multitude of games.

## Further information

It is built with PHP7 and Symfony 4.2 via composer.
Twig and Filesystem extensions added to Symfony.
It reads JSON data provided by another server (also running Symfony).
Includes a livestream player.
The development team added a caching system for the recieved JSON data.
This cache can be cleaned using /deletecahce route with a secret code to authorise.
CSS development handled by SASS

### Made With
* [PHP 7.2](https://www.php.net/) - The programming language used
* [Symfony 4.2](https://symfony.com/) - The framework
* [Bootstrap 4](https://getbootstrap.com/) - CSS layout helper
* [NetBeans 8.2](https://netbeans.org/) - Original development IDE
* [Masonry 4.2](https://masonry.desandro.com) - Brilliant masonry library

### Installation
Installation is simple, clone the repository into a directory and in the same directory:
```bash
composer install
```

### Routes
* / - Our index, the main dashboard
* /deletecache - Deletes our servers cache file. Has secret get parameter.

### env.local
* TG_ADMIN_CACHEFILE - System cache file name
* TG_ADMIN_PASS - /deletecache?pass= passphrase
* TG_JSON_ALLGAMES - Stores the endpoint url of the API.

## 1. Creation process
Our first steps creating this project:
```bash
#create the symfony structure
composer create-project symfony/website-skeleton src

#add modules
composer require symfony/filesystem
composer require twig
```

## 2. Structure
As per usual Symfony projects, we only have to look at certain folders:
```bash
/public #JavaScript, images and SCSS
/templates #Twig files
/src #The vast majority of our code.
```
### 2.1 The /public folder
Our .htaccess file makes sure that Symfony's routing works.
### 2.2 The /templates folder
We will point out our template structure:
```bash
base.html.twig #Our <head> and <footer>.
# We load our stylesheet and bootstrap 4
# Every view will use this file as, you guessed it, a base.

nav_top.html.twig #Our navbar, also prepared to be used in other views
# Kept separate for logical and structural reasons.

dashboard.html.twig #This is the only view of our application so far
```
### 2.3 The /src folder
Inside this folder we have 3 important subfolders.
```bash
/Classes #Stores classes used to help certain tasks. Non-object classes.
/Service #Stores objects that are Symfony services. More on that later.
/Controller #Stores our controllers. Routing is done via annotations.
```
#### 2.3.1 Classes
##### 2.3.1.1 CurlHelper
```php
use App\Classes\CurlHelper
```
Class used for certain curl-related tasks. Currently stores a single function used to check if an URL is valid.

##### 2.3.1.2 JsonHelper
```php
use App\Classes\JsonHelper
```
Class used for certain json-related tasks. Currently stores a single function used to check if a JSON string is valid.

#### 2.3.2 Services
##### 2.3.2.1 CacheManager
```php
use App\Service\CacheManager
```
This class uses the Filesystem component. It handles most of the operations on the cache file.
The cache file is created in the temporary files folder (may vary depending on your OS and systemd)
The constructor instances the Filesystem, prepares the temporary foler and stores the default cache filename.
Our manager includes several validations, if the file exists, if file is older than a day, and if its a valid JSON.
It also lets us read, write, get modified time, and delete the cache file.
This class connects to JsonHelper and is mostly used by GamerManager.

##### 2.3.2.2 GamerManager
```php
use App\Service\GamerManager
```
This class is tasked to read our gamers from different sources, and filter out their data.
The constructor stores an instance of our CacheManager.
GamerManager is accessed via readGamers() which then checks if our cached JSON meets the requirements stated above in 2.3.2.1.
Depending on the test, it will readfromUrl(), and cache the response, or read the cached file.
There is also a small filter that will correct gamers' Twitch links and convert them to player.twitch.tv.

#### 2.3.3 Controllers
##### 2.3.3.1 DefaultController
This is the controller that recieves JSON and renders them on our dashboard.html.twig template. Mu poquitito.
##### 2.3.3.2 AdminController
This controller currently stores our cache deletion route with a secret pass.

## Deployment
TO-DO: Add additional notes about how to deploy this on a live system

## Contributing
Clone whatever you like.
Pull requests are welcome. For any changes, please open an issue first to discuss what you would like to change.

## Authors
* **Imanol Romera Lockhart** - *Working hard, memes* - [superwave1999](https://github.com/superwave1999)
* **Alejandro Lucena Archilla** - *Supervising, complaining* - [Comerline](https://github.com/Comerline)

## License
[MIT](https://choosealicense.com/licenses/mit/), read license.md for more information.

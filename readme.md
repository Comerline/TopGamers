# TopGamers

TopGamers is a website designed to rank the most viewed Twitch streamers supporting a multitude of games.

## Further information

It is built with PHP7 and Symfony 4.2 via composer.
Twig and Filesystem extensions added to Symfony.
It reads JSON data provided by [api.topgamers.me](https://api.topgamers.me) .
Includes a livestream player.
The development team added a caching system for the recieved JSON data.
This cache can be cleaned using /deletecahce route with a secret code to authorise.
CSS development handled by SASS

## 1. Creation process
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
##### 2.3.2.1 


## Contributing
Clone whatever you like.
Pull requests are welcome. For any changes, please open an issue first to discuss what you would like to change.

## License
[MIT](https://choosealicense.com/licenses/mit/)
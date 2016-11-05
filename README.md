# PHP-Caching
Simple PHP Caching Class

 - Unique file names
 - Time based caching
 - Optimized storing
 
```php
require_once 'Caching.php';
$cachePath = __DIR__  . '/cache/';
$caching = new Caching($cachePath);
```
**Add data to the cache:**
```php
$names = ['John','Alicia','Hugh'];
$caching->setCache('names', $names, 15); // Key, data, time (as minute)
```
**Retrieve data from the cache:**
```php
$names = $caching->getCache('names');
```
**Delete data from the cache:**
```php
$caching->delCache('names');
```
**Retrieve error messages:**
```php
$caching->getErrors();
```
**Another an example:**
```php
$results = $caching->getCache('names');
if (!$results) {
    // your sql query
    $caching->setCache('names', $results, 60);
}
var_dump($results);
```

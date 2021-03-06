Alfredo for Laravel
===================
This package is merely an Alfredo wrapper written for Laravel.
It will ease a lot of the tasks provided from the Alfredo client.

# Table of Contents
[Documentation](#documentation)

[Installation](#installation)

[Usage](#usage)
* [Create payload](#create-payload)
* [Add source to payload](#add-source-to-payload)
* [Create payload with converter type](#create-payload-with-converter-type)
* [Create payload with callback url for queues](#create-payload-with-callback-url-for-queues)
* [Create payload with sources](#create-payload-with-sources)
* [Convert a payload](#convert-a-payload)
* [Stream a payload or converted payload](#stream-a-payload-or-converted-payload)
* [Queue a payload](#queue-a-payload)
* [Check if a queued payload has been converted](#check-if-a-queued-payload-has-been-converted)
* [Get converted payload from queue](#get-converted-payload-from-queue)
* [Stream converted payload from queue](#stream-converted-payload-from-queue)

[License](#license)

<a name="documentation"/>
# Documentation
The full documentation on Alfredo can be [found here](http://online-pdfconverter.nl/guide)

<a name="requirements"/>
# Requirements
* PHP 5.3

<a name="installation"/>
# Installation
1. Add requirement to composer.json

    ```json
    "issetbv/alfredo-laravel": "dev-master"
    ```
2. Update dependencies

    ```shell
    composer update
    ```
3. Publish configuration file

    ```shell
    php artisan config:publish issetbv/alfredo-laravel
    ```
4. Add Service Provider to the ```providers``` array in ```app/config/app.php```

    ```php
    'IssetBv\AlfredoLaravel\AlfredoServiceProvider',
    ```
5. Add Facade to the ```facades``` array in ```app/config/app.php```

    ```php
    'Alfredo' => 'IssetBv\AlfredoLaravel\Facade',
    ```
5. Add API keys to the configuration file in ```app/config/packages/issetbv/alfredo-laravel/config.php```

<a name="usage"/>
# Usage
<a name="create-payload"/>
**Create payload**
```php
$payload = Alfredo::makePayload();
```
<a name="add-source-to-payload"/>
**Add source to payload**

Available: addHtml, addPdf, addUrl
```php
$payload = Alfredo::makePayload();
$payload->addUrl('http://isset.nl');
```
<a name="create-payload-with-converter-type"/>
**Create payload with converter type**
```php
$payload = Alfredo::makePayloadWithConverter('htmltopdfjava');
```
<a name="create-payload-with-callback-url-for-queues"/>
**Create payload with callback url for queues**
```php
$payload = Alfredo::makePayloadWithCallback('http://example.com/callback_url');
```
<a name="create-payload-with-sources"/>
**Create payload with sources**

Available: html, pdf, url
```php
$payload = Alfredo::makePayloadWithSources(array(
    array('url', 'http://isset.nl'),
    array('html', '<html><thead></thead><tbody>Create payload with sources!</tbody></html>')
));
```
<a name="convert-a-payload"/>
**Convert a payload**
```php
$payload = Alfredo::makePayload();
$payload->addHtml('<html><thead></thead><tbody>Converting a payload!</tbody></html>');
$pdf = Alfredo::convert($payload);
```
<a name="stream-a-payload-or-converted-payload"/>
**Stream a payload or converted payload**

Stream a payload:
```php
$payload = Alfredo::makePayload();
$payload->addHtml('<html><thead></thead><tbody>Streaming a payload!</tbody></html>');
$response = Alfredo::stream($payload); // returns a Response object
```
Stream a converted payload:
```php
$payload = Alfredo::makePayload();
$payload->addHtml('<html><thead></thead><tbody>Streaming a converted payload!</tbody></html>');
$pdf = Alfredo::convert($payload);
$response = Alfredo::stream($pdf); // returns a Response object
```
<a name="queue-a-payload"/>
**Queue a payload**

When using the queue, its necessary to set the callback url.
```php
$payload = Alfredo::makePayloadWithCallback('http://example.com/callback_url');
$payload->addHtml('<html><thead></thead><tbody>Queueing a payload!</tbody></html>');
$response = Alfredo::queue($payload); // returns a JSON response
```
```json
{
    "response":"Queued",
    "identifier":"xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
}
```
<a name="check-if-a-queued-payload-has-been-converted"/>
**Check if a queued payload has been converted**
```php
if (Alfredo::checkQueuedPayload('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx')) {  // returns a boolean
    // Payload has been converted and is ready to be downloaded
}
```
<a name="get-converted-payload-from-queue"/>
**Get converted payload from queue**
```php
$pdf = Alfredo::getQueuedPayload('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
```
<a name="stream-converted-payload-from-queue"/>
**Stream converted payload from queue**
```php
$pdf = Alfredo::getQueuedPayload('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
$response = Alfredo::stream($pdf);
```

# License
MIT

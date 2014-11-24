talend-php-sdk [![Build Status](https://travis-ci.org/lafourchette/talend-php-sdk.svg?branch=master)](https://travis-ci.org/lafourchette/talend-php-sdk)
==============

Informations
======

Client for Talend administrator server API

Documentation Talend administrator server API :
https://help.talend.com/display/TalendPlatformUniversalStudioUserGuide54EN/G.3.4+Configuring+the+components

`runTask` with a context parameter :
https://help.talend.com/display/TalendAdministrationCenterUserGuide54EN/B.5.2+Executing+a+task+with+context+parameters+using+metaServlet

Example :
---------

1) Method runTask
```php
<?php
use LaFourchette\Talend\TalendClient;

$client = TalendClient::factory(array(
    'base_url'    => 'http://talend.url/org.talend.administrator/metaServlet',
    'login'       => 'login',
    'password'    => 'password',
));

$client->runTask(17);
```
Method runTask with a context parameter


```php
<?php
use LaFourchette\Talend\TalendClient;

$client = TalendClient::factory(array(
    'base_url'    => 'http://talend.url/org.talend.administrator/metaServlet',
    'login'       => 'login',
    'password'    => 'password',
    'context'     => array('ids_customer' => '1,2,3')
));

$client->runTask(17);
```

2) Method listTasks
```php
use LaFourchette\Talend\TalendClient;

$client = TalendClient::factory(array(
    'base_url'    => 'http://talend.url/org.talend.administrator/metaServlet',
    'login'       => 'login',
    'password'    => 'password',
));

$client->listTasks();
```

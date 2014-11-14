talend-php-sdk
==============

README
======

Client for Talend administrator server API

Documentation Talend administrator server API :
https://help.talend.com/display/TalendPlatformUniversalStudioUserGuide54EN/G.3.4+Configuring+the+components

runTask with a context parameter :
https://help.talend.com/display/TalendAdministrationCenterUserGuide54EN/B.5.2+Executing+a+task+with+context+parameters+using+metaServlet

Documentation Confluence :
https://confluence.lafourchette.com/display/LAB/Webservice+et+MetaServlet

Example :
---------

1) method runTask
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
method runTask with a context parameter


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

2) method listTasks
```php
use LaFourchette\Talend\TalendClient;

$client = TalendClient::factory(array(
    'base_url'    => 'http://talend.url/org.talend.administrator/metaServlet',
    'login'       => 'login',
    'password'    => 'password',
));

$client->listTasks();
```

talend-php-sdk
==============

README
======

Client for Talend administrator server API

Documentation Talend administrator server API :
https://help.talend.com/display/TalendPlatformUniversalStudioUserGuide54EN/G.3.4+Configuring+the+components

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

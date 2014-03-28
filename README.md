phpmake_logger
==============

PSR-3 Logger implementation for handling PHP streams.


API
===

Instantiate
-----------

### default logger
Default logger outputs logs to stdout.

```php
<?php
require_once 'PHPMake/Logger.php';
$defaultLogger = new \PHPMake\Logger();
```
Next line is equal to above.

```php
$defaultLogger = new \PHPMake\Logger('php://stdout');
```

### file appender
Constructor's first argument can be specified URL, 
then, logger outputs logs to the specified URL.

```php
$fileAppender = new \PHPMake\Logger('file:///tmp/app.log');
// or
// $fileAppender = new \PHPMake\Logger('file:///tmp/app.log', 'a');
```
Constructor's second argument can be specified file opening mode. Default mode is ```a``` which means to 'append'.  
If you passed ```w``` as second argument, specified file will be empty at first. Or passed ```r```, you will get warnings when each output.


Logging
-------
This logger implements ```\Psr\Log\Logger interface```. Therefore, call these methods for logging.

```php
$logger->debug('debug');
$logger->info('info');
$logger->notice('notice');
$logger->warning('warning');
$logger->error('error');
$logger->critical('critical');
$logger->alert('alert');
$logger->emergency('emergency');
```

### threshold
```setThreshold()``` method is provide to control outputs with log level.

```php
$logger = new \PHPMake\Logger();
$logger->setThreshold(\Psr\Log\LogLevel::WARNING);

// debug, info and notice will not be output.
$logger->debug('debug');
$logger->info('info');
$logger->notice('notice');

// level which is warning or higher will be outputted.
$logger->warning('warning');
$logger->error('error');
$logger->critical('critical');
$logger->alert('alert');
$logger->emergency('emergency');
```








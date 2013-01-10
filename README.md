lf4php-monolog
==============

This is a Monolog binding for lf4php.

Using lf4php-monolog
--------------------

### Configuration

```php
<?php
$monologFactory = new MonologLoggerFactory();
$monolog = new \Monolog\Logger('foo');
// here you can configre your Monolog loggers
$monologFactory->registerLogger($monolog);
LoggerFactory::setILoggerFactory($monologFactory);
```

### Logging

```php
<?php
$logger = LoggerFactory::getLogger(__CLASS__);
$logger->info('Message');
$logger->debug('Hello {}!', array('John'));
$logger->error(new \Exception());
```

History
-------

### 3.0

Updated lf4php (3.0.x)
# Imoisey/docker-compose-builder

This is an easy library for building docker-compose.yml files.

## Installation

```bash
composer require imoisey/docker-compose-builder
```

## Usage

```php
use Imoisey\DockerComposeBuilder\DockerComposeBuilder;
use DockerPhpClient\Compose\Model\Service;

$dc = new DockerComposeBuilder();
$dc->setVersion('3.7');

$service = new Service();
$service->setBuild((object)[
    'context' => 'docker/development',
]);

$service->setVolumes(['./:/app']);
$service->setPorts([
    '8080:80'
]);

$dc->addService('php-apache', $service);

$dc->build('docker-compose.yml');
```                      

docker-compose.yml:

```docker-compose.yml
version: '3.7'
services:
    php-apache:
        build:
            context: docker/development
        volumes:
            - './:/app'
        ports:
            - '8080:80'
```


## License
[MIT](https://choosealicense.com/licenses/mit/)
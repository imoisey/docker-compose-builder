<?php

namespace Imoisey\DockerComposeBuilder;

use DockerPhpClient\Compose\Model\File;
use DockerPhpClient\Compose\Model\Service;
use Imoisey\DockerComposeBuilder\Normalizer\NormalizerFactory;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Yaml\Yaml;

class DockerComposeBuilder extends File
{
     public function build(string $filepath)
     {
         $encoders = [new YamlEncoder()];

         $serializer = new Serializer(NormalizerFactory::create(), $encoders);

         try {
             $object = $serializer->normalize($this, 'yaml');
             $array = json_decode(json_encode($object), true);
         } catch (ExceptionInterface $e) {
             die($e->getMessage());
         }

         $yamlOutput = Yaml::dump($object, 5, 4, Yaml::DUMP_OBJECT_AS_MAP);

         file_put_contents($filepath, $yamlOutput);
     }

     public function addService(string $id, Service $service): void
     {
         $this->services[$id] = $service;
     }

    public function addVolume(string $id, array $volume): void
    {
        $this->volumes[$id] = $volume;
    }
}
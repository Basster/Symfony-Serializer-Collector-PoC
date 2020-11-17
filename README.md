# Symfony-Serializer-Collector-PoC

PoC of a Symfony Serializer Collector for the Web Debug Toolbar

## How it works?

* All Normalizers are going to be decorated with specific implementations of [AbstractTraceableNormalizer](src/Serializer/Normalizer/AbstractTraceableNormalizer.php) in the [SerializerDebugPass](src/DependencyInjection/SerializerDebugPass.php).
  * All decorated normalizers will get tagged with `debug.normalizer`, as well.
  * I had to use three implementations here, since the Serializer utilizes a lot of `instanceof` checks. 
* The [SerializerDataCollector](src/Serializer/SerializerDataCollector.php) collects all serializations, deserializations, normalizations & denormalizations from all services with the `debug.normalizer` tag.
* On the [services.yaml](config/services.yaml) the `serializer` services gets decorated with a [TraceableSerializer](src/Serializer/TraceableSerializer.php) and the SerializerDataCollector gets registered. 

## Feedback

Feel free to post some feedback on [symfony/symfony#39102](https://github.com/symfony/symfony/issues/39102)

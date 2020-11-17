# Symfony-Serializer-Collector-PoC

PoC of a Symfony Serializer Collector for the Web Debug Toolbar

## How it works?

* All Normalizers will get decorated with TraceableNormalizers in `src/DependencyInjection/SerializerDebugPass.php`
  * All TraceableNormalizers will get tagged with `debug.normalizer`.
* The `src/Serializer/SerializerDataCollector.php` collects all serializations, deserializations, normalizations & denormalizations from all services with the `debug.normalizer` tag.

## Feedback

Feel free to post some feedback on [symfony/symfony#39102](https://github.com/symfony/symfony/issues/39102)

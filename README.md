![d005d89e-ff25-4450-9119-aa56ff0d8949](https://user-images.githubusercontent.com/3274103/31629229-4859fe88-b2b3-11e7-85fb-66c35710f607.png)

![Software License][ico-license]

**WORK IN PROGRESS**

Pupper stands for "PHP Plus React" (PPR -> Pupper). The goal is to make a Framework that takes the best of both technologies and makes them communicate bi-directionnaly.

[See pupper on Github for more information](https://github.com/bouiboui/pupper/tree/master/app)


### WebSocket

`WebSocket` is the class that will let you define listeners on the PHP side.

The only method that you should learn about is `addListener`, which takes the event name as first parameter, and a callback function as a second parameter.

```php
use Pupper\Pupper\ReactEvent;

$websocket = (new Pupper\Pupper\WebSocket)
    ->addEventListener('custom', function (ReactEvent $event) {
        return (new ReactEvent)
            ->setName('custom')
            ->setValue('From PHP: ' . $event->getValue())
            ->build();
    });

$router = Aerys\router()
    ->route('GET', '/ws', Aerys\websocket($websocket));

return (new Aerys\Host)
    ->use($router)
    ->expose('*', 1337);
```

### ReactEvent

`ReactEvent` represents an event from the PHP side.


**Read**

`ReactEvent` has `getName()` and `getValue()` methods that you can use to read the event's name and value.

```php
use Pupper\Pupper\ReactEvent;

function (ReactEvent $event) {
    echo $event->getName();
    echo $event->getValue();
});
```

**Write**

`ReactEvent` has a `build()` method that prepares events in the right format for `WebSocket` callbacks.

```php
use Pupper\Pupper\ReactEvent;

$event = (new ReactEvent)
    ->setName('custom')
    ->setValue('From PHP: ' . $event->getValue())
    ->build();
```

## Credits

- [bouiboui][link-author]
- [All Contributors][link-contributors]

## License

Unlicense. Please see [License File](LICENSE.md) for more information.

[ico-license]: https://img.shields.io/badge/license-Unlicense-brightgreen.svg?style=flat-square

[link-author]: https://github.com/bouiboui
[link-contributors]: ../../contributors

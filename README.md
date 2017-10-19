![d005d89e-ff25-4450-9119-aa56ff0d8949](https://user-images.githubusercontent.com/3274103/31629229-4859fe88-b2b3-11e7-85fb-66c35710f607.png)

![Software License][ico-license]

**WORK IN PROGRESS**

Pupper stands for "PHP Plus React" (PPR > Pupper). The goal is to make a Framework that takes the best of both technologies and makes them communicate bi-directionnaly.

[See an example implementation](https://github.com/bouiboui/pupper/tree/master/app)

## API
### WebSocket

`WebSocket` is the class that initiates the WebSocket on the PHP side.

**addListener**

`addListener` takes the event name as first parameter, and a callback function as a second parameter. 

If you `return` an `Event`, it will be dispatched to the client that triggered the callback. 

```php
use Pupper\Pupper\Event;

$websocket = (new Pupper\Pupper\WebSocket)
    ->addEventListener('custom', function (Event $event) {
        return (new Event)
            ->setName('custom')
            ->setValue('From PHP: ' . $event->getValue());
    });

$router = Aerys\router()
    ->route('GET', '/ws', Aerys\websocket($websocket));

return (new Aerys\Host)
    ->use($router)
    ->expose('*', 1337);
```

### Event

`Event` represents an event from the PHP side.


**Read**

`Event` has `getName()` and `getValue()` methods to read the event's name and value.

```php
use Pupper\Pupper\Event;

function (Event $event) {
    echo $event->getName();
    echo $event->getValue();
});
```

**Write**

`Event` has `setName()` and `setValue()` methods to write the event's name and value.

```php
use Pupper\Pupper\Event;

$event = (new Event)
    ->setName('hello_event')
    ->setValue('Hello from PHP!');
```

**Construct**

`Event`'s constructor also accepts the event's name and value as parameters.

```php
use Pupper\Pupper\Event;

$event = new Event(
    'hello_event', 
    'Hello from PHP!'
);
```

## Credits

- [bouiboui][link-author]
- [All Contributors][link-contributors]

## License

Unlicense. Please see [License File](LICENSE.md) for more information.

[ico-license]: https://img.shields.io/badge/license-Unlicense-brightgreen.svg?style=flat-square

[link-author]: https://github.com/bouiboui
[link-contributors]: ../../contributors

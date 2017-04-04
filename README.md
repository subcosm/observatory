# observatory
General Observation Pattern Component

[![Build Status](https://travis-ci.org/subcosm/observatory.svg?branch=master)](https://travis-ci.org/subcosm/observatory)
[![codecov](https://codecov.io/gh/subcosm/observatory/branch/master/graph/badge.svg)](https://codecov.io/gh/subcosm/observatory)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/24e183e4-e13d-4128-a844-499110a00718/mini.png)](https://insight.sensiolabs.com/projects/24e183e4-e13d-4128-a844-499110a00718)
![Code Climate](https://codeclimate.com/github/subcosm/observatory.png)

### What is observatory?

Observatory is a general interface orchestration for observable
objects using a container for data transport. It's inspired by
the `SplObserver` implementation of [PHP](https://php.net).

### What is the goal of observatory?

Providing an easy to use, easy to understand, lightweight 
event hub to specific implementations without provided 
methods for each event invoker registration.

### How to use it?

Subcosm Observatory is available at [Packagist](https://packagist/subcosm/observatory):

```cli
# composer require subcosm/observatory ~1.0
```

#### Creating the Observable Object

```php
use Subcosm\Observable\{
    ObservableInterface,
    ObservableTrait,
    AbstractObservationContainer as Container
};

class Foo implements ObservableInterface {
    use ObservableTrait;
    
    public function firstAction()
    {
        $message = 'Hello from firstAction!';
    
        $container = new class($this, __METHOD__, $message) extends Container {
            
            protected $message;
            
            public function __construct($object, string $stage, string $message) 
            {
                $this->message = $message;
                
                parent::__construct($object, $stage);
            }
            
            public function getMessage()
            {
                $this->message;
            }
        };
        
        $this->notify($container);
    }
    
    public function secondAction()
    {
        $message = 'Another hello from secondAction!';
            
        $container = new class($this, __METHOD__, $message) extends Container {
            
            protected $message;
            
            public function __construct($object, string $stage, string $message) 
            {
                $this->message = $message;
                
                parent::__construct($object, $stage);
            }
            
            public function getMessage()
            {
                $this->message;
            }
        };
        
        $this->notify($container);
    }
}
```

#### Creating an Observer

```php
use Subcosm\Observable\{
    ObserverInterface,
    ObservationContainerInterface as Container
};

class EchoMessageObserver implements ObserverInterface {
    
    public function update(Container $container)
    {
        echo $container->getMessage().PHP_EOL;
    }
    
}
```

#### Using the Observable and Observer

```php
$observable = new Foo;

$observer = new EchoMessageObserver;

$observable->attach($observer);

$observable->firstAction();
$observable->secondAction();
```

Results in:

```cli
Hello from firstAction!
Another hello from secondAction!

```

### Package Stability and Maintainers

This package is considered stable. The maintainers of this package are:

- [Matthias Kaschubowski](https://github.com/nhlm)

### License

This package is licensed under the [MIT-License](LICENSE).

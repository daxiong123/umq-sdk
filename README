# umq-sdk - UCloud message queue

---

- [Installation](#installation)
- [Requirements](#requirements)
- [Quick Start and Examples](#quick-start-and-examples)

---

### Installation

To install Validator, simply:

    $ composer require 5ichong/umq-sdk

For latest commit version:

    $ composer require 5ichong/umq-sdk @dev

### Requirements

Validator works with 7.0, 7.1.

### Quick Start and Examples

```php
require __DIR__ . '/vendor/autoload.php';

use \Aichong\Producer;
use \Aichong\Consumer;

$producer = new Producer('', '', '', '');

$producer->publish('phpunit', 'test');

$consumer = new Consumer('', '', '', '');

$list = $consumer->get('phpunit', 20);

$messagesId = [];

foreach ($list->messages as $val) {

    $messagesId[] = $val->messageID;
}

$consumer->ack('phpunit', $messagesId)

```




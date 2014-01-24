Phlack
======
[![Build Status](https://travis-ci.org/mcrumm/phlack.png?branch=master)](https://travis-ci.org/mcrumm/phlack)
Phlack eases the creation of [Slack Integrations](http://slack.com) in PHP.

**Note:** Phlack is not an implementation of the Slack API. However, since an API client in PHP does not yet appear to exist, one may be included in the future.

## Installation & Configuration

### Installation
via Composer

```json
{
    "require": {
        "mcrumm/phlack": "0.1.*"
    }
}
```

### Configuration

Create a hash containing your slack `username` and integrations `token`:

```php
<?php
$config = [ 'username' => 'my_slack_user', 'token' => 'my_slack_token' ]);
```

## Usage

### Getting Phlack

Get a [Phlack](src/Crummy/Phlack/Phlack.php) object by instantiating it with a [PhlackClient](src/Crummy/Phlack/Bridge/Guzzle/PhlackClient.php) or using its static `create()` method.

#### via `create()`:
```php
<?php
...
use Crummy\Phlack\Phlack;
$phlack = Phlack::create($config);
```

#### via `new Phlack()`:
```php
<?php
use Crummy\Phlack\Bridge\Guzzle\PhlackClient;
use Crummy\Phlack\Phlack;

$client = new PhlackClient($config);
$phlack = new Phlack($client);
```

#### :heart: for Guzzle
The PhlackClient is simply a web service client implemented with [Guzzle](http://guzzlephp.org).  Examine its [service description](src/Crummy/Phlack/Bridge/Guzzle/Resources/slack.json) for more details.

### Creating Messages

A Phlack [Message](src/Crummy/Phlack/Message/Message) takes care of structuring the payload for Slack's Incoming Webhooks integration.

#### via `new Message()`;

```php
<?php
...
use Crummy\Phlack\Message\Message;
$message = new Message('Hello, from phlack!');
echo 'The message payload: ' . PHP_EOL:
echo $message;
```

### via the `MessageBuilder`

A [MessageBuilder](src/Crummy/Phlack/Builder/MessageBuilder.php) is also provided:

```php
<?php
...
$messageBuilder = $phlack->getMessageBuilder();
$messageBuilder
  ->setText('I was created in the MessageBuilder')
  ->setChannel('testing')
  ->setIconEmoji('ghost');
$message = $messageBuilder->create();
```

### Sending Messages

Use Phlack's `send()` command to fire off the message:

```php
<?php
...
$response = $phlack->send($message);

if (200 != $response['status']) {
  die('FAIL! - ' . $response['text']);
}

echo 'The message was sent: ' . $message;
```

#### Response

The response hash contains the `status`, `reason`, and `text` from the response.

Responses from the Incoming Webhooks Integration are very sparse. Success messages will simply return a `status` of `200`. Error messages will contain more details in the response `text` and `reason`.

### More Examples
See the [examples directory](examples/) for more use cases.

Phlack
======

[![Build Status](https://travis-ci.org/mcrumm/phlack.png?branch=master)](https://travis-ci.org/mcrumm/phlack) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/mcrumm/phlack/badges/quality-score.png?s=aa61fc3e04fa4042c0988b9e6670938f65ca21e6)](https://scrutinizer-ci.com/g/mcrumm/phlack/) [![Total Downloads](https://poser.pugx.org/mcrumm/phlack/downloads.png)](https://packagist.org/packages/mcrumm/phlack) [![Latest Stable Version](https://poser.pugx.org/mcrumm/phlack/v/stable.png)](https://packagist.org/packages/mcrumm/phlack) [![Latest Unstable Version](https://poser.pugx.org/mcrumm/phlack/v/unstable.png)](https://packagist.org/packages/mcrumm/phlack) [![License](https://poser.pugx.org/mcrumm/phlack/license.png)](https://packagist.org/packages/mcrumm/phlack)

Phlack eases the creation of [Slack Integrations](http://slack.com) in PHP.

**Update:** Phlack now contains a partial implementation of the [Slack API](http://api.slack.com). For details, see the [API Docs](#slack-api) section below.

## Installation & Configuration

### Installation
via Composer

```json
{
    "require": {
        "mcrumm/phlack": "dev-master"
    }
}
```

### Configuration

Create a hash containing your slack `username` and integrations `token`.

*Your `username` is the unique portion of your [Slack](http://slack.com) subdomain.  For example, if your subdomain was `groundctrl.slack.com`, your username will be `groundctrl`.*


```php
<?php
$config = [ 'username' => 'my_slack_user', 'token' => 'my_slack_token' ]);
```

## Usage

### Getting Phlack

Get a [Phlack](src/Crummy/Phlack/Phlack.php) object by instantiating it with a [PhlackClient](src/Crummy/Phlack/Bridge/Guzzle/PhlackClient.php) or using its static `factory()` method.

#### via `factory()`:
```php
<?php
//...
use Crummy\Phlack\Phlack;
$phlack = Phlack::factory($config);
```

#### via `new Phlack()`:
```php
<?php
use Crummy\Phlack\Bridge\Guzzle\PhlackClient;
use Crummy\Phlack\Phlack;

$client = PhlackClient::factory($config);
$phlack = new Phlack($client);
```

#### :heart: for Guzzle
The PhlackClient is simply a web service client implemented with [Guzzle](http://guzzlephp.org).  Examine its [service description](src/Crummy/Phlack/Bridge/Guzzle/Resources/slack.json) for more details.

### Creating Messages

A Phlack [Message](src/Crummy/Phlack/Message/Message.php) takes care of structuring the payload for Slack's Incoming Webhooks integration.

#### via `new Message()`;

```php
<?php
//...
use Crummy\Phlack\Message\Message;
$message = new Message('Hello, from phlack!');
echo 'The message payload: ' . PHP_EOL:
echo $message;
```

### via the `MessageBuilder`

A [MessageBuilder](src/Crummy/Phlack/Builder/MessageBuilder.php) is also provided:

```php
<?php
// ...
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
// ...
$response = $phlack->send($message);

if (200 != $response['status']) {
  die('FAIL! - ' . $response['text']);
}

echo 'The message was sent: ' . $message;
```

#### Response

The [MessageResponse](src/Crummy/Phlack/Bridge/Guzzle/Response/MessageResponse.php) hash contains the `status`, `reason`, and `text` from the response.

Responses from the Incoming Webhooks Integration are very sparse. Success messages will simply return a `status` of `200`. Error messages will contain more details in the response `text` and `reason`.

### More Examples
See the [examples directory](examples/) for more use cases.

## Slack API

Programmatic access to the [Slack API](http://api.slack.com) is provided via the [ApiClient](src/Crummy/Phlack/Bridge/Guzzle/ApiClient.php).

**Note:** Currently, bearer token authentication is the only supported authentication method.  Contributions toward OAuth2 support would be greatly appreciated.

### Getting a Client

Get an [ApiClient](src/Crummy/Phlack/Bridge/Guzzle/ApiClient.php) object by instantiating it with a hash containing your API token, or passing a config hash to its `factory` method.

#### via `factory()`:
```php
<?php

use Crummy\Phlack\Bridge\Guzzle\ApiClient;

$slack = ApiClient::factory([ 'token' => 'my_bearer_token' ]);
```

#### via `new ApiClient()`:
```php
<?php

use Crummy\Phlack\Bridge\Guzzle\ApiClient;

$slack = new ApiClient([ 'token' => 'my_bearer_token' ]);
```

### Methods

The methods currently implemented are:

- [channels.list](https://api.slack.com/methods/channels.list)
- [users.list](https://api.slack.com/methods/users.list)
- [im.list](https://api.slack.com/methods/im.list)

Consult the client's [service description](src/Crummy/Phlack/Bridge/Guzzle/Resources/slack_api.json) for information on the responses returned by the API methods.

### Example: Listing all Channels

```php
<?php

use Crummy\Phlack\Bridge\Guzzle\ApiClient;

$config = [ 'token' => 'my_bearer_token' ];
$slack = new ApiClient($config);

echo 'Fetching Channels List...' . PHP_EOL;
$result = $api->ListChannels();

if (!$result['ok']) {
    die('FAIL! Error was: ' . $result['error'] . PHP_EOL);
}

foreach ($result['channels'] as $channel) {
    printf('%s: %s' . PHP_EOL, $channel['name'], $channel['purpose']['value']);
}
```

#### More Examples
See the [API examples directory](examples/api) for more use cases.
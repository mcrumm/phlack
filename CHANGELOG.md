Changelog
=========

### `v0.7.0` (2016-05-02)

* [#31](https://github.com/mcrumm/phlack/pull/31): Remove validation on payload (Courtesy @rdohms)
* Drop Behat tests
* Add Symfony v3.0 support

### `v0.6.0` (2015-12-29)

**BC BREAK**: The `channel` message parameter is no longer normalized to ensure a `#` prefix. This allows you to use `@username` as the channel to send a DM, or to use the channel id (`C_____`) directly.

**BC BREAK**: Message objects no longer contain setter/getter methods for parameters.  Use the `ArrayAccess` syntax to access or mutate these properties.

* [#26](https://github.com/mcrumm/phlack/pull/26): Remove normalization for `channel` to allow for DMs and raw channel ids (Courtesy @errodr)
* Remove deprecated methods from `Message` classes
* Add some missing tests
* Add more documentation

### `v0.5.7` (2015-10-08)

* Adds support for additional Attachment properties:  `author_name`, `author_link`, `author_icon`, `title`, `title_link`, `image_url`, `thumb_url`, `mrkdwn_in` (Courtesy @errodr)

### `v0.5.6` (2015-08-14)

* Add support for sending direct messages to a user. (Courtesy @atomasevic)
* Add support for new Incoming Webhook URL format.
* Add support for sending simple messages from a string value.
* Add support for sending custom message parameters.

### `v0.5.5` (2015-07-19)

* Add support for symfony/options-resolver >= 2.6. (Bug reported by @adamgoose)

### `v0.5.4` (2015-05-14)

* Add methods for `chat.delete`, `chat.postMessage`, and `chat.update` API actions. (Courtesy @kordero)

### `v0.5.3` (2014-09-11)

* Miscellaneous fixes suggested by scrutinizer-ci.com

### `v0.5.2` (2014-09-11)

* Adds methods for the new `channels.join` and `channels.setPurpose` API actions. (Courtesy @tijsverkoyen)

### `v0.5.1` (2014-03-05)

* Upgrade composer requirements to the latest doctrine/collections

### `v0.5.0` (2014-03-04)

* Phlack now contains a (partial) implementation of the [Slack API](https://api.slack.com)
* Fixed some typos in the examples.

### `v0.4.6` (2014-02-18)

* [Attachment](src/Crummy/Phlack/Message/Attachment.php)s can now be created and added to the [MessageBuilder](src/Crummy/Phlack/Builder/MessageBuilder.php) via the `createAttachment()` workflow.
* [Message](src/Crummy/Phlack/Message/Message.php) now extends [Partial](src/Crummy/Phlack/Message/Partial.php), which now extends [Hash](src/Crummy/Phlack/Common/Hash.php), making Hash the common root for all incoming and outgoing message objects.
* Closures may now for be used Bot matchers, in addition to the previously defined [MatcherInterface](src/Crummy/Phlack/Common/Matcher/MatcherInterface.php).
* Added a `shout()` method to the ResponderInterface for alert notifications.
* [Link formatting](src/Crummy/Phlack/Common/Formatter/LinkFormatter.php) and [message escaping](src/Crummy/Phlack/Common/Formatter/EncodeFormatter.php), per [Slack Guidelines](https://api.slack.com/docs/formatting), is now included out of the box. All credit for the regex in the LinkFormatter is due [StevenSloan](https://github.com/stevenosloan) and his [slack-notifier](https://github.com/stevenosloan/slack-notifier) project.

### `v0.4.5` (2014-02-12)

Deprecated the `get*()` methods on Hash; replaced with protected properties.
Deprecated the `get*()` methods on CommandInterface; replaced with `get($key)`.
Added a `reply($user, $text)` to the ResponderInterface.
Added `reply($user, $text)` to the Iterocitor in the form of `@`-reply messages.
Fixed potential infinite loop problems in RepeaterBot by using the `reply()` method.

### `v0.4.3` (2014-02-10)

Fixed a bug in RepeaterBot that caused an infinite repeater loop.

### `v0.4.2` (2014-02-10)

Fixed errors in documentation related to the Phlack factory.
Added notes regarding username when configuring the PhlackClient.

### `v0.4.1` (2014-02-10)

Updated WebHook struct to match Slack changes.

### `v0.4.0` (2014-02-09)

Renamed ScrutinizingCollection to TypeCollection.
Replaced old SlashCommand with WebHooks implementation.
Added implementations for responding to Outgoing WebHooks and Slash Commands via Bots.
Added Bot Adapters for Symfony Console and Request.

### `v0.1.4` (2014-01-24)

Ensures MessageResponse is returned for success and error responses.

### `v0.1.3` (2014-01-24)

Adding MessageResponse class.

### `v0.1.2` (2014-01-24)

Adding basic documentation.
Adding SlashCommand message type.

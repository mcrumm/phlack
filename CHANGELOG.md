Changelog
=========

### `v0.4.4` (2014-02-12)

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

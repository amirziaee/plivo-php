#Plivo PHP API Client

A Plivo PHP API client

##### BETA

Please try it out, and let me know if things are working as expected.

## Setup

**Composer:**

```json
"require": {
	"bickart/plivo-php": "dev-master"
}
```

## Quickstart

#### Instantiate Plivo service

All following examples assume this step.

```php
$plivo = Bickart\Plivo\PlivoService::make('auth_id', 'auth_token');
```

#### Send a Message:

```php
$contact = $plivo->message()->send("YOUR PLIVO PHONE NUMBER", "RECIPIENT PHONE NUMBER", "TEXT MESSAGE");
```

## Status

(:ballot_box_with_check: Complete, :wavy_dash: In Progress, :white_medium_small_square: Todo, :black_medium_small_square: Not planned)

If you see something not planned, that you want, make an [issue](https://github.com/bickart/plivo-php/issues) and there's a good chance I will add it.

:wavy_dash: Account

:white_medium_small_square: Application

:white_medium_small_square: Call

:white_medium_small_square: Record

:white_medium_small_square: Conference

:white_medium_small_square: Endpoint

:ballot_box_with_check: Message

:white_medium_small_square: Number

:white_medium_small_square: Pricing

:white_medium_small_square: Recording

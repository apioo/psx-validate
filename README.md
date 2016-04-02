PSX Validate
===

## About

Validation library which validates arbitrary data using a flxeible filter
system.

## Usage

```php
<?php

$validate = new Validate();
$result   = $validate->validate($data, Validate::TYPE_STRING, [new Filter\Alnum(), new Filter\Length(3, 255)]);

if ($result->isSuccessful()) {
    echo 'Valid!';
} else {
    echo implode(', ', $result->getErrors());
}

```

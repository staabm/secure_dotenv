# secure_dotenv

The `secure_dotenv` library provides an easy way to handle the encryption and decryption of the information in your `.env` file.

One of the generally accepted security best practices is preventing the use of hard-coded, plain-text credentials of any kind. This library allows you to store the values in your `.env` as encrypted strings but still be able to access them transparently without worrying about implementing your own encryption method.

## Installation

### Download Composer package

You can install the library easily with a Composer `require` call on the command line:

```
composer require staabm/secure_dotenv
```

### Generate the key

First, you'll need to generate your encryption key. The library makes use of the [defuse/php-encryption](https://github.com/defuse/php-encryption) library for it's encryption handling.

```
php vendor/bin/generate-defuse-key
```

This will result in a randomized string to use with the `php-encryption` library's default encryption. This string should be placed in a file where the script can access it.

> **NOT:** According to security best practices, this key file should remain outside of the document root (not web accessible) but should be readable by the web server user (or executing user).

### Create the `.env` file

You'll then need to make the `.env` file you're wanting to place the values in:

```
touch /project/root/dir/.env
```

### Loading the values

With the key file and .env created, you can now create a new instance that can be used to read the encrypted values:

```php
<?php
require_once __DIR__.'/vendor/autoload.php';

$keyfile = __DIR__.'/keyfile';
$envFile = __DIR__.'/.env';

$d = new \staabm\SecureDotenv\Parser($keyfile, $envFile);

// The contents here is the set of all decrypted values fron the .env
print_r($d->getContent());
?>
```

You don't have to use a file as a source for the key either - you can use a string (potentially something fron an `$_ENV` variable or some other source):

```php
<?php
require_once __DIR__.'/vendor/autoload.php';

$key = $_ENV['ENCRYPTION_KEY'];
$envFile = __DIR__.'/.env';

$d = new \staabm\SecureDotenv\Parser($key, $envFile);

?>
```

This can be useful to help prevent the key from being read by a [local file inclusion](https://en.wikipedia.org/wiki/File_inclusion_vulnerability#Local_File_Inclusion) attack.


If there are values currently in your `.env` file that are unencrypted, the library will pass them over and just return the plain-text version as pulled directly from the `.env` configuration.

## Setting values

You can also dynamically set values into your `.env` file using the `save()` method on the `Parser` class:

```php
<?php
require_once __DIR__.'/vendor/autoload.php';

$keyfile = __DIR__.'/keyfile';
$envFile = __DIR__.'/.env';

$d = new \staabm\SecureDotenv\Parser($keyfile, $envFile);

$keyName = 'test1';
$keyValue = 'foobarbaz';

if ($d->save($keyName, $keyValue)) {
    echo 'Save successful';
} else {
    echo 'There was an error while saving the value.';
}
```

There's no need to worry about encrypting the value as the library takes care of that for you and outputs the encrypted result to the `.env` file.

## Encrypting values via CLI

This library also comes with a handy way to encrypt values and write them out to the `.env` configuration automatically:

```
vendor/bin/encrypt-env --keyfile=/path/to/keyfile
```

This tool will ask a few questions about the location of the `.env` file and the key/value pair to set. When it completes it will write the new, encrypted, value to the `.env` file. If a value is already set in the configuration and you want to overwrite it, call the `encrypt` script with the `--override` command line flag.


## Credits

this package is a maintained for of https://github.com/psecio/secure_dotenv originally created by [Chris Cornutt aka @enygma](https://github.com/enygma) 
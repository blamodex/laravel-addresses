# Blamodex Laravel Addresses

A lightweight Laravel package to manage postal addresses, countries and administrative areas, suitable for attaching addresses to any Eloquent model using polymorphic relationships.

---

## 🚀 Features

- Polymorphic `Address` model attachable to any Eloquent model via a trait
- Lookup tables for `Country` and `AdministrativeArea` with seeders and migrations
- Postal code normalization for common countries (`PostalCodeFormatter`) with a clear, nullable contract
- DB-backed `AddressValidator` to validate country, administrative area and postal codes
- Service layer (`AddressService`) for create/update/delete/list operations
- Soft deletes, UUID generation, and test coverage via Orchestra Testbench

---

## 📦 Installation

Install the package with Composer:

```bash
composer require blamodex/laravel-addresses
```

Publish the config file:

```bash
php artisan vendor:publish --tag=blamodex-address-config
```

Run the migrations:

```bash
php artisan migrate
```

---

## ⚙️ Configuration

Configuration lives in `config/address.php` (empty by default, but you can add options for formatting or validation):

```php
return [
    // e.g. 'default_country' => 'CA'
];
```

---

## 🧩 Usage

### 1. Use the `Addressable` trait on models

For models that can have addresses:

```php
use Blamodex\Address\Traits\Addressable;
use Blamodex\Address\Contracts\AddressableInterface;

class User extends Model implements AddressableInterface
{
    use Addressable;
}
```

### 2. Create an address

```php
$user = User::find(1);

// Using the trait method
$address = $user->createAddress([
    'address_1' => '100 Main St',
    'city' => 'Anytown',
    'administrative_area_code' => 'CA',
    'postal_code' => '90001',
    'country_code' => 'US',
]);

// Or using the service directly
$service = app(\Blamodex\Address\Services\AddressService::class);
$address = $service->create($user, $attributes);
```

### 3. Update an address

```php
$user->updateAddress($address, ['address_1' => '200 Main St']);

// Or via service
$service->update($address, ['address_1' => '200 Main St']);
```

### 4. Delete an address

```php
$user->deleteAddress($address);

// Or via service
$service->delete($address);
```

### 5. Validation

Use the `AddressValidator` to check attributes before persisting:

```php
$errors = \Blamodex\Address\Validators\AddressValidator::validate($attributes);
// Or throw on error
\Blamodex\Address\Validators\AddressValidator::validateOrFail($attributes);
```

`PostalCodeFormatter::format()` accepts `?string` and returns `?string` — `null` indicates invalid or unsupported postal code.

---

## 🧪 Testing

This package uses [Orchestra Testbench](https://github.com/orchestral/testbench) and [PHPUnit](https://phpunit.de/).

Run tests:

```bash
composer test
```

Run tests with code coverage:

```bash
composer test:coverage
```

Check code style:

```bash
composer lint
```
Check code style and fix:

```bash
composer lint:fix
```

Check static analysis (phpstan) and tests as part of CI as configured in the repo.

---

## 📁 Project Structure

```
src/
├── Models/
│   ├── Address.php
│   ├── Country.php
│   └── AdministrativeArea.php
├── Services/
│   └── AddressService.php
├── Traits/
│   └── Addressable.php
├── Contracts/
│   └── AddressableInterface.php
├── Validators/
│   └── AddressValidator.php
├── Utils/
│   └── PostalCodeFormatter.php
├── config/
│   └── address.php
└── database/
    ├── migrations/
    └── seeders/

tests/
├── Unit/
│   ├── AddressServiceTest.php
│   ├── AddressTest.php
│   ├── AdministrativeAreaTest.php
│   ├── CountryTest.php
│   ├── PostalCodeFormatterTest.php
│   └── AddressValidatorTest.php
├── Fixtures/
│   ├── DummyAddressUser.php
│   └── DummyAddressCompany.php
└── TestCase.php
```

---

## 📄 License

MIT © [Blamodex](https://github.com/blackmage-codex)
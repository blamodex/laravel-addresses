# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.0] - 2025-11-29

### Added
- Initial release
- Polymorphic Address model with soft deletes
- Country and AdministrativeArea lookup tables
- AddressService for CRUD operations
- Addressable trait for Eloquent models
- PostalCodeFormatter utility for US/CA postal codes
- AddressValidator for database-backed validation
- Complete test coverage (57 tests, 155 assertions)
- Migrations and seeders for countries and administrative areas
- Laravel service provider with auto-discovery

[Unreleased]: https://github.com/blamodex/laravel-addresses/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/blamodex/laravel-addresses/releases/tag/v1.0.0

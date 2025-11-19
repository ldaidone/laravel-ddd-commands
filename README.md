## 📦 Laravel DDD Commands

A lightweight toolkit that adds Domain-Driven Design scaffolding to any Laravel project.
Generate domains, use cases, entities, value objects, repositories, and more with expressive artisan commands — keeping your architecture clean and consistent with zero friction.

<p align="left"> <a href="LICENSE"><img alt="License" src="https://img.shields.io/badge/license-Apache%202.0-blue.svg"></a> <a href="#"><img alt="Tests" src="https://github.com/ldaidone/laravel-ddd-commands/actions/workflows/tests.yml/badge.svg"></a> <a href="#"><img alt="Coverage" src="https://img.shields.io/codecov/c/github/ldaidone/laravel-ddd-commands?style=flat-square"></a> <a href="https://packagist.org/packages/ldaidone/laravel-ddd-commands"><img alt="Packagist" src="https://img.shields.io/packagist/v/ldaidone/laravel-ddd-commands.svg"></a> <a href="https://packagist.org/packages/ldaidone/laravel-ddd-commands"><img alt="Downloads" src="https://img.shields.io/packagist/dt/ldaidone/laravel-ddd-commands.svg"></a> </p>

--- 
### ✨ Features

- 🔧 Generate domains, use cases, entities, value objects, repositories, and more
- ⚡ Works in any Laravel project (no special folder structure required)
- 🧩 Fully configurable namespace & path mappings
- 📁 Ships with clean, extensible stub templates
- 🧱 Encourages modular, maintainable DDD architecture
- 🚀 Zero learning curve — powered entirely through artisan commands
---
### 📦 Installation

```bash
composer require ldidone/laravel-ddd-commands
```

Laravel auto-discovers the service provider — no configuration needed.

---
### ▶️ Usage

#### Create a domain

```bash
php artisan ddd:create-domain Billing
```

#### Create a use case

```bash
php artisan ddd:create-use-case RegisterUser
```

#### Create an entity

```bash
php artisan ddd:create-entity User 
```

#### Create a value object

```bash
php artisan ddd:create-value-object Email
```

#### List available commands

```bash
php artisan list ddd
```
---
### 🗂 Default Folder Structure

The generator uses a clean, Laravel-friendly structure (fully customizable):

```markdown
app/
└── Domain/
    └── Billing/
        ├── Entities/
        ├── ValueObjects/
        ├── UseCases/
        ├── Repositories/
        └── Events/
```

You can override this via config/ddd.php (published automatically when needed).

---
### ⚙️ Configuration

To publish configuration + stubs:

```bash
php artisan vendor:publish --tag=ddd-config
php artisan vendor:publish --tag=ddd-stubs
```

This allows you to customize:
- folder paths
- namespace prefixes
- stub templates
- repository patterns
- additional generators

---
### 🧪 Running Tests

```bash
composer test
```

If you're using Pest or PHPUnit, the workflow will handle it automatically.

---
### 📊 Test Coverage

If using Codecov:

```bash
vendor/bin/phpunit --coverage-clover=coverage.xml
```

GitHub Actions will upload coverage after each test run.

---
### 📚 Roadmap

- Aggregate root generator
- Domain event generator
- DTO generator
- CQRS mode (query/command separation)
- Optional Eloquent repository scaffolding

---
### 🤝 Contributing

Pull requests are welcome. Please open an issue first for major changes.
Make sure to update tests as needed.

--- 
### 📄 License

Released under the [Apache 2.0 license](LICENSE).
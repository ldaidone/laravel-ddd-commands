## 📦 Laravel DDD Commands

A lightweight toolkit that adds Domain-Driven Design scaffolding to any Laravel project.
Generate domains, use cases, entities, value objects, repositories, events, aggregates, DTOs, actions, and more with expressive artisan commands using the pattern `<domain_name>/<element_name>` — keeping your architecture clean and consistent with zero friction.

<p align="left"> <a href="LICENSE"><img alt="License" src="https://img.shields.io/badge/license-Apache%202.0-blue.svg"></a> <a href="#"><img alt="Tests" src="https://github.com/ldaidone/laravel-ddd-commands/actions/workflows/tests.yml/badge.svg"></a> <a href="#"><img alt="Coverage" src="https://img.shields.io/codecov/c/github/ldaidone/laravel-ddd-commands?style=flat-square"></a> <a href="https://packagist.org/packages/ldaidone/laravel-ddd-commands"><img alt="Packagist" src="https://img.shields.io/packagist/v/ldaidone/laravel-ddd-commands.svg"></a> <a href="https://packagist.org/packages/ldaidone/laravel-ddd-commands"><img alt="Downloads" src="https://img.shields.io/packagist/dt/ldaidone/laravel-ddd-commands.svg"></a> </p>

---

### ✨ Features

- 🔧 Generate domains, use cases, entities, value objects, repositories, events, aggregates, DTOs, commands, queries, and actions
- ⚡ Works in any Laravel project (no special folder structure required)
- 🧩 Consistent naming convention: `<domain_name>/<element_name>` for all generators
- 🧩 Fully configurable namespace & path mappings
- 📁 Ships with clean, extensible stub templates for all generators
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

> **Important:** All generators follow the format `<domain_name>/<element_name>`, where `domain_name` corresponds to a domain folder and `element_name` is the name of the element you want to create.

#### Create a domain

```bash
php artisan ddd:create-domain Billing
```

#### Create a use case

```bash
php artisan ddd:create-use-case Billing/RegisterUser
```

#### Create an entity

```bash
php artisan ddd:create-entity Billing/User
```

#### Create a value object

```bash
php artisan ddd:create-value-object Billing/Email
```

#### Create a repository

```bash
php artisan ddd:create-repository Billing/UserRepository
```

#### Create a domain event

```bash
php artisan ddd:create-event Billing/UserRegistered
```

#### Create an aggregate

```bash
php artisan ddd:create-aggregate Billing/Order
```

#### Create a DTO (Data Transfer Object)

```bash
php artisan ddd:create-dto Billing/UserDto
```

#### Create a command

```bash
php artisan ddd:create-command Billing/RegisterUser
```

#### Create a query

```bash
php artisan ddd:create-query Billing/GetUserById
```

#### Create an action

```bash
php artisan ddd:create-action Billing/SendEmail
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
        ├── DataTransferObjects/
        ├── UseCases/
        ├── Actions/
        ├── Repositories/
        └── Events/
```

You can override this via config/ddd.php (published automatically when needed).

---

### ⚙️ Configuration

To publish configuration + stubs:

```bash
php artisan vendor:publish --tag=ddd-commands-config
php artisan vendor:publish --tag=ddd-commands-stubs
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

- [x] Aggregate root generator
- [x] Domain event generator
- [x] DTO generator
- [x] Action generator
- [x] CQRS mode (command/query separation)
- Repository implementation generator (Eloquent/Query Builder)

---

## Support

If this saves you time or helps your project, consider starring ⭐
and consider [buying me a coffee](https://www.buymeacoffee.com/leodaido)! ☕️ — it keeps the ideas flowing!

---

### 🤝 Contributing

Pull requests are welcome. Please open an issue first for major changes.
Make sure to update tests as needed.

---

### 📄 License

Released under the [Apache 2.0 license](LICENSE).
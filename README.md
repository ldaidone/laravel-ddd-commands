## 📦 Laravel DDD Commands

A lightweight toolkit that adds Domain-Driven Design scaffolding to any Laravel project.
Generate domains, use cases, entities, value objects, repositories, events, aggregates, DTOs, actions, and more with expressive artisan commands using the pattern `<domain_name>/<element_name>` — keeping your architecture clean and consistent with zero friction.

<p align="left"> <a href="LICENSE"><img alt="License" src="https://img.shields.io/badge/license-Apache%202.0-blue.svg"></a> <a href="#"><img alt="Tests" src="https://github.com/ldaidone/laravel-ddd-commands/actions/workflows/tests.yml/badge.svg"></a> <a href="#"><img alt="Coverage" src="https://img.shields.io/codecov/c/github/ldaidone/laravel-ddd-commands?style=flat-square"></a> <a href="https://packagist.org/packages/ldaidone/laravel-ddd-commands"><img alt="Packagist" src="https://img.shields.io/packagist/v/ldaidone/laravel-ddd-commands.svg"></a> <a href="https://packagist.org/packages/ldaidone/laravel-ddd-commands"><img alt="Downloads" src="https://img.shields.io/packagist/dt/ldaidone/laravel-ddd-commands.svg"></a> </p>


[!["Buy Me A Coffee"](https://www.buymeacoffee.com/assets/img/custom_images/orange_img.png)](https://www.buymeacoffee.com/leodaido)

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

### 🏗 About the Folder Structure (Important)

As of **v0.1.1**, the package **no longer uses configuration files or dynamic paths**.

This is an intentional design choice.

#### Why?
Because dynamic paths introduce architectural drift.
For DDD, structure must be **stable, predictable, enforceable**, and the same across dev machines, CI runners, and Testbench environments.

The generators now follow a single, consistent convention:

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
This improves:

* maintainability
* discovery
* onboarding
* large-scale refactors
* automated testing consistency

No config required. No hidden layer. No dynamic directories.

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
- [ ] Repository implementation generator (Eloquent/Query Builder)

---

## Support

If this saves you time or helps your project, consider starring ⭐
and consider [buying me a coffee](https://www.buymeacoffee.com/leodaido)! ☕️ — it keeps the ideas flowing!

---

### 🤝 Contributing

Pull requests are welcome. Please open an issue first for major changes.
Make sure to update tests as needed.

---

### 📚 Changelog

See [CHANGELOG.md](CHANGELOG.md)

---

### 📄 License

Released under the [Apache 2.0 license](LICENSE).
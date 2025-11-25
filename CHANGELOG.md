# Changelog

## v0.1.1 — 2025-11-25

### Added
- Full support for Laravel **12.x**.
- Automatic Testbench sandbox detection for safe generator output in tests.

### Changed
- Removed the `config/ddd.php` file and all dynamic path overrides.  
  This is an intentional design decision to enforce a stable, opinionated DDD folder structure across all Laravel projects.
- Unified path + namespace resolution logic across all generators.
- Updated all tests to assert against the new stable structure and sandbox paths.

### Fixed
- Inconsistent path generation between Testbench and real applications.
- Legacy behavior that allowed unpredictable domain paths.
- Namespace inconsistencies in several generators.
- Command exit codes in Feature tests.
- Stub resolution issues when running from vendor or package source.

### Notes
This release focuses on architectural stability.  
Dynamic path customization was removed because it worked **against** DDD principles: it created unpredictable file layouts, made generators harder to reason about, and complicated automated testing.  
A fixed, opinionated structure keeps domains consistent and easier to maintain, especially in larger projects.

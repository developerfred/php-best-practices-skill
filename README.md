# PHP Best Practices Skill

A skill for AI agents implementing PHP best practices based on TiendaNube's PHP Programming Best Practices guide.

## Overview

This skill provides guidelines, rules, and examples for writing clean, maintainable PHP code following object-oriented principles and SOLID design patterns. It's designed to help AI agents:

1. Write new PHP code following best practices
2. Review existing PHP code for violations
3. Refactor PHP code to improve quality
4. Apply SOLID design principles

## Skill Structure

```
skills-php/
├── SKILL.md                    # Main skill documentation with all rules
├── README.md                   # This file
├── scripts/
│   └── analyze-php-code.sh     # Script to analyze PHP code for violations
└── examples/
    ├── GoodProduct.php         # Example of good PHP code
    └── BadProduct.php          # Example of bad PHP code (anti-patterns)
```

## Installation

For agents supporting the skills.sh format:

```bash
npx skills add <owner>/php-best-practices
```

## Usage

The skill automatically activates when the agent detects PHP-related tasks:

- Writing PHP classes or functions
- Reviewing PHP code
- Refactoring PHP code
- Implementing SOLID principles
- Writing tests for PHP code

### Manual Reference

Agents can reference specific rules from the skill:

```
Apply the `naming-descriptive` rule when naming variables.
Use the `solid-single-responsibility` principle for this class design.
Check for `variable-avoid-magic` violations in this code.
```

## Rule Categories

The skill is organized into 7 categories:

1. **Naming Conventions** - Descriptive names, camelCase, avoiding context pollution
2. **Variables and Constants** - Avoiding magic values, explanatory variables
3. **SOLID Principles** - Single responsibility, open/closed, Liskov substitution, etc.
4. **Methods and Functions** - Type declarations, single responsibility, avoiding side effects
5. **Conditionals** - Avoiding complex logic, guard clauses, encapsulation
6. **Classes and Objects** - Final classes, private properties, composition over inheritance
7. **Testing** - Arrange-Act-Assert pattern, descriptive names, isolation

## Examples

### Good Code Example

See `examples/GoodProduct.php` for:
- Type declarations
- Constants instead of magic values
- Guard clauses instead of else statements
- Private properties with getters
- Constructor over setters
- Interface segregation
- Proper error handling

### Bad Code Example

See `examples/BadProduct.php` for:
- Poor naming conventions
- Magic string values
- Deep nesting in conditionals
- Public setters allowing invalid state
- Functions with too many arguments
- Side effects in functions
- Returning null

## Scripts

The `scripts/analyze-php-code.sh` script can be used to analyze PHP code for common violations:

```bash
./scripts/analyze-php-code.sh --directory ./src --verbose
```

The script checks for:
- PHP syntax errors
- Magic string values
- Missing type declarations
- Else statements
- Deep nesting patterns

## Based On

This skill is based on the [TiendaNube PHP Programming Best Practices](https://github.com/TiendaNube/php-programming-best-practices) guide, which is MIT licensed.

## Skill Format

This skill follows the [Vercel skills.sh](https://skills.sh) format for AI agent skills, with:
- YAML frontmatter in SKILL.md
- Organized rule categories
- Concrete code examples
- Practical scripts for automation

## License

MIT
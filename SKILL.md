---
name: php-best-practices
description: PHP programming best practices and clean code guidelines from TiendaNube and the PHP community. This skill should be used when writing, reviewing, or refactoring PHP code to ensure clean code principles and SOLID design patterns. Triggers on tasks involving PHP classes, functions, object-oriented design, refactoring, or code review.
license: MIT
metadata:
  author: TiendaNube Community
  version: "1.0.0"
  source: https://github.com/TiendaNube/php-programming-best-practices
---

# PHP Best Practices

Comprehensive clean code and best practices guide for PHP development, based on TiendaNube's programming guidelines and SOLID principles. Contains 45+ rules across 7 categories to guide automated refactoring, code generation, and code review.

## When to Apply

Reference these guidelines when:
- Writing new PHP classes, functions, or methods
- Implementing object-oriented PHP code
- Reviewing PHP code for clean code violations
- Refactoring existing PHP code
- Applying SOLID design principles
- Writing or reviewing tests for PHP code

## Rule Categories by Priority

| Priority | Category | Impact | Prefix |
|----------|----------|--------|--------|
| 1 | Naming Conventions | HIGH | `naming-` |
| 2 | Variables and Constants | HIGH | `variable-` |
| 3 | SOLID Principles | HIGH | `solid-` |
| 4 | Methods and Functions | MEDIUM | `method-` |
| 5 | Conditionals | MEDIUM | `conditional-` |
| 6 | Classes and Objects | MEDIUM | `class-` |
| 7 | Testing | MEDIUM | `test-` |

## Quick Reference

### 1. Naming Conventions (HIGH)

- `naming-descriptive` - Use descriptive names that reflect purpose
- `naming-camel-case` - Use camelCase for variables, methods, functions
- `naming-avoid-magic` - Avoid magic values, use constants
- `naming-context` - Don't add unnecessary context to variable names
- `naming-meaningful` - Use meaningful names, not abbreviations

### 2. Variables and Constants (HIGH)

- `variable-avoid-magic` - Use constants instead of magic values
- `variable-explanatory` - Use explanatory variables for complex logic
- `variable-avoid-deep-nesting` - Avoid deep nesting in conditionals
- `variable-final-by-default` - Use final classes by default
- `variable-private-by-default` - Use private properties by default

### 3. SOLID Principles (HIGH)

- `solid-single-responsibility` - Single Responsibility Principle (SRP)
- `solid-open-closed` - Open/Closed Principle (OCP)
- `solid-liskov-substitution` - Liskov Substitution Principle (LSP)
- `solid-interface-segregation` - Interface Segregation Principle (ISP)
- `solid-dependency-inversion` - Dependency Inversion Principle (DIP)
- `solid-dry` - Don't Repeat Yourself (DRY)
- `solid-tell-dont-ask` - Tell, Don't Ask principle

### 4. Methods and Functions (MEDIUM)

- `method-type-declarations` - Use type declarations for parameters and returns
- `method-few-arguments` - Limit function arguments (2 or fewer ideally)
- `method-single-responsibility` - Functions should do one thing
- `method-small-size` - Keep functions small (20 lines or less)
- `method-descriptive-names` - Function names should indicate what they do
- `method-single-abstraction` - Functions should have one level of abstraction
- `method-avoid-flags` - Avoid boolean flags as parameters
- `method-avoid-side-effects` - Avoid side effects in functions
- `method-avoid-null` - Avoid returning null, use exceptions or empty values

### 5. Conditionals (MEDIUM)

- `conditional-avoid-complex` - Avoid complex conditional logic
- `conditional-avoid-negative` - Avoid negative conditionals
- `conditional-avoid-type-check` - Avoid type checking, use polymorphism
- `conditional-encapsulate` - Encapsulate conditions in methods
- `conditional-avoid-else` - Avoid else statements, use guard clauses

### 6. Classes and Objects (MEDIUM)

- `class-final-default` - Make classes final by default
- `class-private-properties` - Make properties private by default
- `class-constructor-over-setters` - Use constructors over public setters
- `class-composition-over-inheritance` - Prefer composition over inheritance
- `class-small-cohesive` - Keep classes small and cohesive

### 7. Testing (MEDIUM)

- `test-arrange-act-assert` - Follow Arrange-Act-Assert pattern
- `test-descriptive-names` - Use descriptive test method names
- `test-one-assert-per-test` - One assertion per test method (when possible)
- `test-isolation` - Tests should be isolated from each other
- `test-fast` - Tests should run fast

## Detailed Rules

### Naming Conventions

#### `naming-descriptive`
Use descriptive names that clearly indicate purpose and context.

**Bad:**
```php
$ymdstr = $moment->format('y-m-d');
```

**Good:**
```php
$currentDate = $moment->format('y-m-d');
```

#### `naming-camel-case`
Use camelCase for variables, methods, and functions.

**Bad:**
```php
$customerphone = '1134971828';
public function calculate_product_price(int $productid, int $quantity)
```

**Good:**
```php
$customerPhone = '1134971828';
public function calculateProductPrice(int $productId, int $quantity)
```

### Variables and Constants

#### `variable-avoid-magic`
Avoid magic values; use constants instead.

**Bad:**
```php
class Payment 
{
    public function isPending()
    {
        if ($this->status === "pending") { 
            // logic here 
        }
    }
}
```

**Good:**
```php
class Payment 
{
    const STATUS_PENDING = 'pending';

    public function isPending()
    {
        if ($this->status === self::STATUS_PENDING) { 
            // logic here 
        }
    }
}
```

#### `variable-explanatory`
Use explanatory variables for complex logic.

**Bad:**
```php
$address = 'Avenida Rivadavia 1678, 1406';
$cityZipCodeRegex = '/^[^,]+,\s*(.+?)\s*(\d{4})$/';
preg_match($cityZipCodeRegex, $address, $matches);
saveCityZipCode($matches[1], $matches[2]);
```

**Good:**
```php
$address = 'Avenida Rivadavia 1678, 1406';
$cityZipCodeRegex = '/^[^,]+,\s*(?<street>.+?)\s*(?<zipCode>\d{4})$/';
preg_match($cityZipCodeRegex, $address, $matches);
saveCityZipCode($matches['street'], $matches['zipCode']);
```

### SOLID Principles

#### `solid-single-responsibility`
A class should have only one reason to change.

**Bad:**
```php
class Page 
{
    private string $title;
    
    public function title(): string 
    {
        return $this->title;
    }
    
    public function formatJson() 
    {
        return json_encode($this->title());
    }
}
```

**Good:**
```php
class Page 
{
    private string $title;
 
    public function title(): string
    {
        return $this->title;    
    }
}
 
class JsonPageFormatter 
{
    public function format(Page $page)
    {
        return  json_encode($page->title());
    }
}
```

#### `solid-open-closed`
Software entities should be open for extension but closed for modification.

**Bad:**
```php
class Customer
{
    public function pay(float $total, CreditCardPayment $paymentMethod)
    {
        $paymentMethod->execute($total);
    }
}
```

**Good:**
```php
interface PaymentMethod
{
    public function execute(float $total);
}

class Customer
{
    public function pay(float $total, PaymentMethod $paymentMethod)
    {
        $paymentMethod->execute($total);
    }
}

class CreditCardPayment implements PaymentMethod
{
    public function execute(float $total)
    {
        // credit card payment logic
    }
}
```

### Methods and Functions

#### `method-type-declarations`
Use type declarations for parameters and return values.

**Bad:**
```php
function sum($val1, $val2)
{
    return $val1 + $val2;
}
```

**Good:**
```php
function sum(int $val1, int $val2): int
{
    return $val1 + $val2;
}
```

#### `method-few-arguments`
Limit function arguments; 2 or fewer is ideal.

**Bad:**
```php
function createProduct(string $title, string $description, float $price, int $stock): void
{
    // ...
}
```

**Good:**
```php
class ProductConfig
{
    private string $title;
    private string $description;
    private float $price;
    private int $stock;

    public function __construct(string $title, string $description, float $price, int $stock) 
    {
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
    }
}

function createProduct(ProductConfig $config): void
{
    // ...
}
```

### Conditionals

#### `conditional-avoid-else`
Avoid else statements; use guard clauses instead.

**Bad:**
```php
if ($product->hasStock()) {
    // much code...
} else {
    return false;
}
```

**Good:**
```php
if (!$product->hasStock()) {
    return false;
}

// code...
```

#### `conditional-avoid-complex`
Avoid complex conditional logic with deep nesting.

**Bad:**
```php
function isShopOpen($day): bool
{
    if ($day) {
        if (is_string($day)) {
            $day = strtolower($day);
            if ($day === 'friday') {
                return true;
            } elseif ($day === 'saturday') {
                return true;
            } elseif ($day === 'sunday') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}
```

**Good:**
```php
function isShopOpen(string $day): bool
{
    if (empty($day)) {
        return false;
    }

    $openingDays = [
        'friday', 'saturday', 'sunday'
    ];

    return in_array(strtolower($day), $openingDays, true);
}
```

### Classes and Objects

#### `class-final-default`
Make classes final by default.

**Good:**
```php
final class Employee
{
    // code...
}
```

#### `class-private-properties`
Make properties private by default.

**Bad:**
```php
final class Product
{
    public float $price = 1000.00;
}
```

**Good:**
```php
final class Product
{
    private float $price = 1000.00;
    
    public function getPrice(): float
    {
        return $this->price;
    }
}
```

#### `class-composition-over-inheritance`
Prefer composition over inheritance.

**Bad:**
```php
class Vehicle
{    
    public function move()
    {
        echo "Move the car";
    }    
}

class Car extends Vehicle
{
    public function accelerate()
    {    
        $this->move();    
    }
}
```

**Good:**
```php
interface MoveVehicle
{
    public function move();
}

final class Vehicle implements MoveVehicle
{    
    public function move()
    {
        echo "Move the car";
    }    
}

final class Car
{
    private MoveVehicle $vehicle;

    public function __construct(MoveVehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function accelerate()
    {    
        $this->vehicle->move();    
    }
}
```

## Testing Guidelines

### `test-arrange-act-assert`
Follow the Arrange-Act-Assert pattern in tests.

**Good:**
```php
public function testCalculateTotal(): void
{
    // Arrange
    $calculator = new Calculator();
    $items = [new Item(10.0), new Item(20.0)];
    
    // Act
    $total = $calculator->calculateTotal($items);
    
    // Assert
    $this->assertEquals(30.0, $total);
}
```

### `test-descriptive-names`
Use descriptive test method names.

**Bad:**
```php
public function test1(): void
```

**Good:**
```php
public function testCalculateTotalReturnsCorrectSum(): void
```

## How to Use This Skill

1. **For code review:** Scan PHP code against these rules to identify violations
2. **For code generation:** Apply these rules when writing new PHP code
3. **For refactoring:** Use specific rule references to guide refactoring efforts
4. **For architecture:** Apply SOLID principles when designing PHP class hierarchies

## Implementation Notes

- This skill is optimized for PHP 7.0+ with type declarations
- Rules are prioritized by impact on code quality and maintainability
- Each rule includes concrete examples of "bad" and "good" code
- The skill follows the TiendaNube PHP best practices document structure

## License

This skill is based on the TiendaNube PHP Programming Best Practices document (MIT licensed) and follows the Vercel skills.sh format.
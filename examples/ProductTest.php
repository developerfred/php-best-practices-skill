<?php

declare(strict_types=1);

namespace Examples\Tests;

use Examples\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /** @test */
    public function productCanBeCreatedWithValidData(): void
    {
        // Arrange
        $id = 1;
        $name = 'Laptop';
        $price = 999.99;
        $stock = 10;
        
        // Act
        $product = new Product($id, $name, $price, $stock);
        
        // Assert
        $this->assertSame($id, $product->getId());
        $this->assertSame($name, $product->getName());
        $this->assertSame($price, $product->getPrice());
        $this->assertSame($stock, $product->getStock());
        $this->assertTrue($product->isActive());
        $this->assertTrue($product->hasStock());
    }
    
    /** @test */
    public function productCreationFailsWithNegativePrice(): void
    {
        // Arrange
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Price must be positive');
        
        // Act & Assert
        new Product(1, 'Laptop', -100.0, 10);
    }
    
    /** @test */
    public function productCreationFailsWithNegativeStock(): void
    {
        // Arrange
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Stock cannot be negative');
        
        // Act & Assert
        new Product(1, 'Laptop', 100.0, -5);
    }
    
    /** @test */
    public function calculateTotalPriceReturnsCorrectValue(): void
    {
        // Arrange
        $product = new Product(1, 'Laptop', 500.0, 10);
        $quantity = 3;
        $expectedTotal = 1500.0;
        
        // Act
        $actualTotal = $product->calculateTotalPrice($quantity);
        
        // Assert
        $this->assertSame($expectedTotal, $actualTotal);
    }
    
    /** @test */
    public function calculateTotalPriceFailsWithZeroQuantity(): void
    {
        // Arrange
        $product = new Product(1, 'Laptop', 500.0, 10);
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Quantity must be positive');
        
        // Act & Assert
        $product->calculateTotalPrice(0);
    }
    
    /** @test */
    public function calculateTotalPriceFailsWithNegativeQuantity(): void
    {
        // Arrange
        $product = new Product(1, 'Laptop', 500.0, 10);
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Quantity must be positive');
        
        // Act & Assert
        $product->calculateTotalPrice(-2);
    }
    
    /** @test */
    public function hasStockReturnsFalseWhenStockIsZero(): void
    {
        // Arrange
        $product = new Product(1, 'Laptop', 500.0, 0);
        
        // Act & Assert
        $this->assertFalse($product->hasStock());
    }
    
    /** @test */
    public function calculateTotalPriceFailsWhenOutOfStock(): void
    {
        // Arrange
        $product = new Product(1, 'Laptop', 500.0, 0);
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Product out of stock');
        
        // Act & Assert
        $product->calculateTotalPrice(1);
    }
    
    /** @test */
    public function productIsActiveByDefault(): void
    {
        // Arrange
        $product = new Product(1, 'Laptop', 500.0, 10);
        
        // Act & Assert
        $this->assertTrue($product->isActive());
    }
}

// Example of a test with poor practices (for comparison)
class BadProductTest extends TestCase
{
    public function test1(): void
    {
        $p = new \Examples\Product(1, 'test', 100, 5);
        
        // Multiple assertions in one test
        $this->assertEquals(1, $p->getId());
        $this->assertEquals('test', $p->getName());
        $this->assertEquals(100, $p->getPrice());
        $this->assertEquals(5, $p->getStock());
        $this->assertTrue($p->isActive());
        
        // Testing multiple different behaviors
        $this->assertEquals(200, $p->calculateTotalPrice(2));
        $this->assertTrue($p->hasStock());
        
        // No clear Arrange-Act-Assert separation
        // No descriptive test method name
        // Testing too many things at once
    }
    
    public function testEverything(): void
    {
        // This test method name is not descriptive
        // It's trying to test too many things
        
        $p = new \Examples\Product(1, 'x', 10, 0);
        $this->assertFalse($p->hasStock());
        
        $p2 = new \Examples\Product(2, 'y', 20, 5);
        $this->assertTrue($p2->hasStock());
        $this->assertEquals(40, $p2->calculateTotalPrice(2));
        
        // Mixed test cases in one method
        // Hard to understand what's being tested
        // If one assertion fails, others won't run
    }
}
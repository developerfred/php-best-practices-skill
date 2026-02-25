<?php

declare(strict_types=1);

namespace Examples;

interface ProductRepository
{
    public function findById(int $id): ?Product;
    public function save(Product $product): void;
}

final class Product
{
    private int $id;
    private string $name;
    private float $price;
    private int $stock;
    
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    
    private string $status = self::STATUS_ACTIVE;

    public function __construct(int $id, string $name, float $price, int $stock)
    {
        $this->id = $id;
        $this->name = $name;
        $this->setPrice($price);
        $this->setStock($stock);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function hasStock(): bool
    {
        return $this->stock > 0;
    }

    public function calculateTotalPrice(int $quantity): float
    {
        if (!$this->hasStock()) {
            throw new \RuntimeException('Product out of stock');
        }

        if ($quantity <= 0) {
            throw new \InvalidArgumentException('Quantity must be positive');
        }

        return $this->price * $quantity;
    }

    private function setPrice(float $price): void
    {
        if ($price <= 0) {
            throw new \InvalidArgumentException('Price must be positive');
        }
        
        $this->price = $price;
    }

    private function setStock(int $stock): void
    {
        if ($stock < 0) {
            throw new \InvalidArgumentException('Stock cannot be negative');
        }
        
        $this->stock = $stock;
    }
}

final class ProductService
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function purchaseProduct(int $productId, int $quantity): float
    {
        $product = $this->repository->findById($productId);
        
        if ($product === null) {
            throw new \RuntimeException('Product not found');
        }

        if (!$product->isActive()) {
            throw new \RuntimeException('Product is not active');
        }

        $total = $product->calculateTotalPrice($quantity);
        
        // In a real application, you would update stock here
        // and save the product
        
        return $total;
    }
}

// Example usage
class InMemoryProductRepository implements ProductRepository
{
    private array $products = [];

    public function findById(int $id): ?Product
    {
        return $this->products[$id] ?? null;
    }

    public function save(Product $product): void
    {
        $this->products[$product->getId()] = $product;
    }
}

// Test example
$repository = new InMemoryProductRepository();
$product = new Product(1, 'Laptop', 999.99, 10);
$repository->save($product);

$service = new ProductService($repository);

try {
    $total = $service->purchaseProduct(1, 2);
    echo "Total price: $" . number_format($total, 2) . PHP_EOL;
} catch (\RuntimeException $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
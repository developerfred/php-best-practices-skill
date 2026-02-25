<?php

// Bad example demonstrating common PHP anti-patterns

class bad_product
{
    public $product_id;
    public $product_name;
    public $product_price;
    public $product_stock;
    public $st;
    
    function __construct($id, $nm, $prc, $stk)
    {
        $this->product_id = $id;
        $this->product_name = $nm;
        $this->product_price = $prc;
        $this->product_stock = $stk;
        $this->st = "active";
    }
    
    function get_total($qty)
    {
        if ($this->st == "active") {
            if ($this->product_stock > 0) {
                if ($qty > 0) {
                    return $this->product_price * $qty;
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
    
    function set_price($val)
    {
        $this->product_price = $val;
    }
    
    function set_stock($val)
    {
        $this->product_stock = $val;
    }
}

class product_service
{
    public $repo;
    
    function do_purchase($pid, $qty)
    {
        $prod = $this->repo->get_product($pid);
        
        if ($prod !== null) {
            if ($prod->st == "active") {
                $total = $prod->get_total($qty);
                if ($total !== false) {
                    return $total;
                } else {
                    if ($qty <= 0) {
                        throw new Exception("bad qty");
                    } else {
                        throw new Exception("no stock");
                    }
                }
            } else {
                throw new Exception("not active");
            }
        } else {
            throw new Exception("not found");
        }
    }
}

// Usage example with magic values and poor error handling
$bad_product = new bad_product(1, "Laptop", 999.99, 10);
$bad_product->set_price(899.99); // Public setter allows invalid state
$bad_product->set_stock(-5); // Negative stock allowed

try {
    $result = $bad_product->get_total(2);
    if ($result !== false) {
        echo "Total: $result\n";
    } else {
        echo "Failed\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Deep nesting and complex conditionals
function check_order_status($order, $user, $payment)
{
    if ($order) {
        if ($order['status'] == "processing") {
            if ($user) {
                if ($user['active'] == true) {
                    if ($payment) {
                        if ($payment['status'] == "completed") {
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

// Function with too many arguments
function create_user_profile($username, $email, $password, $first_name, $last_name, $age, $address, $phone, $newsletter)
{
    // Too many parameters
    return [
        'username' => $username,
        'email' => $email,
        // ... and so on
    ];
}

// Function with side effects and no return type
function process_data($data)
{
    global $database; // Using global variable
    
    if (!empty($data)) {
        $result = $database->query("INSERT INTO data VALUES ('$data')");
        
        // Side effect: sending email
        mail('admin@example.com', 'Data processed', 'Data was processed');
        
        // Side effect: logging
        file_put_contents('log.txt', date('Y-m-d H:i:s') . " - Processed data\n", FILE_APPEND);
        
        return $result;
    }
    
    return null; // Returning null
}
<?php
session_start();
include('./includes/connect.php');

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle cart operations
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'add_to_cart':
            addToCart();
            break;
        case 'update_cart':
            updateCart();
            break;
        case 'clear_cart':
            clearCart();
            break;
        case 'remove_item':
            removeItem();
            break;
        case 'get_cart_count':
            getCartCount();
            break;
    }
}

function addToCart() {
    if (!isset($_POST['product_id']) || !isset($_POST['product_name'])) {
        echo json_encode(['success' => false, 'message' => 'Missing product data']);
        exit;
    }

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = floatval($_POST['product_price']);
    $product_image = $_POST['product_image'] ?? 'default.jpg';
    $quantity = intval($_POST['quantity'] ?? 1);
    
    // Check if product already exists in cart
    $existing_item_index = array_search($product_id, array_column($_SESSION['cart'], 'product_id'));
    
    if ($existing_item_index !== false) {
        // Update quantity if product exists
        $_SESSION['cart'][$existing_item_index]['quantity'] += $quantity;
    } else {
        // Add new item to cart
        $new_item = [
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_image' => $product_image,
            'quantity' => $quantity
        ];
        $_SESSION['cart'][] = $new_item;
    }
    
    echo json_encode([
        'success' => true, 
        'cart_count' => getTotalCartItems(),
        'cart_items' => $_SESSION['cart'],
        'message' => 'Product added to cart successfully!'
    ]);
    exit;
}

function updateCart() {
    if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
        echo json_encode(['success' => false, 'message' => 'Missing data']);
        exit;
    }

    $product_id = $_POST['product_id'];
    $quantity = intval($_POST['quantity']);
    
    $item_index = array_search($product_id, array_column($_SESSION['cart'], 'product_id'));
    
    if ($item_index !== false) {
        if ($quantity <= 0) {
            // Remove item if quantity is 0 or less
            array_splice($_SESSION['cart'], $item_index, 1);
        } else {
            // Update quantity
            $_SESSION['cart'][$item_index]['quantity'] = $quantity;
        }
        echo json_encode([
            'success' => true,
            'cart_count' => getTotalCartItems(),
            'totals' => calculateCartTotals(),
            'message' => 'Cart updated successfully!'
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Product not found in cart']);
    }
    exit;
}

function removeItem() {
    if (!isset($_POST['product_id'])) {
        echo json_encode(['success' => false, 'message' => 'Missing product ID']);
        exit;
    }

    $product_id = $_POST['product_id'];
    
    $item_index = array_search($product_id, array_column($_SESSION['cart'], 'product_id'));
    
    if ($item_index !== false) {
        array_splice($_SESSION['cart'], $item_index, 1);
        echo json_encode([
            'success' => true,
            'cart_count' => getTotalCartItems(),
            'totals' => calculateCartTotals(),
            'message' => 'Item removed from cart!'
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Product not found in cart']);
    }
    exit;
}

function clearCart() {
    $_SESSION['cart'] = [];
    echo json_encode([
        'success' => true,
        'cart_count' => 0,
        'totals' => calculateCartTotals(),
        'message' => 'Cart cleared successfully!'
    ]);
    exit;
}

function getCartCount() {
    echo json_encode([
        'success' => true,
        'cart_count' => getTotalCartItems(),
        'cart_items' => $_SESSION['cart'],
        'totals' => calculateCartTotals()
    ]);
    exit;
}

function getTotalCartItems() {
    $total = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['quantity'];
        }
    }
    return $total;
}

// Calculate cart totals
function calculateCartTotals() {
    $subtotal = 0;
    $tax_rate = 0.08; // 8% tax
    $shipping = 5.00; // Flat rate shipping
    
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $subtotal += $item['product_price'] * $item['quantity'];
        }
    }
    
    $tax = $subtotal * $tax_rate;
    $total = $subtotal + $tax + $shipping;
    
    return [
        'subtotal' => round($subtotal, 2),
        'tax' => round($tax, 2),
        'shipping' => $shipping,
        'total' => round($total, 2)
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - My Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .cart-item {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
            transition: all 0.3s ease;
        }
        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .cart-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            position: sticky;
            top: 20px;
        }
        .empty-cart {
            text-align: center;
            padding: 50px 0;
        }
        .cart-item-removing {
            opacity: 0;
            transform: translateX(-100%);
        }
        .item-total {
            font-weight: bold;
            color: #198754;
        }
        .btn-actions {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <img src="images/download.png" class="logo" style="height: 40px;">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="displayall.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link active" href="cart.php">Cart</a></li>
                </ul>
                <div class="navbar-nav">
                    <a class="nav-link" href="cart.php">
                        <i class="fa-solid fa-cart-shopping"></i> 
                        <span id="cart-count" class="badge bg-danger"><?= getTotalCartItems() ?></span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">Shopping Cart</h1>
        
        <div class="row">
            <div class="col-md-8">
                <div id="cart-container">
                    <?php if (empty($_SESSION['cart'])): ?>
                        <div class="empty-cart">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h3>Your cart is empty</h3>
                            <p>Start shopping to add items to your cart</p>
                            <a href="index.php" class="btn btn-primary">Continue Shopping</a>
                        </div>
                    <?php else: ?>
                        <div id="cart-items">
                            <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                                <div class="cart-item" data-product-id="<?= $item['product_id'] ?>">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <img src="admin/product_images/<?= $item['product_image'] ?>" 
                                                 alt="<?= $item['product_name'] ?>" 
                                                 class="img-fluid rounded" style="height: 80px; object-fit: cover;">
                                        </div>
                                        <div class="col-md-4">
                                            <h5><?= htmlspecialchars($item['product_name']) ?></h5>
                                            <p class="text-muted">Product ID: <?= $item['product_id'] ?></p>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="price">$<?= number_format($item['product_price'], 2) ?></span>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="quantity-controls">
                                                <button class="btn btn-sm btn-outline-secondary decrease-quantity" 
                                                        data-product-id="<?= $item['product_id'] ?>">-</button>
                                                <span class="quantity"><?= $item['quantity'] ?></span>
                                                <button class="btn btn-sm btn-outline-secondary increase-quantity" 
                                                        data-product-id="<?= $item['product_id'] ?>">+</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="item-total">$<?= number_format($item['product_price'] * $item['quantity'], 2) ?></span>
                                            <button class="btn btn-sm btn-danger remove-item mt-1" 
                                                    data-product-id="<?= $item['product_id'] ?>">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="btn-actions">
                            <button id="clear-cart" class="btn btn-outline-danger">
                                <i class="fas fa-trash"></i> Clear Entire Cart
                            </button>
                            <a href="index.php" class="btn btn-outline-primary">Continue Shopping</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="col-md-4">
                <?php if (!empty($_SESSION['cart'])): ?>
                    <?php $totals = calculateCartTotals(); ?>
                    <div class="cart-summary">
                        <h4>Order Summary</h4>
                        <div class="d-flex justify-content-between">
                            <span>Subtotal:</span>
                            <span id="subtotal">$<?= number_format($totals['subtotal'], 2) ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Tax (8%):</span>
                            <span id="tax">$<?= number_format($totals['tax'], 2) ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Shipping:</span>
                            <span id="shipping">$<?= number_format($totals['shipping'], 2) ?></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total:</span>
                            <span id="total">$<?= number_format($totals['total'], 2) ?></span>
                        </div>
                        <button class="btn btn-success w-100 mt-3">
                            <i class="fas fa-credit-card"></i> Proceed to Checkout
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Cart management functions - SIMPLIFIED VERSION
        class CartManager {
            constructor() {
                this.initEventListeners();
            }

            initEventListeners() {
                console.log('Initializing cart event listeners...');
                
                // Remove item buttons
                document.addEventListener('click', (e) => {
                    // Handle delete buttons
                    if (e.target.classList.contains('remove-item') || e.target.closest('.remove-item')) {
                        e.preventDefault();
                        const button = e.target.classList.contains('remove-item') ? e.target : e.target.closest('.remove-item');
                        console.log('Delete button clicked', button);
                        this.removeItem(button);
                    }
                    
                    // Handle quantity buttons
                    if (e.target.classList.contains('increase-quantity') || e.target.closest('.increase-quantity')) {
                        e.preventDefault();
                        const button = e.target.classList.contains('increase-quantity') ? e.target : e.target.closest('.increase-quantity');
                        this.updateQuantity(button, 1);
                    }
                    
                    if (e.target.classList.contains('decrease-quantity') || e.target.closest('.decrease-quantity')) {
                        e.preventDefault();
                        const button = e.target.classList.contains('decrease-quantity') ? e.target : e.target.closest('.decrease-quantity');
                        this.updateQuantity(button, -1);
                    }
                });

                // Clear cart button
                const clearCartBtn = document.getElementById('clear-cart');
                if (clearCartBtn) {
                    console.log('Clear cart button found');
                    clearCartBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        console.log('Clear cart clicked');
                        this.clearCart();
                    });
                } else {
                    console.log('Clear cart button NOT found');
                }
            }

            updateQuantity(button, change) {
                const productId = button.getAttribute('data-product-id');
                const quantityElement = button.parentElement.querySelector('.quantity');
                let currentQuantity = parseInt(quantityElement.textContent);
                let newQuantity = currentQuantity + change;

                if (newQuantity < 1) return;

                this.sendCartUpdate('update_cart', { 
                    product_id: productId, 
                    quantity: newQuantity 
                }).then(data => {
                    if (data.success) {
                        quantityElement.textContent = newQuantity;
                        this.updateItemTotal(button.closest('.cart-item'), newQuantity);
                        this.updateCartCount(data.cart_count);
                        this.updateCartTotals(data.totals);
                        this.showMessage(data.message, 'success');
                    }
                });
            }

            removeItem(button) {
                const productId = button.getAttribute('data-product-id');
                console.log('Removing item:', productId);
                
                if (!confirm('Are you sure you want to remove this item from your cart?')) {
                    return;
                }

                const cartItem = button.closest('.cart-item');
                
                // Add removal animation
                cartItem.style.opacity = '0.5';
                cartItem.style.transition = 'all 0.3s ease';
                
                this.sendCartUpdate('remove_item', { product_id: productId })
                    .then(data => {
                        if (data.success) {
                            // Animation
                            cartItem.style.transform = 'translateX(-100%)';
                            cartItem.style.opacity = '0';
                            
                            setTimeout(() => {
                                cartItem.remove();
                                this.updateCartCount(data.cart_count);
                                this.updateCartTotals(data.totals);
                                this.checkEmptyCart();
                                this.showMessage(data.message, 'success');
                            }, 300);
                        } else {
                            cartItem.style.opacity = '1';
                            cartItem.style.transform = 'none';
                            this.showMessage(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        cartItem.style.opacity = '1';
                        cartItem.style.transform = 'none';
                        this.showMessage('Error removing item from cart', 'error');
                    });
            }

            clearCart() {
                console.log('Clear cart function called');
                
                if (!confirm('Are you sure you want to clear your entire cart?')) {
                    return;
                }

                this.sendCartUpdate('clear_cart', {})
                    .then(data => {
                        if (data.success) {
                            this.showMessage(data.message, 'success');
                            // Reload the page to show empty cart state
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            this.showMessage(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.showMessage('Error clearing cart', 'error');
                    });
            }

            updateItemTotal(cartItem, quantity) {
                const price = parseFloat(cartItem.querySelector('.price').textContent.replace('$', ''));
                const itemTotal = cartItem.querySelector('.item-total');
                itemTotal.textContent = '$' + (price * quantity).toFixed(2);
            }

            updateCartCount(count) {
                const cartCountElement = document.getElementById('cart-count');
                if (cartCountElement) {
                    cartCountElement.textContent = count;
                }
            }

            updateCartTotals(totals) {
                if (totals) {
                    if (document.getElementById('subtotal')) {
                        document.getElementById('subtotal').textContent = '$' + totals.subtotal.toFixed(2);
                    }
                    if (document.getElementById('tax')) {
                        document.getElementById('tax').textContent = '$' + totals.tax.toFixed(2);
                    }
                    if (document.getElementById('total')) {
                        document.getElementById('total').textContent = '$' + totals.total.toFixed(2);
                    }
                }
            }

            checkEmptyCart() {
                const cartItems = document.querySelectorAll('.cart-item');
                if (cartItems.length === 0) {
                    // Reload to show empty cart state
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                }
            }

            async sendCartUpdate(action, data) {
                console.log('Sending cart update:', action, data);
                
                const formData = new FormData();
                formData.append('action', action);
                for (const key in data) {
                    formData.append(key, data[key]);
                }

                try {
                    const response = await fetch('cart.php', {
                        method: 'POST',
                        body: formData
                    });
                    
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    
                    const result = await response.json();
                    console.log('Server response:', result);
                    return result;
                    
                } catch (error) {
                    console.error('Error updating cart:', error);
                    this.showMessage('Error updating cart. Please try again.', 'error');
                    return { success: false, message: 'Network error' };
                }
            }

            showMessage(message, type) {
                // Remove existing messages
                const existingAlerts = document.querySelectorAll('.alert-position-fixed');
                existingAlerts.forEach(alert => alert.remove());

                const messageElement = document.createElement('div');
                messageElement.className = `alert alert-${type} alert-dismissible fade show alert-position-fixed`;
                messageElement.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 1050;';
                messageElement.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                document.body.appendChild(messageElement);
                
                setTimeout(() => {
                    if (messageElement.parentNode) {
                        messageElement.remove();
                    }
                }, 4000);
            }
        }

        // Initialize cart manager when page loads
        document.addEventListener('DOMContentLoaded', () => {
            console.log('DOM loaded, initializing CartManager...');
            new CartManager();
        });
    </script>
</body>
</html>
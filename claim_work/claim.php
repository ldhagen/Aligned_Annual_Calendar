<?php
/**
 * Aligned Calendar - Claim Page
 * Version: 2.6 (Redirect Guard)
 */

$keys_file = 'keys.txt';
$issued_file = 'issued_keys.txt';
$used_orders_file = 'used_orders.txt';

$claimed_key = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = strtoupper(trim($_POST['order_id']));

    // 1. Check for duplicates
    $used_orders = file_exists($used_orders_file) ? file($used_orders_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
    
    if (in_array($order_id, $used_orders)) {
        $error = "This Order ID has already been used to claim a key.";
    } else {
        // 2. Read available keys
        if (file_exists($keys_file)) {
            $all_keys = file($keys_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            if (!empty($all_keys)) {
                // Pull key from top
                $claimed_key = array_shift($all_keys);
                
                // 3. Write updates (Atomic)
                file_put_contents($keys_file, implode("\n", $all_keys), LOCK_EX);
                file_put_contents($issued_file, $claimed_key . "\n", FILE_APPEND | LOCK_EX);
                file_put_contents($used_orders_file, $order_id . "\n", FILE_APPEND | LOCK_EX);
                
                // CRITICAL: We do NOT use header("Location") here.
                // We let the script continue so $claimed_key triggers the UI below.
            } else {
                $error = "Out of keys! Please message us on Etsy.";
            }
        } else {
            $error = "System Error: keys.txt not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Claim Your Key</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background: #f3f4f6; margin: 0; }
        .card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); text-align: center; width: 350px; border: 1px solid #ddd; }
        .key-box { border: 2px dashed #10b981; padding: 15px; margin: 20px 0; font-family: monospace; font-size: 1.2rem; color: #065f46; background: #ecfdf5; font-weight: bold; border-radius: 8px; }
        input { width: 100%; padding: 12px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; text-align: center; }
        button { width: 100%; padding: 12px; background: #111827; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .error { color: #dc2626; background: #fee2e2; padding: 10px; border-radius: 4px; font-size: 0.85rem; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="card">
        <?php if ($claimed_key): ?>
            <h2>✅ Success!</h2>
            <p>Your premium access key is:</p>
            <div class="key-box"><?php echo htmlspecialchars($claimed_key); ?></div>
            <p style="font-size: 0.8rem; color: #666;">Copy this key now. You will need it to log in.</p>
            <a href="index.php"><button>Continue to Login →</button></a>
        <?php else: ?>
            <h2>🔑 Claim Key</h2>
            <p>Enter your Etsy Order ID</p>
            <form method="POST" action="claim.php">
                <input type="text" name="order_id" placeholder="Order ID" required>
                <button type="submit">Get My Key</button>
            </form>
            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>

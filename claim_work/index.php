<?php
/**
 * Aligned Calendar - Premium Gatekeeper
 * Version: 2.1 (Updated to check multiple key stores)
 */

$key_file = 'keys.txt';
$issued_key_file = 'issued_keys.txt';
$cookie_name = "aligned_cal_access";
$access_duration = time() + (86400 * 30); // 30 days in seconds

// 1. Check if the user is already authenticated via Cookie
$is_authenticated = false;
if (isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] === 'unlocked') {
    $is_authenticated = true;
}

// 2. Process Login Attempt
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['access_key'])) {
    $user_input = strtoupper(trim($_POST['access_key']));
    
    // Load available keys from keys.txt
    $available_keys = [];
    if (file_exists($key_file)) {
        $available_keys = array_filter(array_map('trim', file($key_file)));
    }

    // Load issued keys from issued_keys.txt
    $issued_keys = [];
    if (file_exists($issued_key_file)) {
        $issued_keys = array_filter(array_map('trim', file($issued_key_file)));
    }

    // Combine both lists so the key remains valid after being moved
    $all_valid_keys = array_merge($available_keys, $issued_keys);

    if (in_array($user_input, $all_valid_keys)) {
        // Set a 30-day cookie
        setcookie($cookie_name, 'unlocked', $access_duration, "/");
        $is_authenticated = true;
    } else {
        $error = "Invalid Access Key. Please check your license certificate.";
    }
}

// 3. Serve the Calendar if Authenticated
if ($is_authenticated) {
    if (file_exists('calendar-core.php')) {
        include('calendar-core.php');
    } else {
        echo "Configuration Error: calendar-core.php not found.";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Access | Aligned Calendar</title>
    <link rel="icon" type="image/png" href="assets/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #f9fafb; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; 
        }
        .login-card { 
            background: white; 
            padding: 40px; 
            border-radius: 16px; 
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1); 
            text-align: center; 
            width: 100%; 
            max-width: 380px; 
            border: 1px solid #e5e7eb;
        }
        .logo { width: 64px; height: 64px; margin-bottom: 20px; }
        h1 { font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0 0 8px 0; }
        p { color: #6b7280; font-size: 0.875rem; margin-bottom: 24px; }
        input { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid #d1d5db; 
            border-radius: 8px; 
            font-size: 1rem; 
            text-align: center; 
            box-sizing: border-box;
            margin-bottom: 16px;
            text-transform: uppercase;
        }
        input:focus { outline: 2px solid #3b82f6; border-color: transparent; }
        button { 
            width: 100%; 
            padding: 12px; 
            background-color: #111827; 
            color: white; 
            border: none; 
            border-radius: 8px; 
            font-weight: 600; 
            cursor: pointer; 
            transition: background 0.2s;
        }
        button:hover { background-color: #374151; }
        .error { color: #dc2626; font-size: 0.875rem; margin-top: 16px; font-weight: 500; }
        .footer-note { margin-top: 24px; font-size: 0.75rem; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="login-card">
        <img src="assets/logo.png" alt="Aligned Calendar Logo" class="logo">
        <h1>Welcome Back</h1>
        <p>Enter your premium key to unlock your calendar.</p>
        
        <form method="POST">
            <input type="text" name="access_key" placeholder="XXXX-XXXX-XXXX" required autofocus autocomplete="off">
            <button type="submit">Unlock Calendar</button>
        </form>

        <?php if(isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="footer-note">
            Access will remain active for 30 days on this browser.
        </div>
    </div>
</body>
</html>

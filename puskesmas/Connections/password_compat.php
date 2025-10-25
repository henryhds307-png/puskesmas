<?php
/**
 * password_compat.php
 * Polyfill untuk fungsi password_* agar tetap berfungsi di PHP < 5.5
 * Cocok untuk proyek lama seperti XAMPP dengan PHP 5.3 atau 5.4
 */

// === Tambahkan konstanta PASSWORD_BCRYPT jika belum ada ===
if (!defined('PASSWORD_BCRYPT')) {
    define('PASSWORD_BCRYPT', 1);
}

// === Polyfill random_bytes() untuk PHP <7 ===
if (!function_exists('random_bytes')) {
    function random_bytes($length = 16) {
        $bytes = '';
        for ($i = 0; $i < $length; $i++) {
            $bytes .= chr(mt_rand(0, 255));
        }
        return $bytes;
    }
}

// === Polyfill password_hash() untuk PHP <5.5 ===
if (!function_exists('password_hash')) {
    function password_hash($password, $algo = PASSWORD_BCRYPT, $options = array()) {
        $cost = isset($options['cost']) ? $options['cost'] : 10;
        $salt = isset($options['salt'])
            ? $options['salt']
            : substr(strtr(base64_encode(random_bytes(16)), '+', '.'), 0, 22);
        return crypt($password, sprintf('$2y$%02d$', $cost) . $salt);
    }
}

// === Polyfill password_verify() untuk PHP <5.5 ===
if (!function_exists('password_verify')) {
    function password_verify($password, $hash) {
        return crypt($password, $hash) === $hash;
    }
}

// === Polyfill password_needs_rehash() ===
if (!function_exists('password_needs_rehash')) {
    function password_needs_rehash($hash, $algo, array $options = array()) {
        $cost = isset($options['cost']) ? $options['cost'] : 10;
        $info = substr($hash, 0, 4);
        if ($info !== '$2y$') {
            return true;
        }
        $currentCost = (int)substr($hash, 4, 2);
        return $currentCost !== $cost;
    }
}

// === Polyfill password_get_info() ===
if (!function_exists('password_get_info')) {
    function password_get_info($hash) {
        return array(
            'algo' => (substr($hash, 0, 4) === '$2y$') ? PASSWORD_BCRYPT : 0,
            'algoName' => (substr($hash, 0, 4) === '$2y$') ? 'bcrypt' : 'unknown',
            'options' => array(
                'cost' => (int)substr($hash, 4, 2)
            ),
        );
    }
}
?>

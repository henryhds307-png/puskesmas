<?php
/**
 * password_compat.php
 * Polyfill modern dan aman untuk fungsi password_* (PHP 5.3+ hingga PHP 8+)
 * 
 * Fitur:
 * - Otomatis skip jika PHP sudah mendukung password_* native
 * - Menyediakan fallback aman untuk password_hash(), password_verify(), dsb.
 * - Termasuk random_bytes() dan konstanta PASSWORD_BCRYPT
 * 
 * Buat file ini di folder: ../Connections/password_compat.php
 * Lalu include sebelum penggunaan password_hash() / password_verify()
 * Contoh:
 *   require_once('../Connections/password_compat.php');
 */

// === SKIP jika fungsi sudah tersedia (PHP >= 5.5) ===
if (function_exists('password_hash') && function_exists('password_verify')) {
    // PHP sudah mendukung native password_* API, tidak perlu polyfill
    return;
}

// === Pastikan konstanta tersedia ===
if (!defined('PASSWORD_BCRYPT')) {
    define('PASSWORD_BCRYPT', 1);
}

// === random_bytes() fallback untuk PHP <7 ===
if (!function_exists('random_bytes')) {
    function random_bytes($length = 16) {
        $bytes = '';
        for ($i = 0; $i < $length; $i++) {
            $bytes .= chr(mt_rand(0, 255));
        }
        return $bytes;
    }
}

// === Polyfill password_hash() ===
if (!function_exists('password_hash')) {
    function password_hash($password, $algo = PASSWORD_BCRYPT, $options = array()) {
        if ($algo !== PASSWORD_BCRYPT) {
            trigger_error('password_hash(): Unsupported algorithm', E_USER_WARNING);
            return null;
        }

        $cost = isset($options['cost']) ? (int)$options['cost'] : 10;

        // Generate salt (22 chars)
        $salt = isset($options['salt'])
            ? $options['salt']
            : substr(strtr(base64_encode(random_bytes(16)), '+', '.'), 0, 22);

        // Gunakan crypt() dengan bcrypt
        return crypt($password, sprintf('$2y$%02d$', $cost) . $salt);
    }
}

// === Polyfill password_verify() ===
if (!function_exists('password_verify')) {
    function password_verify($password, $hash) {
        if (!is_string($password) || !is_string($hash)) return false;
        return crypt($password, $hash) === $hash;
    }
}

// === Polyfill password_needs_rehash() ===
if (!function_exists('password_needs_rehash')) {
    function password_needs_rehash($hash, $algo, array $options = array()) {
        if ($algo !== PASSWORD_BCRYPT) return true;
        $cost = isset($options['cost']) ? (int)$options['cost'] : 10;
        if (substr($hash, 0, 4) !== '$2y$') return true;
        $currentCost = (int)substr($hash, 4, 2);
        return $currentCost !== $cost;
    }
}

// === Polyfill password_get_info() ===
if (!function_exists('password_get_info')) {
    function password_get_info($hash) {
        $algo = (substr($hash, 0, 4) === '$2y$') ? PASSWORD_BCRYPT : 0;
        return array(
            'algo' => $algo,
            'algoName' => $algo ? 'bcrypt' : 'unknown',
            'options' => array(
                'cost' => (int)substr($hash, 4, 2)
            ),
        );
    }
}
?>

<?php
/**
 * Fungsi utilitas umum
 * Kompatibel: PHP 5.6 – 8.3
 */

// Fungsi untuk sanitasi input
function sanitize($data)
{
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = sanitize($value);
        }
        return $data;
    }

    $data = trim($data);
    $data = strip_tags($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Fungsi redirect sederhana
function redirect($url, $message = null)
{
    if (!headers_sent()) {
        if ($message) {
            // Simpan pesan di session kalau perlu
            session_start();
            $_SESSION['flash_message'] = $message;
        }
        header("Location: " . $url);
        exit;
    } else {
        if ($message) {
            echo "<script>alert('" . addslashes($message) . "');window.location.href='" . $url . "';</script>";
        } else {
            echo "<script>window.location.href='" . $url . "';</script>";
        }
        exit;
    }
}

// Fungsi tampilkan pesan flash (opsional)
function show_flash()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['flash_message'])) {
        echo '<div style="background:#dff0d8;color:#3c763d;padding:10px;margin-bottom:10px;border-radius:4px;">'
            . htmlspecialchars($_SESSION['flash_message']) .
            '</div>';
        unset($_SESSION['flash_message']);
    }
}
?>

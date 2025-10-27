<?php
$password_input = '123456'; // ganti dengan password yang kamu ketik di login
$hash_from_db   = '$2y$10$Tjz7OQj38W1Bn0o9RgfDre2w7R2BG4J..Dn5kEVmepKoYJ1J2ZZjS'; // ambil dari database

if (password_verify($password_input, $hash_from_db)) {
    echo "Cocok!";
} else {
    echo "Tidak cocok!";
}

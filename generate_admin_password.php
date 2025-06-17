<?php
$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Mot de passe: " . $password . "\n";
echo "Hash: " . $hash . "\n";
?> 
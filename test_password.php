<?php
// Replace this hash with the full hash from your database
$hash = '0192023a7bbd73250516f069df18b500'; // <-- Replace with your actual hash

// Test if the password matches the hash
var_dump(password_verify('admin123', $hash)); 
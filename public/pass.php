<?php
$password = 'GetvawVsws44s!';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
echo $hashedPassword;
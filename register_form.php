<?php

require_once 'config.php';

$error = [];

if (isset($_POST['submit'])) {

   $name = trim($_POST['name'] ?? '');
   $email = trim($_POST['email'] ?? '');
   $password = $_POST['password'] ?? '';
   $cpassword = $_POST['cpassword'] ?? '';

   // New accounts are always normal users. Admins are added in the database.
   $user_type = 'user';

   if ($name === '' || $email === '' || $password === '') {
      $error[] = 'please fill in all fields!';
   } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error[] = 'please enter a valid email!';
   } elseif (strlen($password) < 8) {
      $error[] = 'password must be at least 8 characters!';
   } elseif ($password !== $cpassword) {
      $error[] = 'password not matched!';
   } else {
      $stmt = mysqli_prepare($conn, 'SELECT id FROM user_form WHERE email = ?');
      mysqli_stmt_bind_param($stmt, 's', $email);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);

      if (mysqli_stmt_num_rows($stmt) > 0) {
         $error[] = 'user already exist!';
      } else {
         $hash = password_hash($password, PASSWORD_DEFAULT);
         $insert = mysqli_prepare($conn, 'INSERT INTO user_form (name, email, password, user_type) VALUES (?, ?, ?, ?)');
         mysqli_stmt_bind_param($insert, 'ssss', $name, $email, $hash, $user_type);
         mysqli_stmt_execute($insert);
         header('Location: login_form.php');
         exit;
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<div class="form-container">

   <form action="" method="post">
      <h3>register now</h3>
      <?php foreach ($error as $msg): ?>
         <span class="error-msg"><?= e($msg) ?></span>
      <?php endforeach; ?>
      <input type="text" name="name" required placeholder="enter your name" value="<?= e($_POST['name'] ?? '') ?>">
      <input type="email" name="email" required placeholder="enter your email" value="<?= e($_POST['email'] ?? '') ?>">
      <input type="password" name="password" required minlength="8" placeholder="enter your password">
      <input type="password" name="cpassword" required minlength="8" placeholder="confirm your password">
      <input type="submit" name="submit" value="register now" class="form-btn">
      <p>already have an account? <a href="login_form.php">login now</a></p>
   </form>

</div>

</body>
</html>

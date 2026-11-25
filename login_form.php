<?php

require_once 'config.php';

session_start();

$error = [];

if (isset($_POST['submit'])) {

   $email = trim($_POST['email'] ?? '');
   $password = $_POST['password'] ?? '';

   $stmt = mysqli_prepare($conn, 'SELECT name, password, user_type FROM user_form WHERE email = ?');
   mysqli_stmt_bind_param($stmt, 's', $email);
   mysqli_stmt_execute($stmt);
   $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

   if ($row && password_verify($password, $row['password'])) {

      // New session id after login, so an old session id can't be reused.
      session_regenerate_id(true);

      if ($row['user_type'] === 'admin') {
         $_SESSION['admin_name'] = $row['name'];
         header('Location: admin_page.php');
         exit;
      }

      $_SESSION['user_name'] = $row['name'];
      header('Location: user_page.php');
      exit;
   }

   $error[] = 'incorrect email or password!';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<div class="form-container">

   <form action="" method="post">
      <h3>login now</h3>
      <?php foreach ($error as $msg): ?>
         <span class="error-msg"><?= e($msg) ?></span>
      <?php endforeach; ?>
      <input type="email" name="email" required placeholder="enter your email" value="<?= e($_POST['email'] ?? '') ?>">
      <input type="password" name="password" required placeholder="enter your password">
      <input type="submit" name="submit" value="login now" class="form-btn">
      <p>don't have an account? <a href="register_form.php">register now</a></p>
   </form>

</div>

</body>
</html>

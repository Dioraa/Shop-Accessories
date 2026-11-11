<?php
require_once "config/database.php";
require_once "config/auth.php";
require_once "config/helpers.php";
require_once "models/User.php";

if (isLoggedIn()) redirect("index.php");
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = (new User($pdo))->findByEmail(trim($_POST['email'] ?? ''));
    if ($user && password_verify($_POST['password'] ?? '', $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        redirect("index.php");
    }
    $error = "Email or password is incorrect.";
}
$pageTitle = "Login | Classy";
require "partials/header.php";
?>
<section class="auth-page">
    <div class="auth-card">
        <span class="eyebrow">WELCOME BACK</span>
        <h1>Sign in</h1>
        <?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
        <form method="post">
            <label>Email<input required type="email" name="email" autocomplete="email"></label>
            <label>Password<input required type="password" name="password" autocomplete="current-password"></label>
            <button class="btn full" type="submit">Sign in →</button>
        </form>
        <p>Don't have an account? <a href="register.php">Create one</a></p>
    </div>
</section>
<?php require "partials/footer.php"; ?>

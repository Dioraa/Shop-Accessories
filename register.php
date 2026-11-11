<?php
require_once "config/database.php";
require_once "config/auth.php";
require_once "config/helpers.php";
require_once "models/User.php";

if (isLoggedIn()) redirect("index.php");
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (strlen($name) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
        $error = "Please enter valid details. Password must be at least 8 characters.";
    } elseif ((new User($pdo))->findByEmail($email)) {
        $error = "An account with this email already exists.";
    } else {
        (new User($pdo))->create($name, $email, $password);
        $user = (new User($pdo))->findByEmail($email);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        redirect("index.php");
    }
}
$pageTitle = "Create Account | Classy";
require "partials/header.php";
?>
<section class="auth-page">
    <div class="auth-card">
        <span class="eyebrow">JOIN VELORA</span>
        <h1>Create account</h1>
        <?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
        <form method="post">
            <label>Name<input required name="name" autocomplete="name"></label>
            <label>Email<input required type="email" name="email" autocomplete="email"></label>
            <label>Password<input required type="password" name="password" minlength="8" autocomplete="new-password"></label>
            <button class="btn full" type="submit">Create account →</button>
        </form>
        <p>Already have an account? <a href="login.php">Sign in</a></p>
    </div>
</section>
<?php require "partials/footer.php"; ?>

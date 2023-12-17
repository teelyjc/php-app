<?php
  session_start();

  if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username)) {
      $_SESSION["usernameError"] = "username required";
      header("Location: /auth/login.php");
      return;
    } else if (empty($password)) {
      $_SESSION["passwordError"] = "password required";
      header("Location: /auth/login.php");
      return;
    }

    echo "Login Successfully";
  }
?>
<!DOCTYPE html>
<?php
  require_once("../partials/header.php");
?>
<body>
  <h1 class="text-2xl max-w-xl text-center">Authentication Form</h1>
  <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" class="max-w-xl space-y-2">
    <div class="flex flex-col space-y-2">
      <input
        type="text"
        name="username"
        class="border rounded-md py-2 px-4 shadow-md"
        placeholder="John"
      >
      <?php if (isset($_SESSION["usernameError"])) : ?>
        <p class="text-sm text-red-500">
          <?php
            echo $_SESSION["usernameError"];
            unset($_SESSION["usernameError"]);
          ?>
        </p>
      <?php endif; ?>
      <input
        type="password"
        name="password"
        class="border rounded-md py-2 px-4 shadow-md"
        placeholder="12345"
      >
      <?php if (isset($_SESSION["passwordError"])) : ?>
        <p class="text-sm text-red-500">
          <?php
            echo $_SESSION["passwordError"];
            unset($_SESSION["passwordError"]);
          ?>
        </p>
      <?php endif; ?>
    </div>
    <button
      type="submit"
      name="submit"
      class="border rounded-md py-2 px-4 shadow-md bg-green-500 text-white w-full"
    >
      Login
    </button>
    <a href="/auth/register.php">not a member ?</a>
  </form>
</body>

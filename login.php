<?php
session_start();
if (isset($_SESSION['logged'])) {

    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Simsar</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="login.css">
</head>

<body>



  <div class="login-container">
    <div class="logo">
      <img src="https://cdn-icons-png.flaticon.com/512/235/235861.png" alt="logo">
      <h2>سمسار </h2>
    </div>

    <h1>تسجيل الدخول</h1>

 <form id="loginForm" action="serverlogin.php" method="POST">
  <input type="text" name="username" required placeholder="اسم المستخدم" maxlength="20">
  <input type="password" name="password" required placeholder="كلمة السر" maxlength="20">
  <button type="submit">سجل دخولك</button>
</form>

    <p>لا تملك حساب؟ <a href="signup.php">سجل معنا</a></p>
    <p>او <a href="index.php">عد للصفحة الرئيسية</p>
  </div>


  <script>

document.getElementById("loginForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    let response = await fetch("serverlogin.php", {
        method: "POST",
        body: formData
    });

    let result = await response.text();

    let status = parseInt(result);

    if (status == 2) {
        alert("تم تسجيل دخولك بنجاح");
        window.location = "index.php"
    } else if (status == 1) {
        alert("تأكد من اسم المستخدم");
    } else if (status == 3) {
        alert("تأكد من كلمة السر");
    }
});


  </script>







</body>
</html>

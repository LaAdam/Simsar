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
  <title>Sign Up - Simsar</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="signup.css">
</head>
<body>

  <div class="signup-container">
    <div class="logo">
      <img src="https://cdn-icons-png.flaticon.com/512/235/235861.png" alt="logo">
      <h2>سمسمار</h2>
    </div>
    <h1>سجل معنا اليوم</h1>
    <form id="signUpForm">
      <input type="email"id="email" name="email" placeholder="الايميل" required maxlength="400">
      <input type="text" id="name" name="name" placeholder="الاسم" required maxlength="400">
      <input type="text" id="username" name="username" placeholder="اسم المستخدم" required maxlength="20">
      <input type="text" id="location" name="location" placeholder="موقع المكتب" maxlength="200" required>
      <input type="text" id="phone" name="phone" placeholder="رقم الهاتف/الارضي" maxlength="15" required>
      <input type="password" id="password" name="password" placeholder="كلمة السر" maxlength = "20" required>


      <button type="submit">سجل حسابك!</button>
       
    </form>
    
    <p>لديك حساب بالفعل؟ <a href="login.php">سجل دخولك</a></p>
    <p>وصلت هنا بالخطأ؟<a href="index.php">عد للصفحة الرئيسية</a></p>

  </div>




  <script>

document.getElementById("signUpForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    let response = await fetch("serversignup.php", {
        method: "POST",
        body: formData
    });

    let result = await response.text();

    let status = result;

    if (status == '1') {
        alert("هذا الاسم موجود في الموقع بالفعل");
    }else if(status == '2'){
      alert("هذا الايميل مستعمل في الموقع");
    }
     else if (status == '3') {
        alert("تم تسجيل حسابك, قم بتسجيل الدخول رجاءًا");
       window.location = "login.php"

    }else{
      alert("هناك مشكلة بقاعدة البيانات, حاول الوصول مجددا لاحقا");
      console.log(status);
    }
});


  </script>


</body>
</html>

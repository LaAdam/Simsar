<?php

include "sqlconnect.php";

if (!isset($_GET['username'])){
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Redirecting...</title>
        <script>
            setTimeout(function(){
                window.location.href = 'index.php';
            }, 5000);
        </script>
    </head>
    <body>
        <p>المستخدم غير موجود, سيتم تحويلك قريبا...</p>
    </body>
    </html>
    <?php
    exit();
}



$username = $_GET['username']; 

$sql = "SELECT * FROM usersauth WHERE username = '{$username}'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<p>user not found. Redirecting to home...</p>";
    echo "<script>setTimeout(()=>{window.location.href='index.php'}, 5000);</script>";
    exit();
}

$user = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>

  <?php

  echo "حساب " . $username ;
  ?>
  </title>
  <link rel="stylesheet" href="profile.css">
  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

   <header>
  <div class="header-container">
    <div class="logo">
      <img src="https://cdn-icons-png.flaticon.com/512/235/235861.png" alt="logo">
      <div class="logo-text">
        <h2>Simsar</h2>
        <p>Premium Properties</p>
      </div>
    </div>

    <div class="home-button">
      <a href="index.php">Home</a>
    </div>
  </div>
</header>

  <main class="details-container">


    <div class="info-box">
        

   <?php
   echo "<h1>". $user['name'] . "</h1>";
   echo "<h4>". $username . "</h4>";
   echo "<h2> رقم التلفون: " . $user['phone'] ."</h2>";

   echo "<h3>موقع المكتب: " . $user['location'] ."</h3>";
   echo "<h3> الايميل: " . $user['email'] ."</h3>";
   
   $result = $conn->query("SELECT COUNT(*) AS total FROM properties WHERE merchant = '{$username}'");
   $row = $result->fetch_assoc();
   echo "<h4>عدد العقارات: " . $row['total'] . "</h4>";

   ?>
 




        
    </div>





    <section id="properties">
      <section class="filters-section">

  <?php echo "<h3> عقارات " . $user['name'] . "<h3>"; ?>

<form id="filtersForm">

  <div class="filters">

    <div class="filter-box">
      <label>نوع العقار</label>
      <select id="propertyType" name="propertyType">
        <option value="">اختر نوع العقار</option>
        <option value="house">منزل</option>
        <option value="land">أرض</option>
        <option value="shop">محل تجاري</option>
        <option value="apartment">شقة</option>
      </select>
    </div>

    <div class="filter-box">
      <label>المساحة (م²)</label>
      <div class="double-input">
        <input type="number" id="minSize" name="minSize" placeholder="الحد الأدنى">
        <input type="number" id="maxSize" name="maxSize" placeholder="الحد الأعلى">
      </div>
    </div>

    <div class="filter-box">
      <label>عدد الغرف</label>
      <input type="number" id="rooms" name="rooms" placeholder="مثال: 3">
    </div>

<input name="username" type="hidden" value="<?php echo $username; ?>">


    <div class="filter-box">
      <label>عدد الحمامات</label>
      <input type="number" id="bathrooms" name="bathrooms" placeholder="مثال: 2">
    </div>

    <div class="filter-box">
      <label>عدد الطوابق</label>
      <input type="number" id="floors" name="floors" placeholder="مثال: 1">
    </div>

    <div class="filter-box checkbox-box">
      <label>
        <input type="checkbox" id="garage" name="garage">
        كراج
      </label>
    </div>

    <div class="filter-box">
      <label>الترتيب</label>
      <select id="sortBy" name="sortBy">
        <option value="">بدون ترتيب</option>
        <option value="rating-high">التقييم: من الأعلى للأقل</option>
        <option value="rating-low">التقييم: من الأقل للأعلى</option>
        <option value="price-high">السعر: من الأعلى للأقل</option>
        <option value="price-low">السعر: من الأقل للأعلى</option>
      </select>
    </div>

    <div class="filter-box">
    <button type="submit" class="apply-btn" id='fSubmitBtn'>تطبيق</button>
    </div>

  </div>

</form>


<script>
const form = document.getElementById('filtersForm');
form.addEventListener('submit', function(e) {
    e.preventDefault(); 

    const formData = new FormData(form);
    const params = new URLSearchParams(formData).toString();

    fetch('server.php?' + params)
    .then(res => res.text())
    .then(html => {
        document.getElementById('propgrid').innerHTML = html;
    });
});

const propGrid = document.getElementById('propgrid');




function loadPage(page) {
    const formData = new FormData(form);
    formData.set('page', page); 
    const params = new URLSearchParams(formData).toString();

    fetch('server.php?' + params)
        .then(res => res.text())
        .then(html => {
            document.getElementById('propgrid').innerHTML = html;
        });

        
    window.scrollTo({
    top: document.getElementById('properties').offsetTop,
    behavior: 'smooth'
    });

        
}



window.addEventListener('DOMContentLoaded', () => {
    form.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
});



</script>

</section>

      <div class="properties-grid" id="propgrid">

      </div>
    </section>


    
  </main>

</body>
</html>

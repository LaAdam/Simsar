<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>سمسار - عقارات نابلس</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <div class="logo">
      <img src="https://cdn-icons-png.flaticon.com/512/235/235861.png" alt="logo">
      <div class="logo-text">
        <h2>سمسار</h2>
        <p>عقارات مميزة</p>
      </div>
    </div>

    <nav>
      <ul>
        <li><a href="#home">الرئيسية</a></li>
        <li><a href="#properties">العقارات</a></li>
        <?php


     

        session_start();
        if (!isset($_SESSION['logged']) || !$_SESSION['logged'])
        echo "<li><a href=\"login.php\">تسجيل الدخول</a></li>";
        else{
        echo "<li><a href=\"add-property.php\">اضافة عقار</a></li>";
        echo "<li><a href='profile.php?username=" . urlencode($_SESSION['username']) . "'>حسابي</a></li>";
        echo "<li id=\"logoutBtn\"><a href=\"logout.php\">تسجيل الخروج</a></li>";
        
        }

        ?>
      </ul>
    </nav>
  </header>
 
  <main>

    <section id="home">
      <h1>سمسار</h1>
      <p class="subtitle">مرحبا بكم، هذا موقع عقاري لشراء أو بيع العقارات</p>

      <div class="search-box">
        <input list="propertiesList" id="propertyInput" placeholder="اكتب نوع عقارك">
        <datalist id="propertiesList">
          <option value="منزل">
          <option value="ارض">
          <option value="محل">
        </datalist>
        <button id="enterBtn">اذهب</button>
      </div>

      <div class="stats">
        <div class="stat">
          
<h3>
    <?php
        include "sqlconnect.php"; 
        $result = $conn->query("SELECT COUNT(*) AS total FROM properties");
        $row = $result->fetch_assoc();
        echo $row['total'];
    ?>
</h3>
<p>العقارات المضافة</p>

        </div>
        <div class="stat">
          <h3>0</h3>
          <p>متوسط ​​المشاهدات/الشهر</p>
        </div>
        <div class="stat">
          <h3>0</h3>
          <p>المعلنين</p>
        </div>
      </div>
    </section>

    <section id="properties">
      <h1>العقارات المتاحة</h1>
      <section class="filters-section">

  <h2>ابحث عن عقارك</h2>

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

  <script>
   const input = document.getElementById('propertyInput');
const button = document.getElementById('enterBtn');

button.addEventListener('click', () => {
  const value = input.value.trim().toLowerCase();

  const fsubmitBtn =  document.getElementById("fSubmitBtn");

  if (value === "منزل") {

    document.getElementById("propertyType").value = "house";
      
     fsubmitBtn.click();
 
  } else if (value === "ارض") {
    document.getElementById("propertyType").value = "land";

     fsubmitBtn.click();


  } else if (value === "محل") {
    document.getElementById("propertyType").value = "shop";

      fsubmitBtn.click();

  } 

    window.scrollTo({
    top: document.getElementById('properties').offsetTop,
    behavior: 'smooth'
  });

});

input.addEventListener('keydown', (e) => {
  if (e.key === "Enter") {
    button.click();
  }
});




  </script>


<footer>
  <p>made with love</p>
</footer>
</body>
</html>

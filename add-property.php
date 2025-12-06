<?php

session_start();
if (!isset($_SESSION['logged'])) {

    header("Location: login.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>سمسار - إضافة عقار</title>
    <link rel="stylesheet" href="styleofadd.css">
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


    <main class="page-wrapper">
        <section class="card">
            <h1 class="card-title">إضافة عقار جديد</h1>

            <form method="post" class="form-grid-wrapper" enctype="multipart/form-data" id="addingform">

               <div class="form-grid">
                <div class="form-group">
                    <label for="rooms">عدد الغرف</label>
                    <input type="number" id="rooms" name="rooms" min="0" max="999" placeholder="مثال: 3" maxlength="3">
                </div>

                <div class="form-group">
                    <label for="price">السعر بالدينار الاردني</label>
                    <input type="number" id="price" name="price" min="0" placeholder="مثال: 130000">
                </div>

                 <div class="form-group">
                    <label for="location">الموقع</label>
                    <input type="text" id="location" name="location" placeholder="مثال: وسط البلد قرب مطعم شرف" maxlength="500">
                </div>

                <div class="form-group">
                    <label for="bathrooms">عدد الحمامات</label>
                    <input type="number" id="bathrooms" name="bathrooms" min="0" max="999" placeholder="مثال: 2">
                </div>

               
                <div class="form-group">
                    <label for="floors">عدد الطوابق</label>
                    <input type="number" id="floors" name="floors" min="0" max="999" placeholder="مثال: 5">
                </div>

                
                <div class="form-group">
                    <label for="size">مساحة العقار (م²)</label>
                    <input type="number" id="size" name="size" min="0" placeholder="مثال: 150">
                </div>

                 <div class="form-group">
                 <label for="title">عنوان العقار</label>
                 <input type="text" id="title" name="title" min="0" placeholder="مثال: شقة روف">
                </div>
             
                <div class="form-group">
                    <label for="garage">كراج؟</label>
                    <select id="garage" name="garage">
                        <option value="">اختر</option>
                        <option value="1">نعم</option>
                        <option value="0">لا</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="propertyType">نوع العقار</label>
                    <select id="propertyType" name="propertyType">
                        <option value="">اختر النوع</option>
                        <option value="apartment">شقة</option>
                        <option value="house">منزل</option>
                        <option value="land">أرض</option>
                        <option value="shop">محل</option>
                    </select>
                </div>

                
                <div class="form-group">
                    <label for="rate">حالة العقار</label>
                    <select id="rate" name="rate">
                        <option value="">اختر الحالة</option>
                        <option value="5">جديد</option>
                        <option value="4">جيد جدا</option>
                        <option value="3">جيد</option>
                        <option value="2">متضرر</option>
                        <option value="1">بحاجة لترميم</option>
                        <option value="0">قيد الإنشاء</option>
                    </select>
                </div>

                
                <div></div>

             
                <div class="image-upload">
                    <p>رفع صورة العقار</p>
                    <label for="image" class="upload-btn">اختر ملفًا</label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>

</div>
                <div class="actions">
                <button type="submit" class="primary-btn">حفظ العقار</button>
                <button type="reset" class="secondary-btn">إلغاء</button>
            </div>
            </form>

            


        </section>





  <script>

document.getElementById("addingform").addEventListener("submit", async function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    let response = await fetch("addingserver.php", {
        method: "POST",
        body: formData
    });

    let result = await response.text();

    let status = parseInt(result);

    if (status == 1) {
        alert("تم اضافة عقارك بنجاح!");
                window.location.href = "index.php";
    } else if (status == 0) {
        alert("رجاءًا تأكد انك ملأت جميع المدخلات");
    }
});


  </script>



    </main>





</body>
</html>

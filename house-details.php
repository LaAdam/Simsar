<?php



include "sqlconnect.php";



session_start();


if (!isset($_GET['id'])){
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>اعادة توجيه..</title>
        <script>
            setTimeout(function(){
                window.location.href = 'index.php';
            }, 5000);
        </script>
    </head>
    <body>
        <p>هذا العقار غير متوفر.. سيتم تحويلك للصفحة الرئيسية خلال ثوان..</p>
    </body>
    </html>
    <?php
    exit();
}



$id = $_GET['id']; 

$sql = "SELECT * FROM properties WHERE id = {$id}";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<p>Property not found. Redirecting to home...</p>";
    echo "<script>setTimeout(()=>{window.location.href='index.php'}, 5000);</script>";
    exit();
}

$property = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تفاصيل العقار</title>
  <link rel="stylesheet" href="house-details.css">
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

    <!-- زر العودة Home -->
    <div class="home-button">
      <a href="index.php">Home</a>
    </div>
  </div>
</header>

  <main class="details-container">
    <div class="image-box">


      <?php
      echo "<img src=\"". $property['imgsrc']."\" alt=\"Luxury House\">";
      ?>
     <iframe id="map" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d620.5773934723113!2d35.1860088233276!3d31.90095174274595!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1sen!2s!4v1764849215552!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>



    </div>

    <div class="info-box">

        <?php
       
       echo "<h1>" . $property['title'] . "</h1>\n";

echo '<p>البائع : <a href="profile.php?username=' . urlencode($property['merchant']) . '">' . $property['merchant'] . '</a></p>';

       echo "<p>" . "الموقع: " . $property['location'] . "</p>\n";
       if($property['type'] != "land"){

       echo "<p>"."الغرف: ". $property['rooms'] . "</p>\n";
     
       echo "<p>" . "الحمامات: " . $property['bathrooms'] . "</p>\n";
      
       echo "<p>" . "عدد الطوابق: " . $property['floors'] . "</p>\n";
       
       echo "<p>" . "المساحة الكلية: " . $property['size'] . " متر مربع</p>\n";

             if($property['garage'] == 1)
      echo "<p>" . "كراج: نعم " ."</p>\n";
     else
      echo "<p>" . "كراج: لا " ."</p>\n";

       }



    $ratee = "جيد";
    switch ($property['rate']) {
    case 0:
    $ratee = "قيد الانشاء او ارض";
          
    break;
        case 1:
    $ratee = "بحاجة لترميم";
    break;
         case 2:
    $ratee ="متضرر";
    break;
         case 3:
    $ratee = "جيد";
    break;
             case 4:
    $ratee = "جيد جدا";
    break;
             case 5:
    $ratee = "جديد";
    break;
  default:
    $ratee = "غير معلوم";
}

       echo "<p>" . "حالة العقار: " .  $ratee . "</p>\n";





      echo "<p>". "السعر : " . number_format($property['price']) . "دينار"."</p>\n";
       
       if (isset($_SESSION['logged'])) {
              if($_SESSION['username'] == $property['merchant']){

              echo "<p>" . "انت تملك هذا العقار, هل تريد حذفه؟" . "</p>";
              echo '<button id="deletePropertyBtn">احذف</button>';


              }
               }




        ?>

        
    </div>


    
  </main>


<script>
document.getElementById("deletePropertyBtn")?.addEventListener("click", async function() {
    const formData = new FormData();
    formData.append("id", <?php echo (int)$property['id']; ?>);

    const response = await fetch("delete-property.php", {
        method: "POST",
        body: formData
    });

    const result = await response.text();

    if (result === "DELETED") {
        alert("تم حذف العقار");
        window.location.href = "index.php";
    } else {
        alert("حدثت مشكلة أثناء الحذف");
        console.log(result);
    }
});
</script>



</body>
</html>

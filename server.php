<?php
include "sqlconnect.php";





$limit = 24; // items per page
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$query = "SELECT * FROM `properties` ";

$where = "WHERE 1";

if (!empty($_GET['propertyType'])) {
    $type = $_GET['propertyType'];
    $where .= " AND type='$type'";
}
if (!empty($_GET['minSize'])) {
    $minSize = (float)$_GET['minSize'];
    $where .= " AND size >= $minSize";
}
if (!empty($_GET['maxSize'])) {
    $maxSize = (float)$_GET['maxSize'];
    $where .= " AND size <= $maxSize";
}
if (!empty($_GET['garage'])) {
    $where .= " AND garage = 1";
}
if (!empty($_GET['floors'])) {
    $where .= " AND floors = ".$_GET['floors'];
}
if (!empty($_GET['rooms'])) {
    $where .= " AND rooms = ".$_GET['rooms'];
}
if (!empty($_GET['bathrooms'])) {
    $where .= " AND bathrooms = ".$_GET['bathrooms'];
}

 if(isset($_GET['username'])){
    $where .= " AND merchant = ". "'{$_GET['username']}'";
 }


if (!empty($_GET['sortBy'])) {
    switch ($_GET['sortBy']) {
        case "price-high": $where .= " ORDER BY price DESC"; break;
        case "price-low": $where .= " ORDER BY price ASC"; break;
        case "rating-high": $where .= " ORDER BY rate DESC"; break;
        case "rating-low": $where .= " ORDER BY rate ASC"; break;
    }
}



$query .= $where;
$query .= " LIMIT $limit OFFSET $offset";

$result = $conn->query($query);

$numOfProps = 0;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="property-card">';
        echo '<img src="'. htmlspecialchars($row['imgsrc']) .'" alt="Property">';
        echo '<h3>'. htmlspecialchars($row['title']) .'</h3>';
        echo '<p>البائع: '. htmlspecialchars($row['merchant']) .'</p>';
        echo '<p>الموقع: '. htmlspecialchars($row['location']) .'</p>';
        echo '<p>السعر: '. number_format($row['price'], 2) .' دينار</p>';
          

          $ratee = "جيد";
        switch ($row['rate']) {
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
        echo '<p>حالة العقار: '. $ratee .'</p>';

        echo '<p>المساحة: '. htmlspecialchars($row['size']) .' م²</p>';
        if($row['type'] != "land")
        echo '<p>كراج: '. ($row['garage'] ? 'نعم' : 'لا') .'</p>';
        else
        echo "<br>";
        echo '<button id="detailsbtn" onclick="location.href=\'house-details.php?id='. $row['id'] .'\'">شاهد التفاصيل</button>';
        echo '</div>';
    }
} else {
    echo "<p>لا توجد عقارات متاحة</p>";
}


$countResult = $conn->query("SELECT COUNT(*) AS total FROM properties {$where}");
$totalRow = $countResult->fetch_assoc();
$totalProperties = $totalRow['total'];
$totalPages = ceil($totalProperties / $limit);



echo '<div class="pagination">';
for ($i = 1; $i <= $totalPages; $i++) {
    $activeClass = ($i == $page) ? 'active' : '';
    echo '<span class="'.$activeClass.'" onclick="loadPage('.$i.')">'.$i.'</span>';
}
echo '</div>';

$conn->close();
?>

<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
   require "vendor/autoload.php";
   require_once "Model/MainProgram.php";

   $conn = new MainProgram;
   $items_num = 5;
   $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

   try 
   {
      if ($conn->connect()) 
      {
         $offset = ($currentPage - 1) * $items_num;
         $fields = ["id", "product_name"];
         $items = $conn->getData($fields, $offset);
         
         if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"], $_POST["name_column"], $_POST["value"])) 
         {
               $searchField = $_POST["name_column"];
               $searchValue = $_POST["value"];
               
               if (!empty($searchField) && $searchField === "id" || $searchField === "product_name")
               {
                  $items = $conn->searchByColumn($searchField, $searchValue);
               } else {
                  echo "<span class='error-message'> Please provide a valid column name & valid value for searching :)</span>";
               }
         }
      ?>
         <form action="" method="post">
            <div class="form-content">
               <div>
                  <label for="name_column">Column Name</label>
                  <input type="text" id="name_column" name="name_column">
               </div>

               <div>
                  <label for="value">Value</label>
                  <input type="text" id="value" name="value">
               </div>

               <div>
                  <input type="submit" name="submit" value="Search" class="more-btn">
               </div>
               
            </div>
         </form>
         
         <table>
               <tr>
                     <th>id</th>
                     <th>product_name</th>
                     <th>Details</th>
               </tr>
      <?php
         if ($items !== null) 
         {
               foreach ($items as $item) 
               {
      ?>
                  <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['product_name']; ?></td>
                        <td><a href="details.php?id=<?php echo $item['id']; ?>" class="more-btn">More</a></td>
                  </tr>
      <?php
               }
         } else {
               echo "<tr><td colspan='3'>No items found !!!!!!!!!</td></tr>";
         }
      ?>
         </table>

         <div class="pagination">
               <?php if ($currentPage > 0 && $currentPage <= 4) { ?>
                  <a href="?page=<?php if($currentPage == 1) { echo 1; } else { echo ($currentPage - 1); } ?>">&laquo;</a>
               <?php } ?>

               <?php for ($i = 1; $i <= 4; $i++){ ?>
                  <a <?php if ($i == $currentPage) echo 'class="active"'; ?> href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
               <?php } ?>

               <?php if ($currentPage <= 4){ ?>
                  <a href="?page=<?php if($currentPage == 4) { echo 1; } else { echo ($currentPage + 1); } ?>">&raquo;</a>
               <?php } ?>
         </div>
      <?php
      }
   } 
   catch (\Exception $e) 
   {
      echo "An error occurred: " . $e->getMessage();
   }
?>
</body>
</html>

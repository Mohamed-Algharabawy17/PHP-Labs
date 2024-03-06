<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
   require "./vendor/autoload.php";
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

         /******************************* get data from db and validate user input ******************************/

         if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"], $_POST["value"])) 
         {
            if ($_POST["submit"] === "Show All") 
            {
                $items = $conn->searchByColumn('id',"");
            } else if ($_POST["submit"] === "Search") 
            {
               $searchValue = $_POST["value"];
               $searchField = $_POST["field"];


               $validFields = ["product_name", "id", "PRODUCT_code", "list_price", "category"];
            
               if (!in_array($searchField, $validFields)) 
               {
                  echo "<span class='error-message'> Please select a valid search field :)</span>";
               } else {
                  if (!empty($searchValue))
                  {
                     $items = $conn->searchByColumn($searchField, $searchValue);
                     if ($items === null)
                     {
                        echo "<span class='error-message'> Please select a valid search field :)</span>";
                     }
                  } else {
                     echo "<span class='error-message'> Please provide a valid value for searching :)</span>";
                  }
               }
            }
         }



         if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"]) && $_POST["submit"] === "Add Now") 
         {
            $conn = new MainProgram();

            unset($_POST['submit']);

            $_POST['discontinued'] = isset($_POST['discontinued']) ? 1 : 0;

            $_POST['date'] = date('Y-m-d g:i:s', strtotime($_POST['date']));

            if (empty($_POST['id'])) 
            {
               echo "ID cannot be null";
            } else {
                  $existingRecord = $conn -> checkExistingID($_POST['id']);
                  if ($existingRecord) {
                     echo "Duplicate ID found. The item this ID already exists in the database";
                  } else {
                     $conn->insertItem($_POST);
                  }
            }
        }

      ?>

         <!------------------------------------------------ Add item form ---------------------------------------------->

         <?php 

         if(isset($_POST["submit"]) && $_POST["submit"] === "Add Item")
         {
         
         ?>
         <div class="add-form">
            <form action="" method="post">

               <div>
                  <input type="text" id="fname" name="id" placeholder="id">

                  <input type="text" id="lname" name="PRODUCT_code" placeholder="PRODUCT_code">

                  <input type="text" id="lname" name="product_name" placeholder="product_name">

               </div>

               <div>

                  <input type="text" id="lname" name="Photo" placeholder="Photo EX: img.png">

                  <input type="text" id="lname" name="list_price" placeholder="list_price">

                  <input type="text" id="lname" name="reorder_level" placeholder="reorder_level"> 
               </div>

               <div>

                  <input type="text" id="lname" name="Units_In_Stock" placeholder="Units_In_Stock">

                  <input type="text" id="lname" name="CouNtry" placeholder="CouNtry">

                  <input type="text" id="lname" name="Rating" placeholder="Rating">

               </div>

               <div>
                  <input type="text" id=  "lname" name="date" placeholder="date">

                  <input type="text" id="lname" name="discontinued" placeholder="discontinued">

               </div>


               <div class="category-menu">
                  <label>category</label>
                  <select id="country" name="category">
                     <option value="sunglasses">sunglasses</option>
                     <option value="Kontrollkästchen einzuschließen">Kontrollkästchen einzuschließen</option>
                  </select>
               </div>

               <div class="add-btn">
                  <input type="submit" name="submit" value="Add Now">  
               </div>

               
            </form>
         </div>
         <?php } ?>

         <!------------------------------------------------- Search form ----------------------------------------------->

         <form action="" method="post">
            <div class="form-content">
               <div>
                  <select name="field" class="search-menu">
                     <option value="product_name">Product Name</option>
                     <option value="id">ID</option>
                     <option value="PRODUCT_code">Product Code</option>
                     <option value="list_price">List Price</option>
                     <option value="category">Category</option>
                  </select>
               </div>

               <div>
                  <label for="value">Value</label>
                  <input type="text" id="value" name="value">
               </div>

               <div>
                  <input type="submit" name="submit" value="Search" class="more-btn">
                  <input type="submit" name="submit" value="Show All" class="show-btn">
                  <input type="submit" name="submit" value="Add Item" class="more-btn"> 
               </div>
               
            </div>
         </form>

          <!--------------------------------------------- Draw items table -------------------------------------------------->

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

          <!--------------------------------------------- Draw pagination bar ----------------------------------------------->

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

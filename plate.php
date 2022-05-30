<?php include('./includes/db.php');
// error_reporting(0);
session_start();
if (!isset($_SESSION['user_name'])) {
  header("Location: ./Login.php");
}
$myquery = "SELECT * FROM plate WHERE plate_status = :status";
$stmt = $pdo->prepare($myquery);
$stmt->execute([':status' => 'Published']);
$row = $stmt->rowCount();

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
if (isset($_POST['addToCart'])) {
  if (isset($_SESSION['login'])) {

    array_push(
      $_SESSION['cart'],
      [
        'produit_id' => $_POST['food_id'],
        'food_name' => $_POST['name'],
        'description' => $_POST['description'],
        'produit_prix' => $_POST['price'],
        'produit_quantite' => $_POST['quantite'],
        'food_image' => $_POST['image'],
      ]
    );
  } else {
    header('Location: Login.php');
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <style>
    .topnav {
      background-color: #333;
      overflow: hidden;
    }

    .c1 {
      width: 1000px;
      display: inline-block;
    }


    /* Style the links inside the navigation bar */
    .topnav a {
      float: left;
      color: #f2f2f2;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
      font-size: 17px;
    }

    /* Change the color of links on hover */
    .topnav a:hover {
      background-color: #ddd;
      color: black;
    }

    /* Add a color to the active/current link */
    .topnav a.active {
      background-color: #04AA6D;
      color: white;
    }

    .nav-item {
      text-align: right;
      justify-content: end;
      margin-left: 800px;
    }

    h1 {
      font-size: 50px;
      font-family: serif;
      width: 250;
      background-image: linear-gradient(to right, #d1d1d1, white);
    }
  </style>
</head>

<body>
  <!-- nav barrr -->
  <div class="topnav">
    <a href="menu.php">Menu</a>
    <a href="checkout.php">Checkout</a>
    <?php if (isset($_SESSION['login'])) { ?>
      <a href="logout.php" class="nav-item">Logout</a>



    <?php
    } ?>
  </div>

  <section>
    <!-- <div class="row"> -->

    <h1><?php echo $_GET['platecat_name']; ?>:</h1>
    <hr />
    <?php
    if (isset($_POST['key'])) {
      $keyword = $_POST['key'];
      $sql = "SELECT * FROM plate WHERE plate_name LIKE :food";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([
        ':food' => '%' . trim($key) . '%'
      ]);
      $produit_found = 0;
      $count = $stmt->rowCount();
      if ($count == 0) {
        $produit_found = 0;
      } else {
        $produit_found = $count;
      }
    }

    ?>
    <?php
    // DONT TOUCH ITTT
    // if(isset($_POST['search'])){
    // $key = $_POST['key'];
    $sql = "SELECT * FROM plate WHERE plate_status = :status AND plate_post_id = :id    Limit 5";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      ':status' => 'Published',
      // ':food' => '%'.$key.'%',
      ':id' => $_GET['platecat_id']
    ]);
    // var_dump($_GET['platecat_id']);
    ?>
    <!-- griddddddddddddddddddddd!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
    <div class="row">

      <form class="c1" action="plate.php?platecat_id=<?php echo $_GET['platecat_id']; ?>&platecat_name=<?php echo $_GET['platecat_name']; ?>" method="POST">
        <input hidden name="food_id" value="<?php echo $food_id; ?>">
        <input type="hidden" name="name" value="<?php echo $food_name; ?>">
        <input type="hidden" name="image" value="<?php echo $food_image ?>">
        <input type="hidden" name="price" value="<?php echo $food_price ?>">
        <input type="hidden" name="description" value="<?php echo $food_detail ?>">
        <?php
        while ($plate = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $food_id = $plate['plate_id'];
          $food_name = $plate['plate_name'];
          $food_detail = substr($plate['plate_detail'], 0, 40);
          // $plate_image = $plate['plate_image'];
          $food_price = $plate['price'];

        ?>

          <div class="col-md-6  col-xl-4 mb-5">
            <div class="card-body">

              <a class="card post-preview lift h-100 btn btn-secondary">
                <!--img class="card-img-top" style="height: 140px "src="./images/<//?php echo $plate_image; ?>" alt="<//?php echo $plate_image; ?>" /-->
                <div class="card-body">
                  <h5 class="card-title text-dark"><?php echo $food_name; ?></h5>
                  <p class="card-text text-dark"><?php echo $food_detail; ?></p>
                  <span class="card-text text-dark"> $<?php echo number_format($food_price, 2); ?></span>

                </div>

                <input class="form-control mt-2" name="quantite" type="number" value="1" required />
                <button type="submit" name="addToCart" class="btn btn-secondary mt-2" id="addToCart">add to cart</button>

              </a>
            </div>
          </div>

        <?php
        }
        ?>

      </form>
    </div>
    </div>
    <!-- </div> -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>

</html>
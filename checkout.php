<?php 
include('./includes/db.php');
session_start();
// error_reporting(0);

if(!isset($_SESSION['user_name'])) {
    header("Location: ./Login.php");
}
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Menu</title>
        <link rel="stylesheet" href="menu.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<style>
        .topnav {
    background-color: #333;
    overflow: hidden;
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
  .nav-item{
      text-align: right;
      justify-content: end;
      margin-left: 800px;
  }
    </style>
    </head>

    <body>

    <div class="topnav">
    <a href="menu.php">Menu</a>          
    <?php if(isset($_SESSION['login'])) { ?>
 <a href="logout.php">Logout</a> 
    <?php } ?>
    </div>

<div class="table-responsive-sm">
        <table class="table table-striped">
                <thead>
                <tr>
                <th class="center">#</th>
                <th>Item</th>
                <th>Description</th>
                <th class="right">Price</th>
                <th class="center">Qty</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
        <?php 
                  $total = 0;
                  $subtotal = 0;
                  if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0){
                  foreach($_SESSION['cart'] as $produit){
                      $subtotal = intVal($produit['produit_prix']) * intVal($produit['produit_quantite']);
                      $total += $subtotal;
                    //   var_dump($produit['produit_prix']);
                    //   var_dump($produit['produit_quantite']);
                      ?>
                       <tr>
                        <td class="center"><?php echo $produit['produit_id']?></td>
                        <td class="left strong"><?php echo $produit['food_name']?></td>
                        <td class="left"><?php echo $produit['description']?></td>
                        <td class="right"><?php echo $produit['produit_prix'] ?></td>
                        <td class="center"><?php echo $produit['produit_quantite']?></td>
                        <td class="right"><?php echo $subtotal?></td>
                        </tr>
           
                      <?php
                  }
                }else{
                    ?>
                        <div class="alert alert-warning text-center" role="alert" >No Plates Chosen</div>
                    <?php
                }
            ?>
        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-lg-4 col-sm-5">
    </div>
    <div class="col-lg-4 col-sm-5 ml-auto">
        <table class="table table-clear">
            <tbody>
               
                <tr>
                    <td class="left">
                        <strong class="text-dark">Total</strong> </td>
                    <td class="right">
                    <?php 
                  $total = 0;
                  $subtotal = 0;
                  if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0){
                  foreach($_SESSION['cart'] as $produit){
                      $subtotal = intVal($produit['produit_prix']) * intVal($produit['produit_quantite']);
                      $total += $subtotal;
                  }}?>
                         <strong class="text-dark"> <?php echo $total; ?></strong>
                    </td>
                </tr>
                <tr>
                    <td class="left">
                        <?php

                        if(isset($_POST['totale'])){
                         $stmt = $pdo->prepare("INSERT INTO argent (at_date, som) values (:created, :montant) ");
                         $stmt->execute([
                             ':created' => date("d"),
                             ':montant' => $total,  
                         ]);
                         }
                        ?>

                        
                        <form action="menu.php" method="POST">
                            <button type="button" name="totale" value="montant" class="btn btn-success">Check revenu</button>
                            <button type="button" name="reseter" value="reseter" class="btn btn-secondary">Reset</button>
                        </form>
                        <?php
                       
                           if(isset($_POST['reseter'])){
                            unset($_SESSION['cart']);
                           $_SESSION['cart'] = [];
                       }
                        ?>
                    </td>
                    <td class="right"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>




</html>
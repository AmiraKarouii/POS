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



@import url('https://fonts.googleapis.com/css?family=Exo:400,700');

*{
    margin: 0px;
    padding: 0px;
}

body{
    font-family: 'Exo', sans-serif;
}

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
  .c1{
float: left;
margin-left: 30px;
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
  h2{
    font-size:50px;
    font-family: serif;
width: 280;
    background-image: linear-gradient(to right,#d1d1d1, white);
}
 
    </style>
    </head>

<body>

<div class="topnav">
    <a href="menu.php">Home</a>
    <a href="checkout.php">Checkout</a>                             
    <a href="logout.php">Logout</a> 
    <a><?php echo $_SESSION['user_name'] ;?></a>
                                        

</div>

  <h2><strong>Menu: </strong></h2>
    
    
  


<section class="bg-transperant flex space-x-4 py-10">       
       <div class="container">        
        <hr/>
        <?php 
            $sql4 = "SELECT * FROM platecat WHERE platecat_status = :status";
            $stmt = $pdo->prepare($sql4);
            $stmt->execute([
                ':status' => 'Published'
            ]);
            while($category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $category_id = $category['platecat_id'];
                $category_name = $category['platecat_name'];
                $category_photo = $category['platecat_photo'];
                $category_total_post = $category['platecat_total_posts'];
                ?>
      <div class="c1" class="col-lg-4 col-md-6 mb-4">            
        <a class="card card-link border-top border-top-lg border-secondary h-10 lift btn btn-secondary" 
        href="plate.php?platecat_id=<?php echo $category_id; ?>&platecat_name=<?php echo $category_name; ?>">
      <div class="card-body p-5">                
                <!-- display PHOTO! -->
                <!-- <img class="card-img-top" src="./images/<!?php echo $category_photo; ?>
                 " alt="</?php echo $category_photo; ?>" /> -->
                    <div class="icon-stack icon-stack-lg bg-transparent text-dark mb-4"><i data-feather="user"></i>
                        <h3><br><?php echo $category_name; ?></h3>
                    </div>    
                    </div>
                     <div class="c1" class="card-footer bg-secondary text-white pt-0 pb-4">
                    <div class="badge badge-pill badge-light font-weight-normal px-3 py-2">
                    <?php echo $category_total_post; ?> Plate(s)
                </div></div></a></div>           
            
            <?php } ?>
        

</div>         
            
</section>           
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>

</html>
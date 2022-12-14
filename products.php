<?php
include("./server/connect.php");


  if(isset($_POST['filter_search']))  {

       $price = $_POST['price'];

       if(isset($_POST['Category'])){
        $category =$_POST['Category'];
        
        $all_products_qry = "SELECT * FROM products WHERE product_category='$category' AND product_price<='$price'";
        $all_products_result = mysqli_query($con, $all_products_qry);
       }else{
        $all_products_qry = "SELECT * FROM products WHERE  product_price<='$price'";
     
        $all_products_result = mysqli_query($con, $all_products_qry);
       }
  
  }else{
    $all_products_qry = "SELECT * FROM products";
    $all_products_result = mysqli_query($con, $all_products_qry);
    
  }


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- bootstrap link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/css/styles.css">

</head>

<body class="bg-light">
    <!-- main navbar section -->

    <nav class="navbar navbar-expand-lg navbar-light bg-primary py-3 ">
        <div class="container-fluid">
            <a class="navbar-brand" href="./">Shopping site</a>


            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="products.html">Products</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="contact.html">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.html">Cart<i class="fa-sharp fa-solid fa-cart-shopping"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Account.html">Account<i class="fa-solid fa-user"></i></a>
                </li>

            </ul>




        </div>

    </nav>

    <div class=" mx-5 mt-5 ">

        <div class="row">
        <h3 class="text-center mb-4">Our Products</h3>
            <div class="col-md-2 " >
                <h4 class="text-center">Search products</h4>

                <h5 class=" mt-5">Category</h5>
                 <form action="./products.php" method="POST">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="Category" value="Casual bags" >
                    <label class="form-check-label" for="flexRadioDefault1">
                        Causal Bags
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="Category" value="Travel bags" >
                    <label class="form-check-label" for="flexRadioDefault2">
                        Travel bags
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="Category" value="Handbags " >
                    <label class="form-check-label" for="flexRadioDefault2">
                        Handbags
                    </label>
                </div>

                <h5 class=" mt-5">Price</h5>
                <input type="range" class="form-range " name="price" value="1000"  min="100" max="10000" id="customRange1">
                <div class="">
                    <span style="float: left;">100</span>
                    <span style="float: right;">10000</span>
                </div>
                <div class="w-50 ">
                <input type="submit" value="search" name="filter_search" class="form-control mt-3 btn btn-primary">

                </div>
                </form>
            </div>
            <div class="col-md-10">
                <div class="row"> 
                      
                    <?php while ($all_products = mysqli_fetch_array($all_products_result)) { ?>
                        <div class='col-md-3 mb-3'>
                            <div class="card" style="width: 18rem;">
                                <img class="card-img-top" src="../E-com/images/<?php echo $all_products['product_image1']; ?>" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $all_products['product_name'] ?></h5>
                                    <p class="card-text text-center"><?php echo $all_products['product_price']; ?></p>
                                    <a href="./single-product.php?product_id=<?php echo $all_products['product_id'] ?>" class="btn btn-primary">Buy Now</a>

                                </div>
                            </div>
                        </div>

                    <?php } ?>

                </div>
            </div>
        </div>


    </div>

    <footer class="mb-0 mt-5">
        <div class=" bg-primary p-3 text-light ">
            <p class="text-center ">@copyright 2022</p>
        </div>

    </footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>
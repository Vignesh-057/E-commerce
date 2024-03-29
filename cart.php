<?php
    include("./include/connect.php");
    include('functions/common_function.php');
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flippy Shopping-Cart details</title>
    <!-- css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- css file link -->
    <link rel="stylesheet" href="style.css">
    <style>
        .cart_img{
            width: 80px;
            height: 80px;
            object-fit: contain;
        }
    </style>
  </head>
<body>
    <!-- navbar -->
    <div class="container-fluid p-0">
        <!-- first child -->
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
          <div class="container-fluid">
            
            <img src="./images/logo.jpg" alt="" class="logo">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="display_all.php">Products</a>
                </li>
                <?php
                    if(isset($_SESSION['username'])){
                      echo "<li class='nav-item'>
                              <a class='nav-link' href='./users_area/profile.php'>My Account</a>
                          </li>";
                    }else{
                      echo "<li class='nav-item'>
                              <a class='nav-link' href='./users_area/user_registration.php'>Register</a>
                          </li>";

                    }
                ?>
                <li class="nav-item">
                  <a class="nav-link" href="#">Contact</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php cart_item();?></sup></i></a>
                </li>
              </ul>
            </div>
          </div>
        </nav>

        <!-- second child -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
          <ul class="navbar-nav me-auto">

            <?php
                if(!isset($_SESSION['username'])){
                  echo "<li class='nav-item'>
                          <a class='nav-link' href='#'>Welcome Guest</a>
                        </li>";
                }else{
                  echo "<li class='nav-item'>
                          <a class='nav-link' href='#'>Welcome ".$_SESSION['username']."</a>
                        </li>";
                }

                if(!isset($_SESSION['username'])){
                  echo "<li class='nav-item'>
                          <a class='nav-link' href='./users_area/user_login.php'>Login</a>
                        </li>";
                }else{
                  echo "<li class='nav-item'>
                          <a class='nav-link' href='./users_area/logout.php'>Logout</a>
                        </li>";
                }
            ?>

          </ul>
        </nav>

        <!-- Third child -->
        <div class="bg-light">
          <h3 class="text-center">Flippy Store</h3>
          <p class="text-center">Communication is at the heart of e-commerce and community</p>
        </div>

        <!-- fourth child -->
        <div class="container">
            <div class="row">
                <form action="" method="post">
                    <table class="table table-bordered text-center">
                            <!-- php code to display dynamic data-->
                            <?php
                                global $con;

                                $usser_id = userid();
                                $total_price = 0;
                                $cart_query = "SELECT * FROM `cart_details` WHERE user_id = '$usser_id'";
                                $result = mysqli_query($con,$cart_query);
                                
                                $count_number_of_rows = mysqli_num_rows($result);
                                if($count_number_of_rows>0){
                                    echo " <thead>
                                            <tr>
                                                <th>Product Title</th>
                                                <th>Product Image</th>
                                                <th>Quantity</th>
                                                <th>Total Price</th>
                                                <th>Remove</th>
                                                <th colspan='2'>Operations</th>
                                            </tr>
                                        </thead>
                                        <tbody>";

                                    while($row = mysqli_fetch_array($result)){
                                        $product_id = $row['product_id'];


                                        //// fetching quanatity form cart table for display in cart grid
                                        $usser_id = userid();
                                        $quantity_fect_query = "SELECT * FROM `cart_details` WHERE user_id = $usser_id and product_id= $product_id ";
                                        $result_fetch_quntity = mysqli_query($con,$quantity_fect_query);
                                        $fetch_quantity = mysqli_fetch_assoc($result_fetch_quntity);
                                        $quantity = $fetch_quantity['quantity'];

                                        


                                        $select_product_price = "SELECT * FROM `products` WHERE product_id = '$product_id'";
                                        $result_product = mysqli_query($con,$select_product_price);
                                        while($row_product_price = mysqli_fetch_array($result_product)){
                                          // $product_price = array($row_product_price['product_price']);
                                          $price_table = $row_product_price['product_price'];
                                          $product_title = $row_product_price['product_title'];
                                          $product_image1 = $row_product_price['product_image1'];
                                          $product_iid = $row_product_price['product_id'];
                                          // $product_values= array_sum($product_price);
                                          // $total_price += $product_values;
                                
                            ?>
    
                            <tr>
                                <td><?php echo $product_title; ?></td>
                                <td><img src="./admin_area/product_images/<?php echo $product_image1; ?>" alt="" class="cart_img"></td>
                                <!-- <td><input type="text" name="quantity" class="form-input w-50"></td> -->
                                <td><input type="text" name="quantity[<?php echo $product_id; ?>]" value="<?php echo $quantity; ?>" class="form-input w-50"></td>

                                <?php
                                    $get_ip_address = getIPAddress();
                                    // if(isset($_POST['update_cart'])){
                                    //     $quantity = $_POST['quantity'];

                                    //     $user__name = $_SESSION['username'];
                                    //     $select_id = "SELECT * FROM `user_table` WHERE username='$user__name'";
                                    //     $result_id = mysqli_query($con,$select_id);
                                    //     $fetch_id = mysqli_fetch_assoc($result_id);
                                    //     $usser_id = $fetch_id['user_id'];

                                    //     $update_cart = "UPDATE `cart_details` SET quantity=$quantity WHERE product_id = '$product_id' and user_id = '$usser_id'";
                                    //     $result_product_quantity = mysqli_query($con,$update_cart);
                                    //     $total_price = $total_price*$quantity;
                                    // } 
                                    if(isset($_POST['update_cart'])){
                                      foreach($_POST['quantity'] as $product_id => $quantity){
                                          // echo $_POST['quantity'];
                                          if(!empty($quantity)) {
                                            // Your existing update query code here
                                            $user__name = $_SESSION['username'];
                                            $select_id = "SELECT * FROM `user_table` WHERE username='$user__name'";
                                            $result_id = mysqli_query($con,$select_id);
                                            $fetch_id = mysqli_fetch_assoc($result_id);
                                            $usser_id = $fetch_id['user_id'];
                                            
                                            // Perform the update query
                                            $update_cart = "UPDATE `cart_details` SET quantity=$quantity WHERE product_id = '$product_id' AND user_id = '$usser_id'";
                                            $result_product_quantity = mysqli_query($con,$update_cart);
                                            
                                            if($result_product_quantity){
                                                // Successful update
                                                echo "<script>window.open('cart.php','_self')</script>";
                                            } else {
                                                // Handle update failure
                                                echo "<script>alert('Failed to update cart')</script>";
                                            }
                                          }
                                          
                                      }
                                  }
                                  
                                  ?>
                                
                                <td><?php echo $price_table; ?>/-</td>
                                <td><input type="checkbox" name="removeitem[]" value="<?php echo $product_id; ?>"></td>
                                <td>
                                    <!-- <button class="bg-info px-3 py-2 border-0 mx-3">Update</button> -->
                                    <input type="submit" value="Update Cart" class="bg-info px-3 py-2 border-0 mx-3" name="update_cart">
                                    <!-- <button class="bg-info px-3 py-2 border-0 mx-3">Remove</button> -->
                                    <input type="submit" value="Remove" class="bg-info px-3 py-2 border-0 mx-3" name="remove_cart">
                                </td>
    
                            </tr>
                            <?php
                                        }
                                    }
                                }else{
                                    echo "<h2 class='text-center text-danger'>Cart is empty</h2>";
                                }
                            ?>
                        </tbody>
                    </table>
                    <!-- subtotal -->
                    <div class="d-flex mb-5">
                        <?php
                            $get_ip_address = getIPAddress();
                            $user_id = userid();
                            $cart_query = "SELECT * FROM `cart_details` WHERE user_id = 'user_id'";
                            $result = mysqli_query($con,$cart_query);
                            $count_number_of_rows = mysqli_num_rows($result);
                            if($count_number_of_rows>0){
                              $usser_id = userid();
                              $total_price = 0;
                              $cart_query = "SELECT * FROM `cart_details` WHERE user_id = '$usser_id'";
                              $result = mysqli_query($con,$cart_query);
                              while($row_product_price = mysqli_fetch_array($result)){
                                $product_price = array($row_product_price['quantity'] * $row_product_price['product_price']);
                                $product_values= array_sum($product_price);
                                $total_price += $product_values;
                              }
                              
                                echo " <h4 class='px-3'>Subtotal: <strong class='text-info'> $total_price/-</strong></h4>
                                       <input type='submit' value='Continue Shopping' class='bg-info px-3 py-2 border-0 mx-3' name='continue_shopping'>
                                       <button class='bg-secondary px-3 py-2 border-0'><a href='./users_area/checkout.php' class='text-light text-decoration-none'>Checkout</a></button>";
                            }else{
                                echo "<input type='submit' value='Continue Shopping' class='bg-info px-3 py-2 border-0 mx-3' name='continue_shopping'>";
                            }

                            if(isset($_POST["continue_shopping"])){
                                echo "<script>window.open('index.php','_self')</script>";
                            }
                        ?>
                       
                    </div>
                </form>
            </div>
        </div>

        <!-- function to remove item-->
        <?php
            function remove_cart_item(){
                global $con;
                if(isset($_POST['remove_cart'])){
                    foreach($_POST['removeitem'] as $remove_id){
                        echo $remove_id;
                        $delete_query = "DELETE FROM `cart_details` WHERE product_id=$remove_id";
                        $run_delete = mysqli_query($con,$delete_query);
                        if($run_delete){
                            echo "<script>window.open('cart.php','_self')</script>";
                        }
                    }
                }
            }
            echo $remove_item = remove_cart_item();
        ?>

        



        <!-- last child -->
        <!-- include footer -->
        <!-- <div class="fixed-bottom"> -->
            <?php
                include('./include/footer.php');
            ?>
        <!-- </div> -->
        
    </div>










    <!-- js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>
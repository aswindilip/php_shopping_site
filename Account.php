<?php
include("./server/connect.php");

session_start();


if (!isset($_SESSION['logged_in'])) {
    header("location:login.php");
    exit;
}

if (isset($_GET['logout'])) {
    if (isset($_SESSION['logged_in'])) {
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        header("location:login.php");
        exit;
    }
}

if (isset($_POST['change_password'])) {

    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $current_password = md5($_POST['current_password']);
    $user_email = $_SESSION['user_email'];
    $check_pass_qry = "select * from users where user_email='$user_email'";

    $check_pass_result = mysqli_query($con, $check_pass_qry);

    while ($row = mysqli_fetch_array($check_pass_result)) {

        if ($current_password == $row['user_password']) {

            if ($new_password !== $confirm_password) {
                header("location:Account.php?error=password do not match");
            } elseif (strlen($new_password) < 6) {
                header("location:Account.php?error= password is too short 6 characters needed ");
            } else {
                $new_password = md5($new_password);



                $change_qry = "UPDATE users SET user_password='$new_password' WHERE user_email='$user_email'";
                $change_result = mysqli_query($con, $change_qry);
                if ($change_result) {
                    header("location:Account.php?change_message=password changed successfully");
                } else {
                    header("location:Account.php?error=somthing went wrong password not changed ");
                }
            }
        } else {
            header("location:Account.php?error=wrong password ");
        }
    }
}

if (isset($_SESSION['logged_in'])) {
    $user_id = $_SESSION['user_id'];
    $order_qry = "SELECT * FROM orders WHERE user_id='$user_id' ";
    $order_result = mysqli_query($con, $order_qry);
}

?>


<?php include("./layout/header.php"); ?>


    <!-- Account section -->

    <div class="row">
        <div class="col-md-6 text-center">
            <p class="text-center mt-3 text-success"><?php if (isset($_GET['message'])) {
                                                            echo $_GET['message'];
                                                        } ?></p>
            <h3 class=" mt-2">Account Info</h3>
            <p class=" mt-3">Name : <?php if (isset($_SESSION['user_name'])) {
                                        echo $_SESSION['user_name'];
                                    } ?> </p>
            <p class=" mt-3">Email : <?php if (isset($_SESSION['user_email'])) {
                                            echo $_SESSION['user_email'];
                                        } ?> </p>
            <a href="#orders" class="btn text-info">Your Order</a><br>
            <a href="Account.php?logout=1" class="btn text-info">Logout</a>

        </div>

        <div class="col-md-6 ">
            <p class="text-center text-danger mt-4"><?php if (isset($_GET['error'])) {
                                                        echo $_GET['error'];
                                                    } ?></p>
            <p class="text-center text-success"><?php if (isset($_GET['change_message'])) {
                                                    echo $_GET['change_message'];
                                                } ?></p>
            <h3 class="mt-5 text-center">Change Password</h3>
            <form action="" method="post">
                <div class="form-group m-auto w-50 ">
                    <label for="" class="mt-2">Current Password</label>
                    <input type="text" class="form-control" placeholder="Enter Current Password" name="current_password">
                    <label for="" class="mt-2">New Password</label>
                    <input type="text" class="form-control" placeholder="Enter NewPassword" name="new_password">
                    <label for="" class="mt-2">Confirm Password</label>
                    <input type="password" class="form-control" placeholder="Re-type New Password" name="confirm_password">
                    <div class="text-center">
                        <input type="submit" value="Change password" name="change_password" class="btn btn-success mt-2">

                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- Order section -->
    <div id="orders" class="container">
        <h3 class="mt-5">Your Order</h3>

        <table class="table mt-5 text-center ">
            <tr class="bg-primary">
                <th>Order_id</th>
                <th>Order cost</th>
                <th>Order status</th>
                <th>Order date</th>
                <th>Order details</th>
            </tr>
            <?php while ($order = mysqli_fetch_array($order_result)) { ?>
                <tr class="bg-secondary ">
                    <td>
                        <h6><?php echo $order['order_id'] ?></h6>
                    </td>

                    <td>
                        <h6><?php echo $order['order_cost'] ?></h6>
                    </td>

                    <td>
                        <h6><?php echo $order['order_status'] ?></h6>
                    </td>
                    <td>
                        <h6><?php echo $order['order_date'] ?></h6>
                    </td>
                    <td>
                        <form action="order_details.php" method="get">
                            <input type="hidden" name="order_status" value="<?php echo $order['order_status']; ?>">
                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                            <input type="submit" class="btn btn-primary" name="details_btn" value="Details">
                        </form>
                    </td>
                </tr>

            <?php } ?>
        </table>




    </div>
    <footer class="mb-0">
        <div class=" bg-primary p-3 text-light ">
            <p class="text-center ">@copyright 2022</p>
        </div>

    </footer>


<?php include("./layout/footer.php"); ?>
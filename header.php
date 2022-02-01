<?php
//session_start();
$pp= $_SESSION["profilePicture"];
?>





<header id="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a href="index.php" class="navbar-brand">
            <h3 class="px-5">
                <i class="fas fa-shopping-basket"></i> TP AMC
            </h3>
        </a>
        
        <img src="./upload/<?php echo $pp; ?>" class=\"img-fluid card-img-top\" width="100px"; height="100px"/>

        
        
        <button class="navbar-toggler"
            type="button"
                data-toggle="collapse"
                data-target = "#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup"
                aria-expanded="false"
                aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="mr-auto"></div>
            <div class="navbar-nav">
                <a href="cart.php" class="nav-item nav-link active">
                    <h5 class="px-5 cart">
                        
                        <?php
                     
                        echo"<td><a href='logout.php'>Logout</a></td>"; echo "<br>";
                        echo "<br>";
                        if( $_SESSION["role"]=="admin"){
                            echo "<pre><a href='page4admin.php'>Admin page</a></pre>";echo "<br>";
                            echo "<pre><a href='update4defaultuser.php?updateID=".$_SESSION["id"]."'>Click to update your information!</a></pre>";echo "<br>";
                            echo "<pre><a href='viewcart.php'>Press here to view cart</a></pre>";
                        }
                        elseif ( $_SESSION["role"]=="productadmin") {
                            echo "<pre><a href='productadmin.php'>Product admin page</a></pre>";echo "<br>";
                            echo "<pre><a href='update4defaultuser.php?updateID=".$_SESSION["id"]."'>Click to update your information!</a></pre>";echo "<br>";
                            echo "<pre><a href='updateorder.php'>Update customer orders</a></pre>";echo "<br>";
                            echo "<pre><a href='viewcart.php'>Press here to view cart</a></pre>";
                        }
                        else{
                            echo "<pre><a href='update4defaultuser.php?updateID=".$_SESSION["id"]."'>Click to update your information!</a></pre>";echo "<br>";
                            echo "<pre><a href='vieworder.php'>Check your orders</a></pre>";
                            echo "<pre><a href='viewcart.php'>Press here to view cart</a></pre>";
                        }
                         ?>
                    </h5>
                </a>
            </div>
        </div>

    </nav>
</header>








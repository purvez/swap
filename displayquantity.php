<?php 
$cartID = $_GET['cartID'];
?>
<body class="bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 m-auto">
                    <div class="card mt-5">
                        <div class="card-title">
                            <h3 class="bg-success text-white text-center py-3"> Update Form in PHP</h3>
                        </div>
                        <div class="card-body">
                           <form action="fxupdatecart.php?cartID=<?php echo $cartID ?>" method="post">
                               Quantity:<input type="text" class="form-control mb-2" placeholder=" quantity " name="quantity" value="1"><br>
									 <button class="btn btn-primary" name="update">Update</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    
</body>
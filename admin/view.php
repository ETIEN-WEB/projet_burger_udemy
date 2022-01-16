<?php

    require '../database.php';
//    recuperation dU ID
    if(!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);  
    }
//connesctio à la database on va stocker cette connection dans $db

$db = Database::connect();
$statement = $db->prepare('SELECT items.id, items.name, items.image, items.description, items.price, categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id WHERE items.id=?');
$statement->execute(array($id));
$items = $statement->fetch();





    function checkInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>






<! DOCTYPE html>
<html>
    
    <head> 
        
        <title> Burger code </title>
        
        <meta charset="utf-8"> 
          <meta name="viewport" content="width=device-width, initial=scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../css/styles.css">
        <link href="https://fonts.googleapis.com/css?family=Holtwood+One+SC" rel="stylesheet" type="text/css">
       
        <!--<script src="js/script.js"></script>-->
    
    
    
    </head>
    
    <body> 
        <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span>   Burger code <span class="glyphicon glyphicon-cutlery"></span> </h1>
        <div class=" col-sm-2"></div>
        <div class="container admin col-sm-8" >
            <div class="row"> 
                <div class="col-sm-6">
                    <h1> <strong> Voir un items  </strong></h1>
                    <br>
                    <form>
                        <div class="form-group">
                            <label> Nom : </label> <?php echo ' '. $items['name']; ?>
                        </div>  
                        <div class="form-group">
                            <label> Description : </label> <?php echo ' '. $items['description']; ?>
                        </div>
                        <div class="form-group">
                            <label> Prix: </label> <?php echo ' '. number_format((float)$items['price'],2,'.',''). ' '.'f'; ?>
                        </div>
                        <div class="form-group">
                            <label> Catégories : </label> <?php echo ' '. $items['category']; ?>
                        </div>
                        <div class="form-group">
                            <label> Images : </label> <?php echo ' '. $items['image']; ?>
                        </div>   
                    </form>
                    <br>
                    <div class="form-actions">
                        <a class="btn btn-primary" href="index.php"> <span class="glyphicon glyphicon-arrow-left"></span> Retour </a>
                        
                    </div>
                </div>

                

                    <div class="col-sm-6 site">  <!--un element du menu--> 
                        <div class="thumbnail">
                            <img src="<?php echo '../images/' . $items['image']; ?>" alt="...">
                            <div class="price"> <?php echo number_format((float)$items['price'],2,'.',''). ' '.'f'; ?></div>
                            <div class="caption">
                                <h4><?php echo  $items['name']; ?></h4>
                                <p> <?php echo $items['description']; ?> </p>
                                <a href="#" class="btn btn-order" role="button"> <span class="glyphicon glyphicon-shopping-cart"> </span> Commander</a>
                            </div>
                            
                        </div>
                        

                    </div>
                    
               
                

                

            </div>

        </div>
        <div class=" col-sm-2"></div>
    </body>
</html>


































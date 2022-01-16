<?php
require '../database.php';
$nameError = $descriptionError = $priceError = $categoryError = $imageError = $name = $description = $price = $category = $image = "";
if(!empty($_POST))
{

    $name = checkInput($_POST['name']);
    $description = checkInput($_POST['description']);
    $price = checkInput($_POST['price']);
    $category = checkInput($_POST['category']);
    $image = checkInput($_FILES['image']['name']);
    $imagepath = '../images/'. basename($image);
    $imageExtention = pathinfo($imagepath, PATHINFO_EXTENSION);
    $isSuccess = true;
    $isUploadsuccess = false;

    if(empty($name))
    {
        $nameError = "ce champ ne peiut pas être vide";
        $isSuccess = false;  
    } 
    if(empty($description))
    {
        $descriptionError = "ce champ ne peiut pas être vide";
        $isSuccess = false;  
    } 
    if(empty($price))
    {
        $priceError = "ce champ ne peiut pas être vide";
        $isSuccess = false;  
    } 
    if(empty($category))
    {
        $categoryError = "ce champ ne peiut pas être vide";
        $isSuccess = false;  
    } 
    if(empty($image))
    {
        $imageError = "ce champ ne peiut pas être vide";
        $isSuccess = false;  
    } 
    else
    {
        $isUploadsuccess = true;
        if($imageExtention != "jpg" && $imageExtention != "png" && $imageExtention != "jpeg" && $imageExtention != "gif")
        {
            $imageError = "les fichiers autorisés sont : .jpg, .jpeg, .png, .gif";
            $isUploadsuccess = false;
        }
        if(file_exists($imagepath))
        {
            $imageError = "le fichier existe déjà";
            $isUploadsuccess = false;
        }
        if($_FILES["image"]["size"] > 500000)
        {
          $imageError = "le fichier ne doit pas depaser les 500KB";
            $isUploadsuccess = false;  
        }
        if($isUploadsuccess)
            { 
           /*move_uploaded_file($_FILES["image"]["tmp_name"], $imagepath cete fonction permet de prendre l'image et de la mettre dans le dossier de destination */
                    if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagepath))
                {
                    $imageError = "ily a une erreur lors de l'upload";
                    $isUploadsuccess = false;
                }
            }
    }
    //$isSuccess
    if($isSuccess && $isUploadsuccess)
    {
        $db = Database::connect();
        $statement = $db->prepare("INSERT INTO items (name, description, price, category, image) values(?, ?, ?, ?, ?)");
        $statement->execute(array($name, $description, $price, $category, $image));
        Database:: disconnect();
        header("location: index.php");  
    }
}
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

        <div class="container admin"> 

            <div class="row"> 
                
               <!--name="name" : nom pour le recuperer avec la method post-->
                    
                    <h1> <strong> Ajouter un item</strong> </h1>
                    <br>
                    <form class="form" role="form" action="insert.php" method="post" enctype="multipart/form-data" > 

                        <div class="form-group"> 
                            <label for="name"> Nom:</label> 
                            <input type="text" class="form-control" id="name"  name="name" placeholder="Nom" value="<?php echo $name; ?>" >
                            <span class="help-inline "> <?php echo $nameError; ?> </span>

                         </div>


                         <div class="form-group"> 

                            <label for="description"> Description:</label> 
                            <input type="text" class="form-control" id="description"  name="description" placeholder="Description" value="<?php echo $description; ?>" >
                            <span class="help-inline "> <?php echo $descriptionError; ?> </span>
                         </div>


                         <div class="form-group">
                            <!--step="0.01" permet d'augmenter le nobre de 0,01-->

                         <label for="price"> Prix: (en franc cfa)</label> 
                            <input type="number" step="0.01" class="form-control" id="price"  name="price" placeholder="Prix" value="<?php echo $price; ?>" >
                            <span class="help-inline "> <?php echo $priceError; ?> </span>
                         </div>


                         <div class="form-group"> 

                            <label for="category"> Catégorie</label> 
                            <select class="form-control" id="category" name="category"> 
                                <?php
                                    $db= Database::connect();
                                    foreach($db->query('SELECT * FROM categories') as $row)
                                    {
                                        echo '<option value="'.$row['id'].'">'.$row['name'] . '</option>';

                                    }
                                    Database::disconnect();
                                ?>


                            </select>
                            <span class="help-inline "> <?php echo $categoryError; ?> </span>

                         </div>


                         <div class="form-group"> 

                            <label for="image"> Sélectionner une image :</label> 
                            <input type="file"  class="form-control" id="image"  name="image">
                            <span class="help-inline "> <?php echo $imageError; ?> </span>

                         </div>

                    
                    <br>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <span class="glyphicon glyphicon-pencil"></span> Ajouter </button>
                        <a class="btn btn-primary" href="index.php"> <span class="glyphicon glyphicon-arrow-left"> </span> Retour </a>
                    </div>
                    </form> 
                
            </div>
        </div>


    </body>


</html>
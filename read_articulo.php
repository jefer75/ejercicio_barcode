<?php
    session_start();
    require_once("conexion/conexion.php");
    // include("../../../controller/validarSesion.php");
    $db = new Database();
    $con = $db -> conectar();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fabricantes</title>
    <link rel="stylesheet" href="../../../css/tablas.css">
</head>
<body>
<form action="" method="POST">

<td>
<div class="btn-container">
            <td><input type="submit" value="Registrar" name="registrar" id="registrar"></td>
    </div>
</tr>
</form>
<?php 
if (isset($_POST['registrar'])){
    header('Location: registro.php');
}

?>
    <div class="formulario">


    <h1 class="title">Articulos</h1>
        <form method="POST" action="">
        <table>
            <tr class="gris">
                
                <td>Identificador</td>
                <td>Cantidad</td>
                <td>Articulo</td>
                <td>Precio</td>
                <td>Actualizar/eliminar</td>
            </tr>
            
            <?php 
             
                  $query = $con -> prepare("SELECT * FROM articulos");
                  $query -> execute ();
                  $resultados = $query -> fetchAll(PDO::FETCH_ASSOC);

                  foreach ($resultados as $fila){
            ?>
            <tr>
                <td><?php echo $fila['id_art']?></td>
                <td><?php echo $fila['barcode']?></td>
                <td><?php echo $fila['nombre']?></td>
                <td><?php echo $fila['precio']?></td>
                </td>
                <td>
                <a class="hiper" href="" onclick="window.open
                ('act_articulo.php?id=<?php echo $fila['id_art'] ?>','','width=500, height=400, toolbar=NO'); void(null);">Click Aqui</a>
                </td>
                
            </tr>
            <?php
                  }
            ?>
         
        </table>
 
        </form>               

    </div>

</body>

</html>
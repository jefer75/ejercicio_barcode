<?php
    require_once("conexion/conexion.php");
    $db = new Database();
    $con = $db -> conectar();

    require 'vendor/autoload.php';

    use Picqer\Barcode\BarcodeGeneratorPNG;

 $usua = $con -> prepare("SELECT * FROM articulos");
    $usua -> execute();
    $asigna = $usua ->fetchALL(PDO::FETCH_ASSOC);

    if((isset($_POST["registro"])) && ($_POST["registro"] == "formu")) {
        $nombre=$_POST['nombre'];
        $precio=$_POST['precio'];
        $codigo_barras = uniqid() . rand(1000, 9999);
        $generator = new BarcodeGeneratorPNG();
        $codigo_barras_imagenes = $generator -> getBarcode($codigo_barras, $generator::TYPE_CODE_128);

        file_put_contents(_DIR_ . '/imagenes/' . $codigo_barras . '.png', $codigo_barras_imagenes);

    if ($nombre=="" ||  $precio=="")
      {
         echo '<script>alert ("EXISTEN DATOS VACIOS");</script>';
         echo '<script>window.location="registro_empleados.php"</script>';
      }
      
      else{
        $Insertsql = $conectar -> prepare ("INSERT INTO articulos(nombre, barcode, precio) Value ($nombre, ?, $precio)");
    $Insertsql -> execute([$nombre, $codigo_barras, $precio]);

        echo '<script> alert("REGISTRO EXITOSO");</script>';
        echo '<script>window.location="read_articulo.php"</script>';
     }
   }
   ?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>ARTICULOS</title>
  <link rel="stylesheet" href="css/empresa.css">
</head>
  <body>
  <form action="" method="POST">

<td>
<div class="btn-container">
            <td><input type="submit" value="Regresar" name="regresar" id="registrar"></td>
    </div>
</tr>
</form>
<?php 
if (isset($_POST['regresar'])){
    header('Location: read_articulo.php');
}

?>

    <section class="form_wrap">

        <section class="cantact_info">
            <section class="info_title">
                <span class="fa fa-user-circle"></span>
                <h2>FORMULARIO DE ARTICULO</h2>
            </section>
            
        </section>

        <div class="container mt-3">
        <table class="table table-striped table-bordered table-hover">
            <thead class="thead-dark">
                <tr style="text-transform: uppercase;">
                    <th>nombre</th>
                    <th>codigo de barras</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($asigna as $usua) { ?>
                    <tr>
                        <td><?=$usua["nombre"] ?></td>
                        <td><img src="imagenes/<?= $usua["codigo_barras"] ?>.png" style="max-width: 400px;"></td>
                    <tr>
                <?php } ?>
            </tbody>
            </table>
    </div>

        <form enctype="multipart/form-data" method="POST">
            <div class="form_group">

                <label for="nombre">Nombre de articlulo</label>
                <input type="varchar" id="nombre" name="nombre">

                <label for="precio">Precio</label>
                <input type="bigint" id="precio" name="precio">

                <div class="form-group">
                <input type="submit" class="btn btn-success" value="Registrate">
                <input type="hidden" name="registro" value="formu">
                </div>
     </div>
        </form>

    </section>
    <script src="js/empresa.js"></script>

</body>
</html>
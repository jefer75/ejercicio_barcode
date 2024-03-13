<?php
require_once("conexion/conexion.php");
$db = new Database();
$conectar = $db->conectar();

require 'vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorPNG;

 $usua = $conectar -> prepare("SELECT * FROM articulos");
    $usua -> execute();
    $asigna = $usua ->fetchALL(PDO::FETCH_ASSOC);

    if((isset($_POST["registro"])) && ($_POST["registro"] == "formu")) {
        $nombre=$_POST['nombre'];
        $precio=$_POST['precio'];
        $codigo_barras = uniqid() . rand(1000, 9999);
        $generator = new BarcodeGeneratorPNG();
        $codigo_barras_imagenes = $generator -> getBarcode($codigo_barras, $generator::TYPE_CODE_128);

        file_put_contents(_DIR_ . '/imagenes/' . $codigo_barras . '.png', $codigo_barras_imagenes);


        $Insertsql = $conectar ->prepare("INSERT INTO articulos(nombre, barcode) Value (?, ?, ?)");
        $Insertsql ->execute([$nombre, $codigo_barras]);
    
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode</title>
</head>
<body>
<main class="contenedor sombra">

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

    
        <div class="container mt-5">   
            <h2>Persona</h2>
            <form  method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                    <br>
                    <label for="nombre">Precio</label>
                    <input type="number" class="form-control" id="precio" name="precio" required>
                </div>
                <input type="submit" class="btn btn-success" value="Registrate">
                <input type="hidden" name="registro" value="formu">
            </form>
        </div>
    </main>
</body>
</html>
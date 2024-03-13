<?php
    session_start();
    require_once("conexion/conexion.php");
    // include("../../../controller/validarSesion.php");
    $db = new Database();
    $con = $db -> conectar();

    //empieza la consulta
    $sql = $con -> prepare("SELECT * FROM articulos WHERE id_art='".$_GET['id']."'");
    $sql -> execute();
    $fila = $sql -> fetch ();

    //declaracion de variables de campos en la tabla

    if (isset($_POST['actualizar'])){

        $id_art= $_POST['id_art'];
        $nombre = $_POST['nombre'];
        $precio= $_POST['precio'];
        
            $insert= $con -> prepare ("UPDATE articulos SET nombre='$nombre', precio=$precio WHERE id_art = '".$_GET['id']."'");
            $insert -> execute();
            echo '<script> alert ("Registro actualizado exitosamente");</script>';
            echo '<script> window.close(); </script>';
                
        }

        else if (isset($_POST['eliminar'])){
            $id_art= $_POST['id_art'];
            
                $insert= $con -> prepare ("DELETE FROM articulos WHERE id_art = '".$_GET['id']."'");
                $insert -> execute();
                echo '<script> alert ("Registro actualizado exitosamente");</script>';
                echo '<script> window.close(); </script>';
                    
            }
?>

<!DOCTYPE html>
<html lang="en">
    <script>
        function centrar() {
            iz=(screen.width-document.body.clientWidth) / 2;
            de=(screen.height-document.body.clientHeight) / 3;
            moveTo(iz,de);
        }
    </script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Articulos</title>
    <link rel="stylesheet" href="../../../css/tablaedi.css">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/6375/6375816.png">
</head>
<body onload="centrar();">
    
        <table class="center">
            <form autocomplete="off" name="form_actualizar" method="POST">
                <tr>
                    <td>Identificador</td>
                    <td><input name="id_art" value="<?php echo $fila['id_art']?>" readonly></td>
                </tr>

                <tr>
                    <td>Nombre</td>
                    <td><input name="nombre" value="<?php echo $fila['nombre'] ?>" ></td>                 
                </tr>

                <tr>
                    <td>Precio</td>
                    <td><input type="number" name="precio" value="<?php echo $fila['precio'] ?>"></td>                 
                </tr>

                <tr>
                    <td><input type="submit" name="actualizar" value="Actualizar"></td>
                    <td><input type="submit" name="eliminar" value="Eliminar"></td>
                </tr>
            </form>
        </table>
</body>
</html>
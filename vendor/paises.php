<?php
// encabezados de respuesta
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Configuración de la base de datos
$servername = "localhost";
$username = "usuario";
$password = "contraseña";
$dbname = " IdentificativosYPoblacion";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Manejar solicitudes HTTP
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Manejar solicitud GET para obtener todos los países
    $sql = "SELECT * FROM paises";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    } else {
        echo json_encode(array());
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Manejar solicitud POST para crear un nuevo país
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['nombre']) && isset($data['identificativo']) && isset($data['poblacion'])) {
        $nombre = $data['nombre'];
        $identificativo = $data['identificativo'];
        $poblacion = $data['poblacion'];

        $sql = "INSERT INTO paises (nombre, identificativo, poblacion) VALUES ('$nombre', '$identificativo', '$poblacion')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(array("message" => "País creado correctamente"));
        } else {
            echo json_encode(array("error" => "Error al crear el país: " . $conn->error));
        }
    } else {
        echo json_encode(array("error" => "Datos incompletos para crear el país"));
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Manejar solicitud PUT para actualizar un país existente
    parse_str(file_get_contents("php://input"), $put_vars);
    $id = $put_vars['id'];
    $nombre = $put_vars['nombre'];
    $identificativo = $put_vars['identificativo'];
    $poblacion = $put_vars['poblacion'];

    $sql = "UPDATE paises SET nombre='$nombre', identificativo='$identificativo', poblacion='$poblacion' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "País actualizado correctamente"));
    } else {
        echo json_encode(array("error" => "Error al actualizar el país: " . $conn->error));
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Manejar solicitud DELETE para eliminar un país existente
    parse_str(file_get_contents("php://input"), $delete_vars);
    $id = $delete_vars['id'];

    $sql = "DELETE FROM paises WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "País eliminado correctamente"));
    } else {
        echo json_encode(array("error" => "Error al eliminar el país: " . $conn->error));
    }
}

// Cerrar conexión a la base de datos
$conn->close();
?>

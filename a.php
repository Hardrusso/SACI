<?php
// Verificar si se recibieron los datos del formulario
if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['tipo_persona'])) {
	// Asignar los datos del formulario a variables
	$nombre = $_POST['nombre'];
	$apellido = $_POST['apellido'];
	$tipo_persona = $_POST['tipo_persona'];

	// Conectar a la base de datos de MongoDB
	$mongo = new MongoDB\Driver\Manager("mongodb://localhost:27017");

	// Preparar el documento a insertar en la colección "ingresos"
	$documento = [
		'nombre' => $nombre,
		'apellido' => $apellido,
		'tipo_persona' => $tipo_persona,
		'fecha_hora' => new MongoDB\BSON\UTCDateTime()
	];

	// Insertar el documento en la colección "ingresos"
	$bulk = new MongoDB\Driver\BulkWrite();
	$bulk->insert($documento);
	$resultado = $mongo->executeBulkWrite('mi_db.ingresos', $bulk);

	// Verificar si la operación de inserción fue exitosa
	if ($resultado->getInsertedCount() == 1) {
		echo "Registro de ingreso exitoso.";
	} else {
		echo "Error al registrar el ingreso.";
	}
} else {
	echo "Error: faltan datos del formulario.";
}
?>

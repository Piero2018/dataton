<?php
$file = "resultados.json";

// Inicializar si no existe
if(file_exists($file)){
    $data = json_decode(file_get_contents($file), true);
} else {
    $data = [
        "acumulados" => ["1"=>0,"2"=>0,"3"=>0,"4"=>0,"5"=>0],
        "historial" => []
    ];
}

// Mostrar solo la tabla sin sumar (cuando se cambia de grupo)
if(isset($_POST["mostrar"])){
    mostrarResultados($data);
    exit;
}

// Si se envió formulario
$nombre = trim(htmlspecialchars($_POST["nombre"]));
$grupo = $_POST["grupo"];
$total = intval($_POST["p1"]) + intval($_POST["p2"]) + intval($_POST["p3"]) + intval($_POST["p4"]) + intval($_POST["p5"]);

// ---- VALIDACIÓN: ¿ya calificó este grupo? ----
foreach($data["historial"] as $item){
    if(strtolower($item["nombre"]) === strtolower($nombre) && $item["grupo"] === $grupo){
        echo "<p style='color:red; font-weight:bold;'>⚠️ $nombre ya calificó al Grupo $grupo. No puede volver a hacerlo.</p>";
        mostrarResultados($data);
        exit;
    }
}

// Actualizar acumulados
$data["acumulados"][$grupo] += $total;

// Guardar historial
$data["historial"][] = [
    "nombre" => $nombre,
    "grupo" => $grupo,
    "nota" => $total,
    "fecha" => date("Y-m-d H:i:s")
];

// Guardar en archivo
file_put_contents($file, json_encode($data));

// Mostrar resultados
echo "<p style='color:green; font-weight:bold;'>✅ $nombre calificó al Grupo $grupo con $total puntos.</p>";
mostrarResultados($data);

// ---- FUNCIONES ----
function mostrarResultados($data){
    echo "<h3>Tabla acumulada</h3>";
    echo "<table>";
    echo "<tr><th>Grupo</th><th>Puntaje acumulado</th></tr>";
    foreach($data["acumulados"] as $g => $puntaje){
        echo "<tr><td>Grupo $g</td><td>$puntaje</td></tr>";
    }
    echo "</table>";

    echo "<h3>Historial de calificaciones</h3>";
    echo "<table>";
    echo "<tr><th>Fecha</th><th>Nombre</th><th>Grupo</th><th>Nota</th></tr>";
    foreach(array_reverse($data["historial"]) as $item){
        echo "<tr>";
        echo "<td>{$item['fecha']}</td>";
        echo "<td>{$item['nombre']}</td>";
        echo "<td>Grupo {$item['grupo']}</td>";
        echo "<td>{$item['nota']}</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Calificación de Grupos</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    /* --- Tema oscuro elegante --- */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #0f172a;
      color: #e2e8f0;
      margin: 0;
      padding: 20px;
    }
    .card {
      background: #1e293b;
      border-radius: 14px;
      padding: 20px;
      margin: 20px auto;
      box-shadow: 0 6px 15px rgba(0,0,0,0.6);
      max-width: 850px;
      transition: transform 0.2s ease-in-out, box-shadow 0.3s;
    }
    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.8);
    }
    h2, h3 {
      text-align: center;
      color: #38bdf8;
    }
    label {
      display: block;
      margin: 6px 0;
    }
    input[type="text"], select {
      width: 100%;
      padding: 10px;
      margin-bottom: 14px;
      border: none;
      border-radius: 8px;
      background: #334155;
      color: #f1f5f9;
    }
    input[type="radio"] {
      accent-color: #38bdf8;
    }
    p {
      color: #f1f5f9;
      margin: 10px 0 6px;
    }
    .btn {
      background: linear-gradient(135deg, #0ea5e9, #06b6d4);
      color: white;
      border: none;
      padding: 14px 20px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      display: block;
      margin: 20px auto 0;
      width: 100%;
      transition: background 0.3s, transform 0.2s;
    }
    .btn:hover {
      background: linear-gradient(135deg, #0284c7, #0891b2);
      transform: scale(1.03);
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
      border-radius: 10px;
      overflow: hidden;
    }
    th, td {
      border: 1px solid #334155;
      padding: 12px;
      text-align: center;
    }
    th {
      background: #0ea5e9;
      color: #fff;
    }
    tr:nth-child(even) {
      background: #1e293b;
    }
    tr:nth-child(odd) {
      background: #0f172a;
    }
    tr:hover {
      background: #334155;
      transition: background 0.2s;
    }
    .success {
      color: #22c55e;
      font-weight: bold;
    }
    .error {
      color: #ef4444;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="card">
  <h2>Formulario de Calificación</h2>

  <form id="formulario">
    <label><b>Nombre de quien califica:</b></label>
    <input type="text" name="nombre" id="nombre" placeholder="Escribe tu nombre" required>

    <label><b>Selecciona el grupo:</b></label>
    <select name="grupo" id="grupo" required>
      <option value="">-- Selecciona --</option>
      <option value="1">Grupo 1</option>
      <option value="2">Grupo 2</option>
      <option value="3">Grupo 3</option>
      <option value="4">Grupo 4</option>
      <option value="5">Grupo 5</option>
    </select>

    <div id="preguntas">
      <!-- Pregunta 1 -->
      <p><b>Pregunta 1:</b></p>
      <label><input type="radio" name="p1" value="6" required>Muy deficiente</label>
      <label><input type="radio" name="p1" value="12" required>Deficiente</label>
      <label><input type="radio" name="p1" value="16" required>Aceptable</label>
      <label><input type="radio" name="p1" value="24" required>Bueno</label>
      <label><input type="radio" name="p1" value="30" required>Excelente</label>

      <!-- Pregunta 2 -->
      <p><b>Pregunta 2:</b></p>
      <label><input type="radio" name="p2" value="5" required>Muy deficiente</label>
      <label><input type="radio" name="p2" value="10" required>Deficiente</label>
      <label><input type="radio" name="p2" value="15" required>Aceptable</label>
      <label><input type="radio" name="p2" value="20" required>Bueno</label>
      <label><input type="radio" name="p2" value="25" required>Excelente</label>

      <!-- Pregunta 3 -->
      <p><b>Pregunta 3:</b></p>
      <label><input type="radio" name="p3" value="5" required>Muy deficiente</label>
      <label><input type="radio" name="p3" value="10" required>Deficiente</label>
      <label><input type="radio" name="p3" value="15" required>Aceptable</label>
      <label><input type="radio" name="p3" value="20" required>Bueno</label>
      <label><input type="radio" name="p3" value="25" required>Excelente</label>

      <!-- Pregunta 4 -->
      <p><b>Pregunta 4:</b></p>
      <label><input type="radio" name="p4" value="2" required>Muy deficiente</label>
      <label><input type="radio" name="p4" value="4" required>Deficiente</label>
      <label><input type="radio" name="p4" value="6" required>Aceptable</label>
      <label><input type="radio" name="p4" value="8" required>Bueno</label>
      <label><input type="radio" name="p4" value="10" required>Excelente</label>

      <!-- Pregunta 5 -->
      <p><b>Pregunta 5:</b></p>
      <label><input type="radio" name="p5" value="2" required>Muy deficiente</label>
      <label><input type="radio" name="p5" value="4" required>Deficiente</label>
      <label><input type="radio" name="p5" value="6" required>Aceptable</label>
      <label><input type="radio" name="p5" value="8" required>Bueno</label>
      <label><input type="radio" name="p5" value="10" required>Excelente</label>
    </div>

    <button type="submit" class="btn">Enviar Calificación</button>
  </form>
</div>

<div class="card">
  <h2>Resultados en Vivo</h2>
  <div id="resultados"></div>
</div>

<script>
$(document).ready(function(){
  // Mostrar resultados iniciales
  $.post("procesar.php", {mostrar:"si"}, function(data){
    $("#resultados").html(data);
  });

  // Limpiar radios al cambiar de grupo y mostrar tabla general
  $("#grupo").change(function(){
    $("#preguntas input[type=radio]").prop("checked", false);
    $.post("procesar.php", {mostrar:"si"}, function(data){
      $("#resultados").html(data);
    });
  });

  // Enviar formulario
  $("#formulario").submit(function(e){
    e.preventDefault();
    $.ajax({
      url: "procesar.php",
      type: "POST",
      data: $(this).serialize(),
      success: function(data){
        $("#resultados").html(data);
        $("#preguntas input[type=radio]").prop("checked", false);
      }
    });
  });
});
</script>

</body>
</html>

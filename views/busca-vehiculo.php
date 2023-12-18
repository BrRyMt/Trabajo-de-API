<!doctype html>
<html lang="es">

<head>
  <title>Buscador de Vehiculos </title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
  <main class="container pt-3">

    <form class="container border pt-3 rounded-3" id="formBusqueda" action="_POST" autocomplete="off">

      <div class="mb-3  p-2 ">
        <label class="form-label"> <strong> Placa: </strong> </label>
        <input type="text" maxlength="7" id="placa" placeholder="Buscar placa">
        <button type="button" class="btn btn-primary" name="buscar" id="buscar">Buscar</button>
        
        <br><small id="status" class="text-primary"> No hay busquedas Activas</small>
      </div>

      <div class="mb-3">
        <label class="form-label">Marca:</label>
        <input type="text" class="form-control" id="marca">
      </div>

      <div class="mb-3">
        <label  class="form-label">Modelo:</label>
        <input type="text" class="form-control" id="modelo">
      </div>

      <div class="mb-3">
        <label class="form-label">Color:</label>
        <input type="text" class="form-control" id="color">
      </div>

      <div class="mb-3">
        <label class="form-label">Tipo Combustible:</label>
        <input type="text" class="form-control" id="tipocombustible">
      </div>

      <div class="mb-3">
        <label class="form-label">Peso:</label>
        <input type="text" class="form-control" id="peso">
      </div>

      <div class="mb-3">
        <label class="form-label">Año de Fabricacion:</label>
        <input type="text" class="form-control" id="afabricacion">
      </div>
    </form>
  </main>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      function $(id) { return document.querySelector(id) }

      function buscarPlaca() {
        const placa = $("#placa").value

        if (placa != "") {
          const parametros = new FormData()
          parametros.append("operacion", "search")
          parametros.append("placa", placa)

          $("#status").innerHTML="Cargando.....🛠"


          fetch(`../controllers/Vehiculo.controler.php`, {
            method: "POST",
            body: parametros
          })
            .then(respuesta => respuesta.json())
            .then(datos => {
              if (!datos) {
                $("#status").innerHTML="No encontrado >:("
                $("#formBusqueda").reset()
                $("#placa").focus()
              } else {
                $("#status").innerHTML="Vehiculo encontrado"
                $("#marca").value = datos.marca
                $("#modelo").value = datos.modelo
                $("#color").value = datos.color
                $("#tipocombustible").value = datos.tipocombustible
                $("#peso").value = datos.peso
                $("#afabricacion").value = datos.afabricacion
              }
            })
            .catch(e => {
              console.error(e);
            })

        }
      }

      $("#placa").addEventListener("keypress", (event) => {
        if (event.keyCode == 13) {
          buscarPlaca()

        }
      })
      $("#buscar").addEventListener("click", buscarPlaca)


    })
  </script>

</body>

</html>
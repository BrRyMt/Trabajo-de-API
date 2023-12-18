<!doctype html>
<html lang="es">

<head>
  <title>Buscador de Vehiculos </title>
  <!-- requiredd meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
  <main class="container pt-3">
    <div class="alert alert-info mt-3">
      <h5>Registro Vehiculos</h5>
      <span class="">complete la informacion solicitada</span>
    </div>

    <form action="" class="container border pt-3 rounded-3" id="formRegistro" autocomplete="off">
      <div class="mb-3">
        <label class="form-label fw-bold">Marca:</label>
        <select name="marca" id="marca" class="form-select" required>
          <option value="">Seleccione</option>

        </select>
      </div>

      <div class="mb-3">
        <label class="form-label fw-bold">Modelo:</label>
        <input type="text" class="form-control" id="modelo" required>
      </div>

      <div class="mb-3">
        <label class="form-label fw-bold">Color:</label>
        <input type="text" class="form-control" id="color" required>
      </div>

      <div class="mb-3">
        <label class="form-label fw-bold">Tipo Combustible:</label>
        <select name="tipocombustible" id="tipocombustible" require>
          <option value="">Seleccione</option>
          <option value="GSL">Gasolina</option>
          <option value="DSL">Diesel</option>
          <option value="GNV">GNV</option>
          <option value="GLP">GLP</option>
        </select>
      </div>

      <div class="row">
        <div class="mb-3 col-md-4 ">
          <label class="form-label fw-bold">Peso:</label>
          <input type="number" class="form-control text-end" id="peso" required>
        </div>

        <div class="mb-3 col-md-4 ">
          <label class="form-label fw-bold">Año de Fabricacion:</label>
          <input type="number" class="form-control text-end" id="afabricacion" required>
        </div>

        <div class="mb-3 col-md-4 ">
          <label class="form-label fw-bold">Placa:</label>
          <input type="text" class="form-control text-center" minlength="7" maxlength="7" id="placa" required>
        </div>
      </div>
      <!-- button.btn.btn-primary#guardar[type="button"]{Guardar} -->
      <div class="mb-3 text-end">
        <button class="btn btn-primary" id="guardar" type="submit">Guardar</button>
        <button class="btn btn-secondary" id="cancelar" type="reset">Cancelar</button>
      </div>

    </form>
  </main>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      function $(id) {
        return document.querySelector(id)
      }
      //Funcion auto-ejecutada que trae datos de marcas(backend)
      //y las agrega como <option> a la lista (select) marca 

      (function() {
        fetch(`../controllers/Marca.controller.php?operacion=listar`)
          .then(respuesta => respuesta.json())
          .then(datos => {
            console.log(datos);
            datos.forEach(element => {
              const tagOption = document.createElement("option");
              tagOption.value = element.idmarca
              tagOption.innerHTML = element.marca

              $("#marca").appendChild(tagOption)
            });

          })
          .catch(e => {
            console.error($e)
          })
      })();

      $("#formRegistro").addEventListener("submit", (event) => {
        //evitamos el envio por ACTION
        event.preventDefault();

        //Enviare por AJAX (fetch)
        if (confirm("¿Desea registrar este vehiculo?")) {

          const parametros = new FormData()

          parametros.append("operacion", "add")
          //IMPORTANTE
          parametros.append("idmarca", $("#marca").value)
          parametros.append("modelo", $("#modelo").value)
          parametros.append("color", $("#color").value)
          parametros.append("tipocombustible", $("#tipocombustible").value)
          parametros.append("peso", $("#peso").value)
          parametros.append("afabricacion", $("#afabricacion").value)
          parametros.append("placa", $("#placa").value)

          fetch(`../controllers/Vehiculo.controler.php`, {
              method: "POST",
              body: parametros
            })
            .then(respuesta => respuesta.json())
            .then(datos => {
              const idvehiculo = parseInt(datos.idvehiculo);
              if (datos.idvehiculo > 0) {
                $("#formRegistro").reset();
                alert(`Registro de vehiculo: ${datos.idvehiculo}`);
              }
            })
            .catch(e => {
              console.error(e);
            })

        }
      })

    })
  </script>

</body>

</html>
<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>

    <main class="container pt-3">
        <div class="alert alert-info mt-3">
            <h5>Busca Empleados por DNI</h5>
            <span class="">complete la informacion solicitada</span>
        </div>

        <form class="container border pt-3 rounded-3" id="formBusqueda" action="_POST" autocomplete="off">

            <div class="mb-3  p-2 ">
                <label class="form-label"> <strong> Numero de DNI: </strong> </label>
                <input type="text" maxlength="8" id="nrodocumento" placeholder="Buscar numero de DNI">
                <button type="button" class="btn btn-primary" name="buscar" id="buscar">Buscar</button>
                <a href="./listar-empleados.php" class="btn btn-secondary">Cancelar</a>
                <br><small id="status" class="text-primary"> No hay busquedas Activas</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Nombres:</label>
                <input type="text" class="form-control" id="nombres" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Sede:</label>
                <input type="text" class="form-control" id="idsede" readonly>
            </div>


            <div class="mb-3">
                <label class="form-label">Fecha de nacimiento:</label>
                <input type="text" class="form-control" id="fechanac" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Telefono:</label>
                <input type="text" class="form-control" id="telefono" readonly>
            </div>

        </form>

    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            function $(id) {
                return document.querySelector(id);
            }

            function BuscarEmpleado() {
                const nrodocumento = $("#nrodocumento").value;

                const parametros = new FormData();
                parametros.append("operacion", "searchEmp")
                parametros.append("nrodocumento", nrodocumento)

                $("#status").innerHTML = "Cargando.....🛠";

                fetch(`../controllers/Empleado.controller.php`, {
                        method: "POST",
                        body: parametros
                    })
                    .then(respuesta => respuesta.json())
                    .then(datos => {
                        if (!datos) {
                            
                            $("#formBusqueda").reset()
                            $("#nrodocumento").focus()
                        } else {
                            $("#status").innerHTML = "Empleado encontrado"
                            $("#nombres").value = datos.nombres
                            $("#apellidos").value = datos.apellidos
                            $("#idsede").value = datos.n_sede
                            $("#fechanac").value = datos.fechanac
                            $("#telefono").value = datos.telefono
                        }
                    })
                    .catch(e => {
                        console.error(e);
                    })
            }

            $("#nrodocumento").addEventListener("keypress", (event) => {
                if (event.keyCode == 13) {
                    BuscarEmpleado()

                }
            })
            $("#buscar").addEventListener("click", BuscarEmpleado)
        })
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>
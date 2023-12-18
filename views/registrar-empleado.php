<!doctype html>
<html lang="en">

<head>
    <title>Registrar Empleado</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <main>
        <form action="" id="FormRegistroEmpleados">
            <div class="container border mt-3">
                <div class="alert alert-info mt-3">
                    <h5>Registro de Empleados</h5>
                    <span class="">complete la informacion solicitada</span>
                </div>
                <div class="mb-3">
                    <label  class="form-label">Sedes</label>
                    <select name="idsede" id="idsede" class="form-select">
                        <option value="">Seleccionar</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Apellidos:</label>
                    <input id="apellidos" name="apellidos" class="form-control" type="text">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nombres:</label>
                    <input id="nombres" name="nombres" class="form-control" type="text">
                </div>
                <div class="mb-3">
                    <label class="form-label">Documento de Identificacion (DNI)</label>
                    <input id="nrodocumento" name="nrodocumento" class="form-control" type="text">
                </div>
                <div class="mb-3">
                    <label class="form-label"> Fecha de Nacimiento</label>
                    <input id="fechanac" name="fechanac" class="form-control" type="text">
                </div>
                <div class="mb-3">
                    <label class="form-label">Telefono</label>
                    <input id="telefono" name="telefono" class="form-control" type="text">
                </div>
                <div class="div mb-3 text-end">
                    <button type="submit" class="btn btn-primary   "> Registrar</button>
                    <a href="./listar-empleados.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
        </form>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            function $(id) {
                return document.querySelector(id)
            }


            (function() {
                fetch("../controllers/Sede.controller.php?Solicitud=listar")
                    .then(respuesta => respuesta.json())
                    .then(datos => {
                        console.log(datos);
                        datos.forEach(element => {
                            const tagOption = document.createElement("option");
                            tagOption.value = element.idsede
                            tagOption.innerHTML = element.n_sede

                            $("#idsede").appendChild(tagOption)
                        });

                    })
                    .catch(e => {
                        console.error(e);
                    })
            })();

            $("#FormRegistroEmpleados").addEventListener("submit", (event) => {
                event.preventDefault();

                if (confirm("¿Desea registrar a este empleado?")) {

                    const parametros = new FormData()

                    parametros.append("operacion", "Registrar")

                    parametros.append("idsede", $("#idsede").value)
                    parametros.append("apellidos", $("#apellidos").value)
                    parametros.append("nombres", $("#nombres").value)
                    parametros.append("nrodocumento", $("#nrodocumento").value)
                    parametros.append("fechanac", $("#fechanac").value)
                    parametros.append("telefono", $("#telefono").value)

                    fetch(`../controllers/Empleado.controller.php`, {
                            method: "POST",
                            body: parametros
                        })
                        .then(respuesta => respuesta.json())
                        .then(datos => {

                            const idempleado = parseInt(datos.idempleado);
                            if (datos.idempleado > 0) {
                                $("#FormRegistroEmpleados").reset();
                                alert(`Registro de Empleado: ${datos.idempleado}`);
                            }
                        })
                        .catch(e => {
                            console.error(e);
                        })
                }
            });

        })
    </script>
</body>

</html>
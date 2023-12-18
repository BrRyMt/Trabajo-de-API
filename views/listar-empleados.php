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

        <form class="container border pt-3 rounded-3" id="formBusqueda" action="_POST" autocomplete="off">
        <a href="busca-empleado.php" class="btn btn-primary">Buscar</a>
            <a href="registrar-empleado.php" class="btn btn-primary">Registrar</a>

            <div style="max-height: 400px; overflow-y: auto;">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <!-- <th>Id</th> -->
                            <th>Sede</th>
                            <th>Apellidos</th>
                            <th>Nombres</th>
                            <th>Documentos</th>
                            <th>Fecha Nacimiento</th>
                            <th>Telefono</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">

                    </tbody>
                </table>
            </div>


        </form>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            function $(id) {
                return document.querySelector(id);
            }

            (function() {
                const tbody = $("tbody");

                const parametros = new FormData();

                parametros.append("operacion", "getAll")

                fetch("../controllers/Empleado.controller.php", {
                        method: "POST",
                        body: parametros
                    })
                    .then(respuesta => respuesta.json())
                    .then(datos => {
                        datos.forEach(element => {
                            const tr = document.createElement("tr");

                            /*const td_idemp = document.createElement("td");
                            td_idemp.textContent = element.idempleado;
                            tr.appendChild(td_idemp);
                            */
                            const td_sede = document.createElement("td");
                            td_sede.textContent = element.n_sede;
                            tr.appendChild(td_sede);

                            const td_apellido = document.createElement("td");
                            td_apellido.textContent = element.apellidos;
                            tr.appendChild(td_apellido);

                            const td_nombre = document.createElement("td");
                            td_nombre.textContent = element.nombres;
                            tr.appendChild(td_nombre);

                            const td_nrodocumento = document.createElement("td");
                            td_nrodocumento.textContent = element.nrodocumento;
                            tr.appendChild(td_nrodocumento);

                            const td_fechanac = document.createElement("td");
                            td_fechanac.textContent = element.fechanac;
                            tr.appendChild(td_fechanac);

                            const td_telefono = document.createElement("td");
                            td_telefono.textContent = element.telefono;
                            tr.appendChild(td_telefono);

                            tbody.appendChild(tr);
                        });
                    })
                    .catch(e => {
                        console.error(e);
                    });
            })();

        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>
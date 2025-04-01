<?php
include("header.php");
include("navbar.php");
#conexion de db
include 'model/conexion.php';
#select
$sentencia = $db->query("SELECT * FROM reservas;");
$dato = $sentencia->fetchAll(PDO::FETCH_OBJ);
#print_r ($dato);
?>

<div class="container"><!--Comienza Container-->
<br><br>
    <div class="row"><!--Comienza Row-->

            <div class="container">
                
                <div class="text-center">
                    <h3>Lista de registros</h3>
                    <a href="./inicio.php" class="btn btn-success"><i class="fas fa-home"></i> Regresar al inicio</a>
        <br></br>
                   

    
                </div><br>

                <table class="table table-striped" id="tablaReservas">
                    <thead>
                        <tr>
                            <th>NOMBRE</th>
                            <th>APELLIDOS</th>
                            <th>TELEFONO</th>
                            <th>SERVICIO</th>
                            <th>FECHA</th>
                            <th>HORA</th>
                            <th>HORAFIN</th>
                            <th>PELUQUERA</th>
                            <th>MENSAJE</th>
                            <th>ESTADO</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dato as $registro) { ?>
                            <tr>
                                <td> <?php echo $registro->Nombre; ?> </td>
                                <td> <?php echo $registro->Apellidos; ?> </td>
                                <td> <?php echo $registro->Telefono; ?> </td>
                                <td> <?php echo $registro->Servicio; ?> </td>
                                <td> <?php echo $registro->Fecha; ?> </td>
                                <td> <?php echo $registro->Hora; ?> </td>
                                <td> <?php echo $registro->HoraFin; ?> </td>
                                <td> <?php echo $registro->Peluquera; ?> </td>
                                <td> <?php echo $registro->MensajeAdicional; ?> </td>
                                <td>
                                    <?php
                                    $estado = $registro->Estado;
                                    $clase_color = '';

                                    switch ($estado) {
                                        case 'Pendiente Fianza':
                                            $clase_color = 'text-warning'; // Amarillo para Pendiente
                                            break;
                                        case 'Cancelado':
                                            $clase_color = 'text-danger'; // Rojo para Cancelado
                                            break;
                                        case 'Confirmado Fianza':
                                            $clase_color = 'text-success'; // Verde para Confirmado
                                            break;
                                        default:
                                            $clase_color = ''; // Sin clase de color por defecto
                                            break;
                                    }
                                    ?>

                                    <b class="<?php echo $clase_color; ?>"><?php echo $estado; ?></b>
                                </td>
                                <td>
                                    <div class="d-flex">
    
                                    <a href="update/form_update.php?id=<?php echo $registro->ID;?>" class="btn btn-sm btn-info mr-1">Editar</a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>


    </div><!--Finaliza Row-->

</div><!--Finaliza Container-->



                 
<?php 
include("modal_eliminar.php");
include("../footer.php");
?>

<script> 
$('#confirmDelete').on('show.bs.modal', function (event) { var button = $(event.relatedTarget);  //Botón que activó el modal 
var id = button.data('id'); 
// Extrae el ID del atributo data-id var modal = 
$(this); modal.find('.btn-danger').attr('href', '../admin/delete/delete.php?id=' + id); }); </script>


<script>
// Tabla de reservas (admin/mod_reservas.php)
$(document).ready(function() {
    $('#tablaReservas').DataTable({
        "scrollX": true, // Habilita el desplazamiento horizontal
        "scrollCollapse": true, // Hace que el encabezado y el pie de página se ajusten al desplazamiento
    
    });
});

</script> 
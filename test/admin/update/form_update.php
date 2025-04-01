<?php
include("../header.php");
include("../navbar.php");
include("../model/conexion.php");

#validar que no viajen datos vacios
if (!isset($_GET['id'])) {
    header('Location: http://localhost/citas/admin/error.php');
}
#conexion db
include '../model/conexion.php';
#select sql
$id = $_GET['id'];
$sentencia = $db->prepare("SELECT * FROM reservas WHERE id=?");
$resultado = $sentencia->execute([$id]);
$persona = $sentencia->fetch(PDO::FETCH_OBJ);
#prueva
#print_r($persona);
?>

<div class="container"><!-- Comienza Container -->
    <br><br>
    <div class="md-5"><!-- Comienza Row -->
        <form action="update.php" method="post" class="form-group">
            <h2>Actualiza el registro</h2>
            <p class="text-primary"><b>Ingresa los datos correspondientes:</b></p>

            <!-- Campo oculto para enviar el ID -->
            <input type="hidden" name="id2" value="<?php echo $persona->ID; ?>">

            <div class="form-row">
                <label for="nombre" class="col-form-label">Nombre:</label>
                <input type="text" name="nombre" class="form-control" value="<?php echo ($persona->Nombre); ?>">
            </div>

            <div class="form-row">
                <label for="apellidos" class="col-form-label">Apellidos:</label>
                <input type="text" name="apellidos" class="form-control" value="<?php echo ($persona->Apellidos); ?>">
            </div>

            <div class="form-row">
                <label for="telefono" class="col-form-label">Teléfono:</label>
                <input type="tel" name="telefono" class="form-control" value="<?php echo ($persona->Telefono); ?>">
            </div>

            <div class="form-row">
    <label for="servicio" class="col-form-label">Servicio:</label>
    <select name="servicio" class="form-control">
        <option value="<?php echo $persona->Servicio; ?>" selected><?php echo $persona->Servicio; ?></option>
        <option value="">Selecciona un servicio</option>
        <option <option value="mechas">Mechas</option>
    <option value="alisado">Alisado</option>
    <option value="color">Color</option>
    <option value="color+peinar">Color + Peinar</option>
    <option value="color+peinar+cortar">Color + Peinar + Cortar</option>
    <option value="matizar">Matizar</option>
    <option value="matizar+peinar">Matizar + Peinar</option>
    <option value="matizar+peinar+cortar">Matizar + Peinar + Cortar</option>
    <option value="contouring">Contouring</option>
    <option value="cortar">Cortar</option>
    <option value="peinar">Peinar</option>
    <option value="tratamiento">Tratamiento</option>
    <option value="botulinica">Botulinica</option>
    <option value="botulinica extra">Botulinica Extra</option>
    <option value="cejas">Cejas</option>
    </select>
</div>

            <div class="form-row">
                <label for="fecha" class="col-form-label">Fecha:</label>
                <input type="date" name="fecha" class="form-control" value="<?php echo $persona->Fecha; ?>">
            </div>

            <div class="form-row">
                <label for="hora" class="col-form-label">Hora:</label>
                <input type="time" name="hora" class="form-control" value="<?php echo ($persona->Hora); ?>">
            </div>

            <div class="form-row">
                <label for="mensaje" class="col-form-label">Mensaje:</label>
                <input type="text" name="mensaje" class="form-control" value="<?php echo ($persona->MensajeAdicional); ?>">
            </div>

            <!-- Campo para seleccionar Peluquera -->
            <div class="form-group">
                <label for="peluquera" class="col-form-label">Profesional:</label>
                <select name="peluquera" class="form-control" required>
                    <option value="<?php echo $persona->Peluquera; ?>"><?php echo $persona->Peluquera; ?></option>
                    <option value="" disabled>Selecciona una peluquera</option>
                    <option value="Judith">Judith</option>
                    <option value="Grissel">Grissel</option>
                    <!-- Agrega más opciones si tienes más peluqueras -->
                </select>
            </div>

            <div class="form-group">
    <label for="estado">Estado de la cita:</label>
    <select class="form-control" id="estado" name="estado">
        <option value="" <?php if ($persona->Estado == "") echo "selected"; ?>>Selecciona un estado</option>
        <option value="Confirmada fianza" <?php if ($persona->Estado == "Confirmada fianza") echo "selected"; ?>>Confirmada fianza</option>
        <option value="Pendiente de fianza" <?php if ($persona->Estado == "Pendiente de fianza") echo "selected"; ?>>Pendiente de fianza</option>
        <option value="No necesita fianza" <?php if ($persona->Estado == "No necesita fianza") echo "selected"; ?>>No necesita fianza</option>
        <option value="Promo" <?php if ($persona->Estado == "Promo") echo "selected"; ?>>Promo</option>
    </select>
</div>

            <br>

            <div class="form-group">
                <a href="../inicio.php" class="btn btn-warning">Cancelar</a>
                <a href="../delete/delete.php?id=<?php echo ($persona->ID); ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?')">Eliminar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
        </form>
    </div><!-- Finaliza Row -->
</div><!-- Finaliza Container -->

<?php include("../../footer.php"); ?>

<!-- Modal de Confirmación de Eliminación -->
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteLabel">Confirmar Eliminación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Está seguro de que desea eliminar este registro?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <a href="../admin/delete/delete.php?id=<?php echo $registro->ID;?>" class="btn btn-danger">Eliminar</a>
      </div>
    </div>
  </div>
</div>
<script>
  $('#confirmDelete').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Botón que activó el modal
    var id = button.data('id'); // Obtiene el ID del usuario desde el atributo data-id
    var modal = $(this);
    modal.find('#delete-btn').attr('href', '../admin/delete/delete.php?id=' + id);
  });
</script>
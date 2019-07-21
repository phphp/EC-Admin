<!-- 删除提示框 -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">是否继续执行删除？</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        对于使用软删除的数据，只会标记为删除。
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary mr-auto" data-dismiss="modal">取消</button>
        <form action="" method="post">
            <input type="hidden" name="_method" value="DELETE">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-danger">删除</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
$('#deleteModal').on('show.bs.modal', function (event) {
  let button = $(event.relatedTarget); // Button that triggered the modal
  let url = button.data('url'); // Extract info from data-* attributes
  let modal = $(this);
  modal.find('form').attr('action', url);
})
</script>

document.addEventListener("DOMContentLoaded", function() {
  var mask = document.querySelector('.mask');
  document.getElementById('toggleAddForm').addEventListener('click', function() {
    var form = document.getElementById('addForm');
    mask.style.display = 'block';
    form.style.display = 'block';
  });

  document.getElementById('toggleDeleteForm').addEventListener('click', function() {
    var form = document.getElementById('deleteForm');
    mask.style.display = 'block';
    form.style.display = 'block';

  });

  // 关闭表单

});

function closeForm() {
  var addForm = document.getElementById('addForm');
  var deleteForm = document.getElementById('deleteForm');
  var mask = document.querySelector('.mask');
  if (addForm.style.display === 'block' || deleteForm.style.display === 'block') {
    addForm.style.display = deleteForm.style.display = 'none';
    mask.style.display = 'none';
  }
}

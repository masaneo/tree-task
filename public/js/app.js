$('.alert-custom').delay(3000).fadeOut(300);

var newParentDiv = document.getElementById('select-new-parent');
newParentDiv.style.display = 'none';

$('#moveChildrens').change(function() {
    if($(this).is(":checked")) {
        newParentDiv.style.display = 'block';
       return;
    }
    newParentDiv.style.display = 'none';
 });
  
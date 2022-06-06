import './bootstrap';
$('.alert-custom').delay(2000).fadeOut(300);

var newParentDiv = document.getElementById('select-new-parent');
newParentDiv.style.display = 'none';

$('#move-children').change(function() {
    if($(this).is(":checked")) {
        newParentDiv.style.display = 'block';
       return;
    }
    newParentDiv.style.display = 'none';
 });

 const collapse = document.getElementsByClassName('collapse-button');

 for(let i = 0; i < collapse.length; i++){
     collapse[i].addEventListener("click", function(){
        this.classList.toggle("activeColl");
        let content = this.parentNode.parentNode.children;
        for(let j = 0; j < content.length; j++){
            if(content[j].style.display === 'block'){
                content[j].style.display = '';
            } else{
                content[j].style.display = 'block';
            }
        }
        
        if(this.textContent === '+'){
            this.textContent = '-';
        } else{
            this.textContent = '+';
        }

     });
 }

 const collapseDivs = document.getElementsByClassName('collapse');

 for(let i = 0; i < collapseDivs.length; i++){
     let content = collapseDivs[i].children;
     if(content.length === 1){
         content.item(0).children[0].style.display = 'none';
     }
 }
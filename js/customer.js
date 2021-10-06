function searchProductValidation(){
    let lineNumber=document.querySelector('input[name="line_number"]').value;
    if(!lineNumber){
        alert('Vui lòng điền số dòng');
        return false;
    }
}

function btnPreventDefault(){
    let btn_count = document.getElementsByClassName("btn_no_default");
    for(let i =0;i<btn_count.length;i++){
        btn_count[i].addEventListener("click", function(event){      
            event.preventDefault()
        });
    }
}


btnPreventDefault();

document.getElementById('filter_form').onsubmit = function(e) {
    return searchProductValidation();
};
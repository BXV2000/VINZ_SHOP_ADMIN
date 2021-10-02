function searchProductValidation(){
    let lineNumber=document.querySelector('input[name="line_number"]').value;
    if(!lineNumber){
        alert('Vui lòng điền số dòng');
        return false;
    }
}

function addProductValidation(){
    let tenHH=document.querySelector('input[name="TenHH"]').value;
    let gia=document.querySelector('input[name="Gia"]').value;
    let soLuong=document.querySelector('input[name="SoLuongHang"]').value;
    let maLoaiHang=document.getElementById('select_category').value;
    let quyCach=document.querySelector('textarea[name="QuyCach"]').value;
    let tenHinh=document.querySelector('input[name="TenHinh"]').value;
    let error="";
    console.log(tenHH)
    if(tenHH.length<=0){
        error="Vui lòng điền tên hàng hóa";
    }
    if(gia.length<=0){
        error="Vui lòng điền giá hàng hóa";
    }
    if(soLuong.length<=0){
        error="Vui lòng điền số lượng hàng hóa";
    }
    if(maLoaiHang==='0'){
        error="Vui lòng chọn danh mục hàng hóa";
    }
    if(quyCach.length<=0){
        error="Vui lòng điền quy cách hàng hóa";
    }
    if(tenHinh.length<=0){
        error="Vui lòng chọn ảnh hàng hóa";
    }

    if(error!=""){
        alert(error);
        return false;
    }
}



function addProductValidation(){
    let tenLoaiHang=document.querySelector('input[name="ThemTenLoaiHang"]').value;
    if(!tenLoaiHang){
        alert('Vui lòng điền danh mục');
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


function editButtonClick(){
    let editButtons=document.getElementsByClassName('edit_btn');
    let orderHiddenId=document.getElementsByClassName('order_hidden_id');
    let orderEmp = document.getElementsByClassName('order_hidden_emp');
    let orderState = document.getElementsByClassName('order_hidden_state');
    for(let i=0;i<editButtons.length;i++){
            editButtons[i].addEventListener("click", function(event){
            document.getElementById("edit_form_wrapper").classList.remove("hide");
            document.getElementById("edit_hidden_id").value=orderHiddenId[i].value;
            document.getElementById("SoDonDH_edit").value=orderHiddenId[i].value;
            document.getElementById("order_state").value=orderState[i].value;
            document.getElementById("edit_emp").value= orderEmp[i].value;
        });
    }
}
editButtonClick();
document.getElementById("edit_cancel").addEventListener("click", function(event){
    document.getElementById("edit_form_wrapper").classList.add("hide");
});


document.getElementById('filter_form').onsubmit = function(e) {
    return searchProductValidation();
};


btnPreventDefault();

function setOrderState(){
    let orderStates = document.getElementsByClassName("order_hidden_state");
    let editOrderStates = document.getElementsByClassName("order_state");
    for(let i =0;i<orderStates.length;i++){
        if(orderStates[i].value=="1"){
            editOrderStates[i].innerHTML="Đang chờ xử lí";
        }
        if(orderStates[i].value=="2"){
            editOrderStates[i].innerHTML="Đã giao";
        }
        if(orderStates[i].value=="3"){
            editOrderStates[i].innerHTML="Đã hủy";
        }
    }
}
setOrderState();

document.getElementById('edit_form').onsubmit = function() {
    return confirm(`Bạn có muốn cập nhật đơn hàng ${document.getElementById('edit_hidden_id').value} ?`);
};
function searchProductValidation(){
    let lineNumber=document.querySelector('input[name="line_number"]').value;
    if(!lineNumber){
        alert('Vui lòng điền mã nhân viên');
        return false;
    }
}

function addStaffValidation(){
    let hoTenNV=document.querySelector('input[name="HoTenNV"]').value;
    let soDienThoai=document.querySelector('input[name="SoDienThoai"]').value;
    let chucVu=document.getElementById('select_staff_grade').value;
    let diaChi=document.querySelector('textarea[name="DiaChi"]').value;
    let error="";
    if(hoTenNV.length<=0){
        error="Vui lòng điền tên nhân viên";
    }
    if(soDienThoai.length<=0){
        error="Vui lòng điền số điện thoại";
    }
    if(chucVu==='0'){
        error="Vui lòng chọn chức vụ";
    }
    if(diaChi.length<=0){
        error="Vui lòng điền địa chỉ";
    }
    if(error!=""){
        alert(error);
        return false;
    }
}

function editStaffValidation(){
    let hoTenNV=document.querySelector('input[name="HoTenNV_edit"]').value;
    let soDienThoai=document.querySelector('input[name="SoDienThoai_edit"]').value;
    let chucVu=document.querySelector('select[name="ChucVu_edit"]').value;
    let diaChi=document.querySelector('textarea[name="DiaChi_edit"]').value;
    let error="";
    
    if(hoTenNV.length<=0){
        error="Vui lòng điền tên nhân viên";
    }
    if(soDienThoai.length<=0){
        error="Vui lòng điền số điện thoại";
    }
    if(chucVu==='0'){
        error="Vui lòng chọn chức vụ";
    }
    if(diaChi.length<=0){
        error="Vui lòng điền địa chỉ";
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

document.getElementById("add_product").addEventListener("click", function(event){
    document.getElementById("add_new_form_wrapper").classList.remove("hide");
});



function editButtonClick(){
    let editButtons=document.getElementsByClassName('edit_btn');
    let staffHiddenId=document.getElementsByClassName('staff_hidden_id');
    let staffName = document.getElementsByClassName('staff_name');
    let staffGrade = document.getElementsByClassName('staff_grade');
    let staffAddress = document.getElementsByClassName('staff_address');
    let staffPhone = document.getElementsByClassName('staff_phone');
    
    for(let i=0;i<editButtons.length;i++){
        editButtons[i].addEventListener("click", function(event){
            document.getElementById("edit_form_wrapper").classList.remove("hide");
            document.getElementById("edit_hidden_id").value=staffHiddenId[i].value;
            document.getElementById("edit_hidden_name").value=staffName[i].innerHTML;
            document.getElementById("HoTenNV_edit").value=staffName[i].innerHTML;
            document.getElementById("SoDienThoai_edit").value=parseInt(staffPhone[i].innerHTML);
            document.getElementById("ChucVu_edit").value=staffGrade[i].innerHTML;
            document.getElementById("DiaChi_edit").value=staffAddress[i].innerHTML;
        });
    }
  
}
editButtonClick();

document.getElementById("add_new_cancel").addEventListener("click", function(event){
    document.getElementById("add_new_form_wrapper").classList.add("hide");
    document.getElementById("add_new_form").reset();
});

document.getElementById("edit_cancel").addEventListener("click", function(event){
    document.getElementById("edit_form_wrapper").classList.add("hide");
});

document.getElementById('add_new_form').onsubmit = function(e) {
    if(confirm('Bạn có muốn thêm nhân viên?'))
        return addStaffValidation();
    else e.preventDefault();
};



document.getElementById('edit_form').onsubmit = function(e) {
    if(confirm(`Bạn có muốn cập nhật thông tin của ${document.getElementById('edit_hidden_name').value} ?`))
        return editStaffValidation();
    else e.preventDefault();
};

btnPreventDefault();
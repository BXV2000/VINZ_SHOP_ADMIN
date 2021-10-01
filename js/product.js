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

function editProductValidation(){
    let tenHH=document.querySelector('input[name="TenHH_edit"]').value;
    let gia=document.querySelector('input[name="Gia_edit"]').value;
    let soLuong=document.querySelector('input[name="SoLuongHang_edit"]').value;
    let maLoaiHang=document.getElementById('select_edit_category').value;
    let quyCach=document.querySelector('textarea[name="QuyCach_edit"]').value;
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

document.getElementById("add_category").addEventListener("click", function(event){
    document.getElementById("add_new_category_wrapper").classList.remove("hide");
});

function editButtonClick(){
    let editButtons=document.getElementsByClassName('edit_btn');
    let productHiddenId=document.getElementsByClassName('product_hidden_id');
    let productName = document.getElementsByClassName('product_name');
    let productPrice = document.getElementsByClassName('product_price');
    let productStock = document.getElementsByClassName('product_stock');
    let productCategory = document.getElementsByClassName('product_category');
    let productNote = document.getElementsByClassName('product_note');
    for(let i=0;i<editButtons.length;i++){
        editButtons[i].addEventListener("click", function(event){
            document.getElementById("edit_form_wrapper").classList.remove("hide");
            document.getElementById("edit_hidden_id").value=productHiddenId[i].value;
            document.getElementById("edit_hidden_name").value=productName[i].innerHTML;
            document.getElementById("TenHH_edit").value=productName[i].innerHTML;
            document.getElementById("Gia_edit").value=parseInt(productPrice[i].innerHTML);
            document.getElementById("SoLuongHang_edit").value=parseInt(productStock[i].innerHTML);
            document.getElementById("select_edit_category").value=productCategory[i].value;
            document.getElementById("QuyCach_edit").value=productNote[i].innerHTML;
        });
    }
}
editButtonClick();

document.getElementById("add_new_cancel").addEventListener("click", function(event){
    document.getElementById("add_new_form_wrapper").classList.add("hide");
    document.getElementById("add_new_form").reset();
});

document.getElementById("add_new_category_cancel").addEventListener("click", function(event){
    document.getElementById("add_new_category_wrapper").classList.add("hide");
    document.getElementById("add_new_category_form").reset();
});

document.getElementById("edit_cancel").addEventListener("click", function(event){
    document.getElementById("edit_form_wrapper").classList.add("hide");
});

document.getElementById('add_new_form').onsubmit = function(e) {
    if(confirm('Bạn có muốn thêm hàng hóa?'))
        return addProductValidation();
    else e.preventDefault();
};
document.getElementById('filter_form').onsubmit = function(e) {
    return searchProductValidation();
};

document.getElementById('add_new_category_form').onsubmit = function(e) {
    if(confirm('Bạn có muốn thêm danh mục?'))
        return addProductValidation();
    else e.preventDefault();
};

document.getElementById('edit_form').onsubmit = function(e) {
    if(confirm(`Bạn có muốn sửa ${document.getElementById('edit_hidden_name').value} ?`))
        return editProductValidation();
    else e.preventDefault();
};

btnPreventDefault();
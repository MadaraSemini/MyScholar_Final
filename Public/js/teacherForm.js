var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;





























class Request{
    constructor(name,password,email,grade,district){
        this.name=name;
        this.password=password;
        this.email=email;
        this.grade=grade;
        this.district=district;
    }

    set_file(image){
        this.image=image;
    }
}

const form =document.getElementById("rForm");


form.addEventListener("submit", (e)=>{
    e.preventDefault();
    const request=new Request(form.children[1].value,form.children[3].value,form.children[6].value,form.children[8].value,form.children[10].value);

    if(form.children[12].value!=null){
        request.set_file(form.children[12].value);
    }
    form.reset();
});

function validateForm() {
    var btn = document.forms["adForm"]["submit"].id;
    //var btn = document.forms["adForm"]["checkBoxCount"];
    var value = 0;
    var i;
    for(i = 1;i<=btn;i++){
        var y = document.getElementById(i).checked;
        if(y==true){
            value+=1;
        }
    }
    
    if (value==0){
        alert("You must select at least one checkbox");
        return false;
    }
}
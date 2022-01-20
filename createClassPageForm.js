class CreateClassForm{
    constructor(salutation,displayingName,subject,grade,medium,day,from,to,fee,){
        this.salutation = salutation;
        this.displayingName = displayingName;
        this.subject = subject;
        this.grade = grade;
        this.medium = medium;
        this.day = day;
        this.from = from;
        this.to = to;
        this.fee = fee;
    }

    setCapacity(capacity){
        this.capacity = capacity;
    }

    setClassType(type){
        this.type = type;
    }

    setLocation(location){
        this.location = location;
    }

}

const form =document.getElementById("cpForm");

form.addEventListener("submit", (e)=> {
    e.preventDefault();

    const create_class_form = new CreateClassForm(form.children[1].value, form.children[2].value, form.children[4].value, form.children[6].value,
        form.children[8].value, form.children[10].value, form.children[12].value, form.children[14].value, form.children[16].value);

    if (form.children[18].value != null) {
        create_class_form.setCapacity(form.children[17].value);
    }

    if (form.children[20].value != null) {
        create_class_form.setClassType(form.children[19].value);
    }

    if (form.children[22].value != null) {
        create_class_form.setLocation(form.children[21].value);
    }

    form.reset();
});
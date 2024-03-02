var formfield = document.getElementById('formfield');
var counter = 1;

//Funcion para agregar campos
function add(){
    var newField = document.createElement('input');
    newField.setAttribute('type','text');
    newField.setAttribute('name','text_' + counter); // Asignar nombres únicos
    newField.setAttribute('class','text');
    newField.setAttribute('size',50); // Corregido el atributo 'siz' a 'size'
    newField.setAttribute('placeholder','Optional Field');
    formfield.appendChild(newField);
    counter++; // Incrementar el contador
}

//Funcion para remover campos
function remove(){
    var input_tags = formfield.getElementsByTagName('input');
    if(input_tags.length > 3) { // Asegurarse de que siempre haya al menos 3 campos
        formfield.removeChild(input_tags[(input_tags.length) - 1]);
        counter--; // Decrementar el contador
    }
}

var bootstrapScript = document.createElement('script');
bootstrapScript.src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js';
document.head.appendChild(bootstrapScript);

// Crear un elemento <link> para importar Bootstrap 5 CSS
var bootstrapLink = document.createElement('link');
bootstrapLink.rel = 'stylesheet';
bootstrapLink.href = 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css';
bootstrapLink.integrity = 'sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC';
bootstrapLink.crossOrigin = 'anonymous';

// Agregar el elemento <link> al encabezado (<head>) del documento HTML
document.head.appendChild(bootstrapLink);

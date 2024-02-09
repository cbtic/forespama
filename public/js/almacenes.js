var departamento_select = document.getElementById("Id_departamento");
var provincia_select = document.getElementById("Id_provincia");
var distrito_select = document.getElementById("Id_distrito");
var ubigeo_input = document.getElementById("Id_ubigeo");

var ubigeo = document.getElementById("Id_ubigeo").value;

departamento_select.addEventListener("change", function() {
    departamento = departamento_select.value;
    carga_Provincia(departamento);
});

provincia_select.addEventListener("change", function() {
    carga_Distrito();
});

distrito_select.addEventListener("change", function() {
    actualiza_ubigeo();
});

function carga_Provincia(departamento) {
    alert("Carga provincias de: " + departamento);
    html = "<option value=0>Seleccione</option>";
    obj = {
        "1": "Name",
        "2": "Age",
        "3": "Gender"
    }
    for (var key in obj) {
        html += "<option value=" + key + ">" + obj[key] + "</option>"
    }
    provincia_select.innerHTML = html;
}

function carga_Distrito() {
    alert("Carga distritos de: " + ubigeo.substr(2, 2));
}
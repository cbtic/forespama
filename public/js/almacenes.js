var departamento_select = document.getElementById("Id_departamento");
var provincia_select = document.getElementById("Id_provincia");
var distrito_select = document.getElementById("Id_distrito");
var ubigeo_input = document.getElementById("Id_ubigeo");

var ubigeo = document.getElementById("Id_ubigeo").value;

departamento_select.addEventListener("change", function() {
    departamento = departamento_select.value;
    carga_Provincia(departamento);

    setTimeout(() => {
        let defaultOption = document.createElement('option');
        defaultOption.text = 'Seleccione';
        distrito_select.add(defaultOption);
        distrito_select.selectedIndex = 1;
    }, 500)
});

provincia_select.addEventListener("change", function() {
    departamento = departamento_select.value;
    provincia = provincia_select.value;
    carga_Distrito(departamento, provincia);
});

distrito_select.addEventListener("change", function() {
    actualiza_ubigeo();
});

function carga_Provincia(departamento) {
    provincia_select.length = 0;
    distrito_select.length = 0;
    let defaultOption = document.createElement('option');
    defaultOption.text = 'Seleccione';
    provincia_select.add(defaultOption);
    provincia_select.selectedIndex = 0;

    let defaultOption2 = document.createElement('option');
    defaultOption.text = 'Seleccione';
    distrito_select.add(defaultOption2);
    distrito_select.selectedIndex = 0;

    const url = '/ubigeo/listar_provincias_ajax/' + departamento;
    fetch(url)
        .then(
            function(response) {
                if (response.status !== 200) {
                    console.warn('Error: ' +
                        response.status);
                    return;
                }

                response.json().then(function(data) {
                    let option;

                    for (let i = 0; i < data.provincias.length; i++) {
                        option = document.createElement('option');
                        option.text = data.provincias[i].denominacion;
                        option.value = data.provincias[i].id;
                        provincia_select.add(option);
                    }
                });
            }
        )
        .catch(function(err) {
            console.error('Fetch Error -', err);
        });
}

function carga_Distrito(departamento, provincia) {
    distrito_select.length = 0;
    let defaultOption = document.createElement('option');
    defaultOption.text = 'Seleccione';
    distrito_select.add(defaultOption);
    distrito_select.selectedIndex = 0;

    const url = '/ubigeo/listar_distritos_ajax/' + departamento + '/' + provincia;
    fetch(url)
        .then(
            function(response) {
                if (response.status !== 200) {
                    console.warn('Error: ' +
                        response.status);
                    return;
                }

                response.json().then(function(data) {
                    let option;

                    for (let i = 0; i < data.distritos.length; i++) {
                        option = document.createElement('option');
                        option.text = data.distritos[i].denominacion;
                        option.value = data.distritos[i].id;
                        distrito_select.add(option);
                    }
                });
            }
        )
        .catch(function(err) {
            console.error('Fetch Error -', err);
        });
}

function actualiza_ubigeo() {
    ubigeo_input.value = departamento_select.value + provincia_select.value + distrito_select.value;
}

document.addEventListener("DOMContentLoaded", function() {
    departamento_value = ubigeo.substr(0, 2);
    provincia_value = ubigeo.substr(2, 2);
    distrito_value = ubigeo.substr(4, 2);

    carga_Provincia(departamento_value);
    carga_Distrito(departamento_value, provincia_value);

    departamento_select.value = departamento_value;
    setTimeout(() => {
        provincia_select.value = provincia_value;
        distrito_select.value = distrito_value;
    }, 500)
});

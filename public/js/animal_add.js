$(document).ready(function () {
    cargarGanado();
});


function cargarGanado() {
    $.ajax({
        url: `/types`,
        type: "GET"
    }).done(function (responseText) {
        $("#ganado option:gt(0)").remove(); //*lo vacío para que no se acumulen todas las opciones, excepto la primera
        for (let index in responseText) {
            $("#livestock").append(
                `<option value='${responseText[index]['id']}'>${responseText[indice]['tipo']}</option>`
            );
        }
    });
}

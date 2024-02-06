"use strict";

$(document).ready(function () {
    $(".edit").on("click",loadWorker);
});


function loadWorker() {
    $.ajax({
        url: `/users/edit/${$(this).attr("id")}`,
        type: "GET"
    }).done(function (responseText) {
        $("#livestock option:gt(0)").remove(); //*lo vacío para que no se acumulen todas las opciones, excepto la primera
        for (let index in responseText) {
            $(".form_edit").attr("action",`/users/update/${$(this).attr("id")}`);
        }
    });
}

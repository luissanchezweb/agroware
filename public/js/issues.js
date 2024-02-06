"use strict";
let show = "";
let idUser = "";
let nameUser;
$(document).ready(function () {
    $("#type").on("change", validateValue);
    $('.respuesta').hide();
    $('.issues').hide();
    createIssuesForm();
});

function validateValue() {
    if ($("#type").val() == "pending") {
        $('.portada').hide();
        $("#animales").on("click", loadAnimalPendingIssues);
        $("#maquinaria").on("click", loadMachinePendingIssues);
        $("#finca").on("click", loadFieldPendingIssues);
        $("#otros").on("click", loadOtherPendingIssues);
        $("#animales").off("click", loadAnimalClosedIssues);
        $("#maquinaria").off("click", loadMachineClosedIssues);
        $("#finca").off("click", loadFieldClosedIssues);
        $("#otros").off("click", loadOtherClosedIssues);
        loadAnimalPendingIssues();
    }else if($("#type").val() == "closed"){
        $('.portada').hide();
        $("#animales").on("click", loadAnimalClosedIssues);
        $("#maquinaria").on("click", loadMachineClosedIssues);
        $("#finca").on("click", loadFieldClosedIssues);
        $("#otros").on("click", loadOtherClosedIssues);
        $("#animales").off("click", loadAnimalPendingIssues);
        $("#maquinaria").off("click", loadMachinePendingIssues);
        $("#finca").off("click", loadFieldPendingIssues);
        $("#otros").off("click", loadOtherPendingIssues);
        loadAnimalClosedIssues();
    }else {
        $('.portada').show();
        $('.respuesta').hide();
        $('.issues').empty();
    }
}

function closeIssue(){
    $(this).parent().parent().parent().remove();
    $.ajax({
        type: "post",
        url: `/issue/close/${$(this).attr('id')}`,
        dataType: "json",
        success: function (response) {
            Toastify({
                text: `${response.message}`,
                duration: 2000,
                style: {
                    background: "green",
                  }
                }).showToast(); 

            if($('.issues').attr('data-type') == 'animals' && $('.issues').attr('data-status') == 'pending'){
                loadAnimalPendingIssues();
            }

            if($('.issues').attr('data-type') == 'machines' && $('.issues').attr('data-status') == 'pending'){
                loadMachinePendingIssues();
            }

            if($('.issues').attr('data-type') == 'field' && $('.issues').attr('data-status') == 'pending'){
                loadFieldPendingIssues();
            }

            if($('.issues').attr('data-type') == 'other' && $('.issues').attr('data-status') == 'pending'){
                loadOtherPendingIssues();
            }

        }
    });
}

function reportIssue() {
    $(".report-issue").on('submit', function(event){
        var url = $(this).attr('action');

        $.ajax({
            url: url,
            method: 'POST',
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success:function(response)
            {
                limpiarIssueForm();
                $('.report-issue').trigger('reset');
                $('.modal-issue').modal('toggle');

                Toastify({
                    text: `${response.message}`,
                    duration: 2000,
                    style: {
                        background: "green",
                      }
                    }).showToast();
                    
                //!VER, SOLO PUEDO CARGAR TODO EN CASO DE QUE ESTES FUERA, SI ESTOY DENTRO, SOLO RECARGO ESE, LO MISMO AL BORRAR
                if($('.issues').attr('data-type') == 'animals' && $('.issues').attr('data-status') == 'pending'){
                    loadAnimalPendingIssues();
                }

                if($('.issues').attr('data-type') == 'machines' && $('.issues').attr('data-status') == 'pending'){
                    loadMachinePendingIssues();
                }

                if($('.issues').attr('data-type') == 'field' && $('.issues').attr('data-status') == 'pending'){
                    loadFieldPendingIssues();
                }

                if($('.issues').attr('data-type') == 'other' && $('.issues').attr('data-status') == 'pending'){
                    loadOtherPendingIssues();
                }


            },
            error: function(response) {
                Toastify({
                    text: `${response.message}`,
                    duration: 2000,
                    style: {
                        background: "red",
                      }
                    }).showToast();
            }
        });
        event.preventDefault();
        event.stopImmediatePropagation();
    });

}


function checkEmptyContainer() {
    if($('.cont-issues').is(':empty')){
        $('.issues').empty();
        $('.issues').append('<p>Hola</p>');

    }
}


function createIssuesForm() {
    $(".report-issue").validate({
        errorElement: "em",
        errorPlacement: function (error, element) {
          error.addClass("help-block");
    
          if (element.prop("type") === "radio") {
            error.insertAfter(element.parent("div"));
          } else {
            error.insertAfter(element);
          }
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).addClass("is-valid").removeClass("is-invalid");
        },
        rules: {
          title: "required",
          description: "required",
          type: "required",
        },
        submitHandler: (form) => {
          reportIssue();
        },
      });
}

function limpiarIssueForm() {
    $('#title').removeClass("is-valid");
    $('#description').removeClass("is-valid");
    $('#type').removeClass("is-valid");
}
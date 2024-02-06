"use strict";
let id;
let status;

$(document).ready(function () {
    drag();
    $(".view").on("click", viewTask);
    createTaskForm();
});


function drag() {
    $(".drag").draggable({
        //hago que la imagen sea arrastrable
        revert: true
    });

    //hago que puedan soltarse objetos arrastrables en el div soltar
    $(".drop").droppable({
        drop: function (evento, ui) {
            //opción drop, evento que se activa cuando sueltas algo
            $(this).append($(ui.draggable));
            id = $(ui.draggable[0]).attr("data-id");
            status = $(this).attr('data-status');
            updateStatus();
        },
    });
}

function updateStatus() {
    $.ajax({
        type: "POST",
        url: `/tasks/update/${id}`,
        data: {
            'status': status
        },
        dataType: "json",
        success: function (response) {

        }
    });
}

function viewTask() {
    $.ajax({
        type: "GET",
        url: `/tasks/show/${$(this).attr('data-id')}`,
        dataType: "json",
        success: function (response) {
            $("#title-task").empty();
            $("#description-task").empty();
            $("#start-task").empty();
            $("#finish-task").empty();

            $(response).each(function (index, element) {
                $("#title-task").append(`${response.title}`);
                $("#description-task").append(`${response.description}<hr>`);
                $("#start-task").append(`La tarea comenzó el ${response.start}`);
                $("#finish-task").append(`La tarea debe terminar el ${response.finish}`);
            });
        }
    });
}


function deleteTask() {
    $(this).parent().parent().parent().hide();
    $.ajax({
        type: "POST",
        url: `/tasks/delete/${$(this).attr('data-id')}`,
        dataType: "json",
        success: function (response) {

        }
    });
}

function createTask() {
    $(".createTask").on('submit', function(event){
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
                $('.modal-task').modal('toggle');
                limpiarCreateTask();
                $('.createTask').trigger('reset');
                 location.reload();
                Toastify({
                    text: `Tarea asignada`,
                    duration: 2000,
                    style: {
                        background: "green",
                      }
                    }).showToast();
            }
        });
        event.preventDefault();
    });
}

function createTaskForm() {
    $(".createTask").validate({
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
        title:{
          required:true,
        }, 
        description: "required",
        user_id: "required",
        start_date: "required",
        finish_date: "required"
      },
      submitHandler: (form) => {
        createTask();
      },
    });
  }; 

function limpiarCreateTask(){
    $('#task-title').removeClass("is-valid");
    $('#description').removeClass("is-valid");
    $('#user_id').removeClass("is-valid");
    $('#start').removeClass("is-valid");
    $('#finish').removeClass("is-valid");
}
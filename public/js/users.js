"use strict";
let firstTime = true;
let table = "";
$(document).ready(function () {
  $.validator.addMethod("checkUsernameExists", function(value, element)
{
    var inputElem = $('.new-user :input[name="username"]');
    let validate = false;
    $.ajax(
    {
        type: "POST",
        url: `validateUsername/${inputElem.val()}`,
        dataType: "json",
        async: false,
        success: function(response)
        {
           validate = response.data;
        }    
    });
    return validate;
}, 'Ese usuario ya existe');

$.validator.addMethod("checkEmailExists", function(value, element)
{
    var inputElem = $('.new-user :input[name="email"]');
    let validate = false;
    $.ajax(
    {
        type: "POST",
        url: `validateEmail/${inputElem.val()}`,
        dataType: "json",
        async: false,
        success: function(response)
        {
           validate = response.data;
        }    
    });
    return validate;
}, 'Ese correo ya existe');

$.validator.addMethod("checkEditUsernameExists", function(value, element)
{
    var inputElem = $('.edit-user :input[name="usernameuser"]');
    let validate = false;
    $.ajax(
    {
        type: "POST",
        url: `validateEditUsername/${inputElem.val()}/${$('.edit-user').attr('data-id')}`,
        dataType: "json",
        async: false,
        success: function(response)
        {
           validate = response.data;
        }    
    });
    return validate;
}, 'Ese usuario ya existe');

$.validator.addMethod("checkEditEmailExists", function(value, element)
{
    var inputElem = $('.edit-user :input[name="emailuser"]');
    let validate = false;
    $.ajax(
    {
        type: "POST",
        url: `validateEditEmail/${inputElem.val()}/${$('.edit-user').attr('data-id')}`,
        dataType: "json",
        async: false,
        success: function(response)
        {
           validate = response.data;
        }    
    });
    return validate;
}, 'Ese correo ya existe');

    $('.update').hide();
    $('.delete').hide();
    confFormulario();
    confEditFormulario();
    loadUsers();
});

function loadUsers() {
    table = $('.table').DataTable({
        processing: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
        },
        select: true,
        responsive:true,
        bDestroy: true,
        pageLength : 5,
        bLengthChange:false,
        ajax: "getUsers",
        columns: [
            {data: 'id' , name : 'id'},
            {data: 'name' , name : 'Nombre'},
            {data: 'username' , name : 'Usuario'},
            {data: 'email' , name : 'Correo'},
            {data: 'rol' , name : 'Rol'},
        ],
        initComplete: function (settings, json) {//*cuando termina la tarea ejecuta esta función
            $('table tbody').on('click', 'tr', function () {
                if ($(this).hasClass('click')) {
                    $(this).removeClass('click');
                    $(this).css('backgroundColor','white');
                    $(this).css('color', 'black');
                    $('.update').hide();
                    $('.delete').hide();
                } else {
                    $('.click').css('backgroundColor','white');
                    $('.click').css('color', 'black');
                    table.$('tr.click').removeClass('click');
                    $(this).addClass('click');
                    $('.click').css('backgroundColor','rgb(133, 156, 114)');
                    $('.click').css('color', 'white');
                    $('.update').show();
                    $('.delete').show();
                }

                $('.update').attr('data-id', table.row('.click').data().id );
                $('.delete').attr('data-id', table.row('.click').data().id );
            });

            
            $(".update").on("click", loadUser);
            $(".delete").on("click", function (params) {
              Swal.fire({
                title: '¿Deseas eliminar este usuario?',
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: 'Eliminar',
                denyButtonText: `Cancelar`,
              }).then((result) => {
                if (result.isConfirmed) {
                    deleteUser();
                }
              })
            });
        },
    });
    
}

function createUser() {
    $(".new-user").on('submit', function(event){
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
                $('.new-user-modal').modal('toggle');
                limpiarNewUser();
                $('.update').hide();
                $('.delete').hide();
                $('.new-user').trigger('reset');
                $('modal').hide();
                table.ajax.reload();
                Toastify({
                    text: `${response.message}`,
                    duration: 2000,
                    style: {
                        background: "green",
                      }
                    }).showToast();
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

function loadUser() {
    $.ajax({
        type: "get",
        url: `getUser/${$(this).attr("data-id")}`,
        datatype: "json",
        success: function (response) {    
                $('.edit-user').attr("action", `users/update/${response.data['id']}`);
                $('#nameuser').val(`${response.data['name']}`);
                $('#usernameuser').val(`${response.data['username']}`);
                $('#emailuser').val(`${response.data['email']}`);
                $('.edit-user').attr("data-id", `${response.data['id']}`);
                if(response.data['rol'] == 'Trabajador'){
                    $('#user-trabajador').prop("checked",true);
                }else{
                    $('#user-gerente').prop("checked",true); 
                }     
        }
    });
}

function deleteUser() {
    $.ajax({
        type: "get",
        url: `/users/delete/${$('.delete').attr("data-id")}`,
        datatype: "json",
        success: function (response) {    
            $('.update').hide();
            $('.delete').hide();
            table.row('.selected').remove().draw(false);
            table.ajax.reload();
            Toastify({
                text: `${response.message}`,
                duration: 2000,
                style: {
                    background: "green",
                  }
                }).showToast();
        },
        error: function (response) {
            Toastify({
                text: `${response.message}`,
                duration: 2000,
                style: {
                    background: "red",
                  }
                }).showToast();
        }
    });
}

function updateUser() {
    $(".edit-user").on('submit', function(event){
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
                   limpiarEditUser();
                    $('.update').hide();
                    $('.delete').hide();
                    $('.edit-user').trigger('reset');
                    $('.edit-user-modal').modal('toggle');
                    $('modal').hide();
                    table.ajax.reload();

                    Toastify({
                        text: `${response.message}`,
                        duration: 2000,
                        style: {
                            background: "green",
                          }
                        }).showToast();
                
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


function confFormulario() {
    $(".new-user").validate({
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
        name:{
          required:true,
        }, 
        username: {
          checkUsernameExists: true,
          required: true,
          minlength: 5,
          maxlength:255
        },
        email: {
          checkEmailExists: true,
          required: true,
          email: true
        },
        password: {
          required:true,
          minlength: 7,
          maxlength: 255
        },       
        avatar: "required",
        role: "required"
      },
  
      messages: {
        name: "Requerido",
        username: {
          required: "Requerido",
          checkUsernameExists: "Ese usuario ya existe",
          minlength: "Caracteres insuficientes",
          maxlength: "Máximo de caracteres superado"
        },
        email: {
          required : "Requerido",
          email: "Correo inválido",
          checkEmailExists: "Ese correo ya existe",
        },
        password:{
          required: "Requerido",
          minlength: "Caracteres insuficientes",
          maxlength: "Máximo de caracteres superado"
        },
        avatar: "Requerido",
        role: "Requerido"
      },
      submitHandler: (form) => {
        createUser();
      },
    });
  };


  function confEditFormulario() {
    $(".edit-user").validate({
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
        nameuser:{
          required:true,
        }, 
        usernameuser: {
          checkEditUsernameExists: true,
          required: true,
          minlength: 5,
          maxlength:255
        },
        emailuser: {
          checkEditEmailExists: true,
          required: true,
          email: true
        },  
        avataruser: "required",
        userrole: "required"
      },
  
      messages: {
        nameuser: "Requerido",
        usernameuser: {
          required: "Requerido",
          checkEditUsernameExists: "Ese usuario ya existe",
          minlength: "Caracteres insuficientes",
          maxlength: "Máximo de caracteres superado"
        },
        emailuser: {
          required : "Requerido",
          email: "Correo inválido",
          checkEditEmailExists: "Ese correo ya existe",
        },
        avataruser: "Requerido",
        userrole: "Requerido"
      },
      submitHandler: (form) => {
        updateUser();
      },
    });
  };  

function limpiarNewUser() {
  $("#name").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
  $("#username").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
  $("#email").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
  $("#password").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
  $("#avatar").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
}

function limpiarEditUser() {
  $("#nameuser").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
  $("#usernameuser").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
  $("#emailuser").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
  $("#avataruser").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
}
 


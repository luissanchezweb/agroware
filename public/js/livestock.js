"use strict";
let table;
let firstTime = true;
let content = "";
let row = "";
let id = "";
let observations = "";
$(document).ready(function () {
    loadLivestock();
    $("#filtrado").on("click", filterAnimals)
    $("#limpiar-filtro").on("click", clearFilter)
    $("#animals").on("change", validateValue);
    $(".cont-tabla").hide();
    $(".filters").hide();
    confEditFormulario();
    createAnimalForm();
    loadLivestockForm();
    treatAnimalForm();
    notifyPatologyForm();
    sellAnimalForm();
    createLivestockForm();
    $.validator.addMethod("checkCodeExists", function(value, element)
    {
        var inputElem = $('.create-animal :input[name="codigo"]');
        var inputLive = $('.create-animal :input[id="livestock-animal"]');
        var code = inputLive.val().substr(0,2).toUpperCase()+inputElem.val();
        let validate = false;
        $.ajax(
        {
            type: "POST",
            url: `validateCode/${inputLive.val()}/${inputElem.val()}`,
            dataType: "json",
            async: false,
            success: function(response)
            {
               validate = response.data;
            }    
        });
        return validate;
    }, 'Ese crotal ya existe');
    $.validator.addMethod("datenotgreaterthantoday",
        function(value, element) {
              var currentDate = new Date();
              var selectedDate = new Date(value);
              return (currentDate >= selectedDate);
        },
        "La fecha debe ser igual o anterior a la de hoy"
    );
    $.validator.addMethod("dategreaterthantoday",
        function(value, element) {
              var currentDate = new Date();
              var selectedDate = new Date(value);
              return (currentDate < selectedDate);
        },
        "La fecha debe ser igual o superior a la de hoy"
    );
    $.validator.addMethod("checkMaxAnimals", function(value, element)
    {
        var inputLive      = $('.sellForm :input[id="livestock_sell"]');
        var inputWeightMin = $('.sellForm :input[id="animal_weight_sell"]');
        var inputWeightMax = $('.sellForm :input[id="animal_weightmax_sell"]');
        var inputAgeMin    = $('.sellForm :input[id="animal_age_sell"]');
        var inputAgeMax   = $('.sellForm :input[id="animal_agemax_sell"]');
        let validate       = false;
        $.ajax(
        {
            type: "POST",
            url: `validateSell/${inputLive.val()}/${inputAgeMin.val()}/${inputAgeMax.val()}/${inputWeightMin.val()}/${inputWeightMax.val()}`,
            dataType: "json",
            async: false,
            success: function(response)
            {
                $('.advice_animal').empty();
                 if(response['data'] == 0){
                        
                    $('.advice_animal').append(`No hay ningún animal con esos requisitos`)
                }
                if(response.data != false){
                    
                    if(response.data.length != 0){
                        $('.advice_animal').append(`Hay ${response.data.length} animales que cumplen los requisitos`)
                    }

                    if(response.data.length >= $('.sellForm :input[id="n_animals_sell"]').val()){
                        validate = true;
                    }else if(response.data.length < $('.sellForm :input[id="n_animals_sell"]').val()){
                        $('.advice_animal').empty();
                        $('.advice_animal').append(`Has excedido el número de animales disponibles (${response.data.length})`)
                    }
                }
               
            }    
        });
        return validate;
    }, `Los filtros no cumplen los requisitos`);

    $("#food option:gt(0)").remove(); //*lo vacío para que no se acumulen todas las opciones
    $("#production option:gt(0)").remove(); //*lo vacío para que no se acumulen todas las opciones
    const food =['pienso concentrado', 'pienso natural', 'semillas', 'fruta', 'heno',  'paja', 'fruta'];
    const production =['carne', 'cría','huevos','ventas', 'leche', 'espectáculo'];
                        
    food.forEach(element => {
        $("#food").append(`<option value='${element}'>${element}</option>`);  
    });

    production.forEach(element => {
        $("#production").append(`<option value='${element}'>${element}</option>`);
    });
});

function loadLivestockForm() {
    $.ajax({
        url: `types`,
        type: "GET"
    }).done(function (responseText) {
        $("#livestock-animal option:gt(0)").remove(); //*lo vacío para que no se acumulen todas las opciones, excepto la primera
        for (let index in responseText) {
            $("#livestock-animal").append(
                `<option value='${responseText[index]['id']}'>${responseText[index]['type']}</option>`
            );
        }
    });

    $.ajax({
        url: `types`,
        type: "GET"
    }).done(function (responseText) {
        $("#livestock-sell option:gt(0)").remove(); //*lo vacío para que no se acumulen todas las opciones, excepto la primera
        for (let index in responseText) {
            $("#livestock_sell").append(
                `<option value='${responseText[index]['id']}'>${responseText[index]['type']}</option>`
            );
        }
    });
}


function loadLivestock() {
    $.ajax({
        url: `types`,
        type: "GET"
    }).done(function (responseText) {
        $("#animals option:gt(0)").remove(); //*lo vacío para que no se acumulen todas las opciones, excepto la primera
        for (let index in responseText) {
            $("#animals").append(
                `<option value='${responseText[index]['id']}'>${responseText[index]['type']}</option>`
            );
        }
    });
}


function validateValue() {
    if($("#animals").val() != ""){
        if(firstTime){
            loadAnimals();
            $(".filters").show();
            $('.cont-tabla').show();
            $(".portada").hide();
        }else{
           clearFilter();
           table.ajax.url(`/livestock/${$('#animals').val()}`).load();
           $(".filters").show();
           $('.cont-tabla').show();
           $(".portada").hide();
        }
        
    }else{
        $(".filters").hide();
        $('.cont-tabla').hide();
        $(".portada").show();
    }
}


function loadAnimals() {
    table = $('.tabla').DataTable({
        sDom: 'lrtip',
        processing: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
        },
        resposive:true,
        columnDefs: [
            //hide id column
            { 'visible': false, 'targets': [0] },
            { className: 'dt-center', targets: '_all' }

        ],
        select: true,
        bDestroy: true,
        pageLength : 5,
        bLengthChange:false,
        ajax: `/livestock/${$('#animals').val()}`,
        columns: [
            {data: 'id', name : 'id'},
            {data: 'code' , name : 'Crotal', render: function ( data, type, row ) {
                return `<div style="position: relative; display: inline-block; text-align: center;">
                <img src="/img/tag.png" width=80px" height="40px"/>
                <div style="position: absolute; top: 60%; left: 50%; transform: translate(-50%, -50%); font-size:12px" >${data}</div>
                </div>`;  
           }},
            {data: 'race' , name : 'Raza', render: function ( data, type, row ) {
                return `<b>${data}</b>`;  
           }},
            {data: 'genre' , name : 'Sexo', render: function ( data, type, row ) {
                if(data == "macho"){
                    return `<span style="color: blue;  margin: 3px;  border-radius: 3px; "><i class="fa-solid fa-mars"></i></span> <p style='display: none;'>${data}</p>`;
                }else{
                    return `<span style="color: pink;  margin: 3px;  border-radius: 3px; "><i class="fa-solid fa-venus"></i></span> <p style='display: none;'>${data}</p>`;
                }    
           }},
            {data: 'age' , name : 'Edad'},
            {data: 'weight' , name : 'Peso'},
            {data: 'health_condition' , name : 'Estado', render: function ( data, type, row ) {
                if(data == "enfermo"){
                    return `<span style="padding:5px; background-color: red; color: white; margin: 3px;  border-radius: 3px; font-size: 15px">${data}</span>`;
                }else if(data == "observacion"){
                    return `<span style="padding:5px; background-color: blue; color: white; margin: 3px;  border-radius: 3px; font-size: 15px">${data}</span>`;
                }else if(data == "tratamiento"){
                    return `<span style="padding:5px; background-color: yellow; color: black; margin: 3px;  border-radius: 3px; font-size: 15px">${data}</span>`;
                }else{
                    return `<span style="padding:5px; background-color: green; color: white; margin: 3px;  border-radius: 3px; font-size: 15px">${data}</span>`;
                }    
           }},
            {data: 'food' , name : 'Alimentación', render: function ( data, type, row ) {
               return `<span style=" font-size: 12px">${data}</span>`;     
               
           }},
            {data: 'production' , name : 'Producción', render: function ( data, type, row ) {
                if(data == "carne"){
                    return `<button><i class="fa-solid fa-drumstick-bite"></i>${data}</button>`;  
                }else if(data == "huevos"){
                    return `<button><i class="fa-solid fa-egg"></i>${data}</button>`;  
                }else if(data == "ventas"){
                    return `<button><i class="fa-solid fa-money-bill"></i>${data}</button>`;  
                }else if(data == "cría"){
                    return `<button><i class="fa-solid fa-paw"></i>${data}</button>`;  
                }else if(data == "leche"){
                    return `<button><i class="fa-solid fa-blender"></i>${data}</button>`;  
                }else{
                    return `<button><i class="fa-solid fa-horse-head"></i>${data}</button>`;   
                }      
               
           }},
            {data: 'birth_date' , name : 'Nacimiento', render: function ( data, type, row ) {
                return `<button class="btn btn-outline-info" disabled style="color: black; background-color: white;">${data}</button>`;  
           }},
        ],
        initComplete: function (settings, json) {//*cuando termina la tarea ejecuta esta función
            firstTime = false;
            $('.tabla').show();
            $('.tabla tbody').on('click', 'tr', function () {
                if ($(this).hasClass('click')) {
                    $(this).removeClass('click');
                    $(this).css('backgroundColor','white');
                    $(this).css('color', 'black');
                } else {
                    $(this).addClass('click');
                    $('.click').css('backgroundColor','rgb(133, 156, 114)');
                    $('.click').css('color', 'white');
                }
               
            });
            // Add event listener for opening and closing details
    $('.tabla tbody').on('click', 'td', function () {
        var tr = $(this).parents('tr');
        row = table.row( tr );
        id = row.data().id;
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            $.ajax({
                type: "get",
                url: `/getAnimal/${id}`,
                dataType: "json",
                success: function (response) {
                    content =`
                        <div class="cont">
                            <div class="row">
                                <div class="col-8 form-group">
                                    <label for="notas"><span style="color:white; background-color:black; padding:5px">Observaciones médicas</span></label>
                                    <textarea class="form-control" id="observations-single" name="observations" rows="3" required disabled>${response.data['observations']}</textarea>
                                </div>
                                <div class="col-4">
                                    <div class="row" style="margin-top:35px">
                                    <div class="col-4">
                                        <button class="btn btn-outline-info edit" data-id="${response.data['id']}" data-bs-toggle="modal" data-bs-target="#staticBackdrop3" ><i class="fa-solid fa-paper-plane"></i>Editar</button>
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-outline-danger delete" data-id="${response.data['id']}"><i class="fa-solid fa-eraser"></i>Eliminar</button>
                                    </div>`;
                                if(response.data['health_condition'] == 'saludable'){
                                    content += `<div class="col-4">
                                                    <button class="btn btn-outline-warning noti" data-id="${response.data['id']}" data-bs-toggle="modal" data-bs-target="#staticBackdrop5"><i class="fa-solid fa-circle-exclamation"></i>Notificar</button>
                                                </div>`;
                                    
                                }else if(response.data['health_condition'] == 'enfermo'){
                                    content += `<div class="col-4">
                                                    <button class="btn btn-outline-success treat" data-id="${response.data['id']}" data-bs-toggle="modal" data-bs-target="#staticBackdrop4"><i class="fa-solid fa-shield-dog"></i>Tratar</button>
                                                </div>`;
                                }    
                            content +=`    
                                    </div>    
                                </div>
                            </div>
                        </div>`;
                    // Open this row
                    row.child( content ).show();
                    tr.addClass('shown');
                    $(".treatForm").attr("action",`/treatAnimal/${$(".treat").attr("data-id")}`);
                    $(".notification-form").attr("action",`/notifyPatology/${$(".noti").attr("data-id")}`);
                    $('#treat-code').val($(".treat").attr("data-id"));
                    $('.edit').on("click", loadAnimal); 
                    $('.delete').on("click", function () {
                        Swal.fire({
                            title: '¿Deseas eliminar este animal?',
                            icon: 'warning',
                            showDenyButton: true,
                            confirmButtonText: 'Eliminar',
                            denyButtonText: `Cancelar`,
                          }).then((result) => {
                            if (result.isConfirmed) {
                                deleteAnimal();
                            }
                          })
                    })
                }
            });
            
        }
    } );
        },
    });

}

function loadAnimal() {
    $.ajax({
        type: "get",
        url: `getAnimal/${$(this).attr("data-id")}`,
        datatype: "json",
        success: function (response) {    

                $('.edit-animal').attr("action", `/updateAnimalParams/${response.data['id']}`);
                $('#animal-weight').val(`${response.data['weight']}`);
                $('#animal-food').val(`${response.data['food']}`);
                $("#animal-food option:gt(0)").remove(); //*lo vacío para que no se acumulen todas las opciones
                $("#animal-production option:gt(0)").remove(); //*lo vacío para que no se acumulen todas las opciones
                if(response.data['code'].startsWith('AVI')){
                    const food =['pienso concentrado', 'pienso natural', 'semillas', 'fruta'];
                    const production =['carne', 'cría','huevos','ventas'];
                        
                    food.forEach(element => {
                        if(response.data['food'] == element){
                            $("#animal-food").append(`<option value='${response.data['food']}' selected>${response.data['food']}</option>`
                        );
                        }else{
                            $("#animal-food").append(`<option value='${element}'>${element}</option>`
                            );
                        }
                    });

                    production.forEach(element => {
                        if(response.data['production'] == element){
                            $("#animal-production").append(`<option value='${response.data['production']}' selected>${response.data['production']}</option>`
                        );
                        }else{
                            $("#animal-production").append(`<option value='${element}'>${element}</option>`
                            );
                        }
                    });

                }else if(response.data['code'].startsWith('BOV')){
                    const food =['pienso concentrado', 'pienso natural', 'heno', 'paja'];
                    const production =['carne', 'cría', 'leche', 'espectáculo','ventas'];

                    food.forEach(element => {
                        if(response.data['food'] == element){
                            $("#animal-food").append(`<option value='${response.data['food']}' selected>${response.data['food']}</option>`
                        );
                        }else{
                            $("#animal-food").append(`<option value='${element}'>${element}</option>`
                            );
                        }
                    });

                    production.forEach(element => {
                        if(response.data['production'] == element){
                            $("#animal-production").append(`<option value='${response.data['production']}' selected>${response.data['production']}</option>`
                        );
                        }else{
                            $("#animal-production").append(`<option value='${element}'>${element}</option>`
                            );
                        }
                    });


                }else if(response.data['code'].startsWith('POR')){
                    const food =['pienso concentrado', 'pienso natural', 'heno', 'fruta'];
                    const production =['carne','ventas']; 

                    food.forEach(element => {
                        if(response.data['food'] == element){
                            $("#animal-food").append(`<option value='${response.data['food']}' selected>${response.data['food']}</option>`
                        );
                        }else{
                            $("#animal-food").append(`<option value='${element}'>${element}</option>`
                            );
                        }
                    });

                    production.forEach(element => {
                        if(response.data['production'] == element){
                            $("#animal-production").append(`<option value='${response.data['production']}' selected>${response.data['production']}</option>`
                        );
                        }else{
                            $("#animal-production").append(`<option value='${element}'>${element}</option>`
                            );
                        }
                    });


                }else if(response.data['code'].startsWith('OVI')){
                    const food =['pienso concentrado', 'pienso natural', 'heno',  'paja', 'fruta'];
                    const production =[ 'cría', 'leche','ventas'];

                    food.forEach(element => {
                        if(response.data['food'] == element){
                            $("#animal-food").append(`<option value='${response.data['food']}' selected>${response.data['food']}</option>`
                        );
                        }else{
                            $("#animal-food").append(`<option value='${element}'>${element}</option>`
                            );
                        }
                    });

                    production.forEach(element => {
                        if(response.data['production'] == element){
                            $("#animal-production").append(`<option value='${response.data['production']}' selected>${response.data['production']}</option>`
                        );
                        }else{
                            $("#animal-production").append(`<option value='${element}'>${element}</option>`
                            );
                        }
                    });

                }else{
                    const food =['pienso concentrado', 'pienso natural', 'semillas', 'heno', 'fruta', 'paja'];
                    const production =['carne', 'cría', 'leche', 'espectáculo','ventas'];
                    food.forEach(element => {
                        if(response.data['food'] == element){
                            $("#animal-food").append(`<option value='${response.data['food']}' selected>${response.data['food']}</option>`
                        );
                        }else{
                            $("#animal-food").append(`<option value='${element}'>${element}</option>`
                            );
                        }
                    });

                    production.forEach(element => {
                        if(response.data['production'] == element){
                            $("#animal-production").append(`<option value='${response.data['production']}' selected>${response.data['production']}</option>`
                        );
                        }else{
                            $("#animal-production").append(`<option value='${element}'>${element}</option>`
                            );
                        }
                    });

                }
        }
    });
}


function treatAnimal() {
    $(".treatForm").on('submit', function(event){
        var url = $(this).attr('action');
        event.stopImmediatePropagation();
        event.preventDefault();
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
                    limpiarTreatForm();
                     $('.treatForm').trigger('reset');
                     $('.treat-modal').modal('toggle');
                    table.ajax.reload();

                    Toastify({
                        text: `${response.message}`,
                        duration: 2000,
                        style: {
                            background: "green",
                          }
                        }).showToast();
                
            }
        });
       
    });
}


function updateAnimal() {
    $(".edit-animal").submit(function(event){
        event.stopImmediatePropagation();
        event.preventDefault();
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
                    limpiarEditAnimal();
                     $('.edit-animal').trigger('reset');
                     $('.editparams').modal('toggle');
                    table.ajax.reload();

                    Toastify({
                        text: `${response.message}`,
                        duration: 2000,
                        style: {
                            background: "green",
                          }
                        }).showToast();
                
            },
        });
    });
}

function createAnimal() {
    $(".create-animal").on('submit', function(event){
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
                $('.createAnimal').modal('toggle');
                limpiarCreateAnimal();
                $('.create-animal').trigger('reset');
                table.ajax.reload();
                Toastify({
                    text: `${response.message}`,
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

function confEditFormulario() {
    $(".edit-animal").validate({
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
        animalweight:{
          required:true,
        }, 
        animalfood: "required",
        animalproduction: "required"
      },
      submitHandler: (form) => {
        updateAnimal();
      },
    });
  }; 

function createAnimalForm() {
    $(".create-animal").validate({
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
          livestock: "required",
          codigo:{
            required: true,
            checkCodeExists: true
          },
          raza: "required",
          genre: "required",
          peso: {
            required: true
          },
          health_condition: "required",
          observations: "required",
          alimentacion: "required",
          produccion: "required",
          f_nacimiento: {
            required: true,
            datenotgreaterthantoday: true
          }
        },
        submitHandler: (form) => {
          createAnimal();
        },
      });
}

function treatAnimalForm() {
    $(".treatForm").validate({
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
          n_treats:{
            required:true,
            min: 1,
            max: 10
          },
          n_days_between:{
            required: true,
            min:1,
            max:7
          },
          start_date: {
            required: true,
            dategreaterthantoday: true
          }
        },
        submitHandler: (form) => {
          treatAnimal();
        },
      });
}

function sellAnimalForm() {
    $(".sellForm").validate({
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
          livestock_sell:{
            required:true,

          },
          n_animals_sell:{
            required: true,
            min:1,
            checkMaxAnimals: true
          },
          animal_weight_sell:{
            required: true,
            min: 1
          },
          animal_weightmax_sell:{
            required: true,
            min: $('#animal_weight_sell').val()
          },
          animal_age_sell:{
            required: true,
            min: 1
          },
          animal_agemax_sell:{
            required: true,
            min: $('#animal_age_sell').val()
          }
        },
        submitHandler: (form) => {
           sellAnimals();
        },
      });
}

function sellAnimals() {
    var inputLive      = $('.sellForm :input[id="livestock_sell"]');
    var inputWeightMin = $('.sellForm :input[id="animal_weight_sell"]');
    var inputWeightMax = $('.sellForm :input[id="animal_weightmax_sell"]');
    var inputAgeMin    = $('.sellForm :input[id="animal_age_sell"]');
    var inputAgeMax    = $('.sellForm :input[id="animal_agemax_sell"]');
    var n_animals_sell = $('.sellForm :input[id="n_animals_sell"]')
    $('.sellForm').attr('action',`sell/${inputLive.val()}/${inputAgeMin.val()}/${inputAgeMax.val()}/${inputWeightMin.val()}/${inputWeightMax.val()}/${n_animals_sell.val()}`);
    $(".sellForm").on('submit', function(event){
        var url = $('.sellForm').attr('action');
        event.stopImmediatePropagation();
        event.preventDefault();
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
                    limpiarSellForm();
                     $('.sellForm').trigger('reset');
                     $('.sell-modal').modal('toggle');
                    table.ajax.reload();

                    Toastify({
                        text: `${response.message}`,
                        duration: 2000,
                        style: {
                            background: "green",
                          }
                        }).showToast();
                
            }
        });
       
    });
}

function createLivestockForm() {
    $(".livestock-form").validate({
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
          type:{
            required:true,
        },
    },
        submitHandler: (form) => {
          createLivestock();
        },
      });
}

function deleteAnimal() {
    $.ajax({
        type: "post",
        url: `/animals/delete/${$('.delete').attr("data-id")}`,
        datatype: "json",
        success: function (response) {    
            table.ajax.reload();
            Toastify({
                text: `${response.message}`,
                duration: 2000,
                style: {
                    background: "green",
                  }
                }).showToast();
        }
    });
}


function limpiarEditAnimal() {
    $("#animal-weight").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
    $("#animal-food").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
    $("#animal-production").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
}

function limpiarCreateAnimal() {
    $("#livestock-animal").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
    $("#code").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
    $("#race").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
    $("#gender").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
    $("#weight").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
    $("#health_condition").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
    $("#observations").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
    $("#food").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
    $("#production").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
    $("#birth_date").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
}

function limpiarTreatForm() {
    $("#n_treats").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
    $("#n_days_between").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
    $("#start_date").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde 
}

function limpiarSellForm() {
    $("#livestock_sell").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
    $("#animal_weight_sell").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
    $("#animal_weightmax_sell").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
    $("#animal_age_sell").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
    $("#animal_agemax_sell").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
    $("#n_animals_sell").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
    $('.advice_animal').empty();
}

function limpiarpatologyForm() {
    $("#patology").removeClass("is-valid");//borro la clase is-valid para que desaparezca el tic verde
}

function filterAnimals() {
    var crotal = $('#codefilter').val();
    var race   = $('#racefilter').val();
    var health = $('#healthfilter').val();
    var prod   = $('#prodfilter').val();
    var food   = $('#foodfilter').val();

    $('.tabla').DataTable()
               .columns(1)
               .search(crotal, true, false)
               .draw();

    $('.tabla').DataTable()
               .columns(2)
               .search(race, true, false)
               .draw(); 

   $('.tabla').DataTable()
               .columns(6)
               .search(health, true, false)
               .draw();      
               
    $('.tabla').DataTable()
               .columns(7)
               .search(food, true, false)
               .draw();

    $('.tabla').DataTable()
               .columns(8)
               .search(prod, true, false)
               .draw();
    
}

function clearFilter() {
    $('#codefilter').val("");
    $('#racefilter').val("");
    $('#healthfilter').val("");
    $('#prodfilter').val("");
    $('#foodfilter').val("");
    filterAnimals();
}

function notifyPatologyForm() {
    $(".notification-form").validate({
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
            patology: 'required'
        },
        submitHandler: (form) => {
          patology();
        },
      });
}

function patology() {
    $(".notification-form").submit(function(event){
        var url = $(this).attr('action');
        event.stopImmediatePropagation();
        event.preventDefault();
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
                    limpiarpatologyForm();
                     $('.notification-form').trigger('reset');
                     $('.notificationmodal').modal('toggle');
                    table.ajax.reload();

                    Toastify({
                        text: `Patología notificada`,
                        duration: 2000,
                        style: {
                            background: "green",
                          }
                        }).showToast();
                
            },
        });
        event.preventDefault();
    });
}


function createLivestock() {
    $(".livestock-form").submit(function(event){
        var url = $(this).attr('action');
        event.stopImmediatePropagation();
        event.preventDefault();
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
                    limpiarLivestockForm();
                     $('.livestock-form').trigger('reset');
                     $('.live-modal').modal('toggle');
                    loadLivestock();
                    Toastify({
                        text: `${response.message}`,
                        duration: 2000,
                        style: {
                            background: "green",
                          }
                        }).showToast();
                
            },
        });
        event.preventDefault();
    });
}


function limpiarLivestockForm() {
    $('#live-type').removeClass("is-valid");
}
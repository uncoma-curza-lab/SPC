function getUrlVars() {

  var vars = {};
  //console.log("se ejecuto geturlvars")
  var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
    vars[key] = value;
  });
  //return vars;
  return vars["id"];
}


$(function() {
  Id = 0

  // define tour
  var tour = new Tour({
    debug: true,
    //basePath: location.pathname.slice(0, location.pathname.lastIndexOf('/')),
    basePath: "/index.php",
    steps: [
      {
        path: "?r=site/index",
        element: "#programaLink",
        title: "Bienvenido!",
        smartPlacement: true,
        content: "Mediante este Tour interactivo podrás aprender a cargar un programa. Haz click en \"siguiente\" para comenzar.",
        backdrop: true,
      },
      {
        path: "?r=programa/index",
        element: "#agregar",
        title: "Agregar un programa",
        smartPlacement: true,
      //  backdrop: true,
        content: "Vamos a crear un nuevo programa para luego designar el cargo al profesor correspondiente.",
      },
      {
        path: '?r=programa/anadir',
        element: "#programa-year",
        title: "Selección de año",
        placement: "bottom",
      //  backdrop: true,
        content: "Ingresaremos el año al que pertenece el programa.",
      },
      {
        path: '?r=programa/anadir',
        element: "#select2-programa-asignatura_id-container",
        title: "Selección de asignatura",
        placement: "bottom",
      //  backdrop: true,
        content: "Seleccionamos la asignatura a la que este programa corresponde.",

      },
      {
        path: '?r=programa/anadir',
        element: "#anadir-confirmar",
        title: "Confirmación",
        placement: "right",
        //backdrop: true,
        content: "Confirme la creación del programa",
        onNext:function(){
          //console.log("mira esto")
          //console.log(getUrlVars())
          console.log("salida onnext"+getUrlVars())

          document.getElementById('anadir-confirmar').click();
        },
        onShow: function(){
          console.log("salida onshow pp"+getUrlVars())
          Id = getUrlVars()
        },


      },
      {
        path: '?r=designacion/asignar&id='+Id,
        element: "#select2-designacion-cargo_id-container",
        title: "Selección de cargo",
        placement: "bottom",
        content: "Seleccione el cargo a designar.",
        backdrop:true,
        onShow: function(){
          console.log("salida design"+getUrlVars())
          var Id = getUrlVars()
        },
      },
      {
        path: '?r=designacion/asignar&id='+Id,
        element: "#select2-designacion-user_id-container",
        title: "Selección de usuario",
        smartPlacement: true,
        content: "Seleccione al usuario correspondiente al cargo",
        backdrop: true,

      },

    ]
  });

  // init tour
  tour.init();

  // start tour
  $('#tour').click(function() {
    console.log("Empece")


    tour.restart();
  });

});

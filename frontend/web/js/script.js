function getUrlVars() {

  var vars = {};
  //console.log("se ejecuto geturlvars")
  var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
    vars[key] = value;
  });
  //return vars;
  return vars["id"];
}



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
        content: "Este es un tour interactivo, puede consultarlo cuando sea necesario. Para cargar su primer programa haga click aquí y luego \"Mis programas\"",
        backdrop: true,
      },
      {
        path: "?r=mi-programa/index",
        element: "#agregar",
        title: "Agregar un programa",
        smartPlacement: true,
        backdrop: true,

      //  backdrop: true,
        content: "Con este botón puede cargar un nuevo programa.",
      },
      {
        path: '?r=mi-programa/anadir',
        element: "#programa-year",
        title: "Selección de año",
        placement: "bottom",
        backdrop: true,

      //  backdrop: true,
        content: "Ingresaremos el año al que pertenece el programa.",
      },
      {
        path: '?r=mi-programa/anadir',
        element: "#select2-programa-asignatura_id-container",
        title: "Selección de asignatura",
        placement: "bottom",
        backdrop: true,

      //  backdrop: true,
        content: "Seleccionamos la asignatura a la que este programa corresponde.",

      },
      {
        path: '?r=mi-programa/anadir',
        element: "#anadir-confirmar",
        title: "Confirmación",
        placement: "right",
        backdrop: true,

        //backdrop: true,
        content: "Confirme la creación del programa, luego podrá cargar cada sección. ¡Mucha suerte!",
      //  onNext:function(){
          //console.log("mira esto")
          //console.log(getUrlVars())

//          document.getElementById('anadir-confirmar').click();
        //},
  /*      onShow: function(){
          console.log("salida onshow pp"+getUrlVars())
          Id = getUrlVars()
        },*/


      },

    ]
  });

  // init tour
  tour.init();

  // start tour
  $('#tour').click(function() {
    //console.log("Empece")
    tour.restart();
  });

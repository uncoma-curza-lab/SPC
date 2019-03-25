var tour = new Tour({
  name: 'tour',
  debug: true,
  steps: [
    {
      element: '#programa-year',
      //placement: 'right',
      smartPlacement: true,
      title: 'Barra de progreso',
      content: 'Esta barra indica qué tan completo está el programa con respecto al modelo estandarizado.',
      next: 0,
      prev: 0,
      animation: true,
    }
  ],
  backdrop: false,
  backdropContainer: 'body',
  backdropPadding: 0,
});
tour.init();

$('#tour').click(function() {

  console.log('Empece con tour restart')
  tour.restart();
});

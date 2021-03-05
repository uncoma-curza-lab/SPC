<?php
    /*
    * Comienzan las funciones para crear y exportar un PDF
    */
    public function actionExportPdf($id){
      $model = $this->findModel($id);
      $mpdf = new Mpdf\Mpdf(['utf-8','A4','tempDir' => __DIR__ . '/tmp']);
      $stylesheet = file_get_contents('css/estilo-pdf.css');
      //$header = 'Document header';
      //$html   = 'Your document content goes here';

      //$mpdf = new Mpdf('utf-8', 'A4', 0, '', 12, 12, 25, 15, 12, 12);
      //$mpdf->SetHTMLHeader($header);
      $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
      $mpdf->WriteHTML($this->renderPartial('portada',['model'=>$model]));
      $mpdf->addPage();
      $footer =  '<span style="font-size:12px; !important"> Página {PAGENO} de {nb}</span>';
      $mpdf->SetHTMLFooter($footer);

      $mpdf->WriteHTML($this->renderPartial('paginas',['model'=>$model]));
      $mpdf->Output();
    }

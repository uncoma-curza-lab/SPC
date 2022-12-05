<?php

namespace common\domain\programs\commands\ExportProgram;

use common\models\PermisosHelpers;
use common\models\Programa as Program;
use common\models\Status;
use common\shared\commands\CommandInterface;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;

class ExportProgramProcess implements CommandInterface
{

    protected Program $program;

    public function __construct(Program $program)
    {
        $this->program = $program;
    }

    public function handle() : ExportProgramResult
    {
        try {
            if (!$this->checkPermission()) {
                throw new \Exception('No tiene permisos');
            }
            $mpdf = new Mpdf([
                'utf-8',
                'A4',
                'tempDir' => \Yii::getAlias('@common/tmp')
            ]);
            $stylesheet = file_get_contents(\Yii::getAlias('@frontend/web/css/estilo-pdf.css'));
            $mpdf->WriteHTML($stylesheet, HTMLParserMode::HEADER_CSS);
            $mpdf->WriteHTML(
                \Yii::$app->view->renderFile('@frontend/views/programa/portada.php', [
                    'model'=> $this->program
                ])
            );
            $mpdf->addPage();
            $footer =  '<span style="font-size:12px; !important"> Página {PAGENO} de {nb}</span>';
            $mpdf->SetHTMLFooter($footer);

            $mpdf->WriteHTML(\Yii::$app->view->renderFile(
                '@frontend/views/programa/paginas.php',
                [ 'model' => $this->program ]
            ));

            return new ExportProgramResult(
                true,
                'El programa se exportó con éxito',
                [
                    'mpdf' => $mpdf
                ]
            );
        } catch (\Throwable $e) {
            // TODO: log exception
            \Yii::warning($e->getMessage());
            return new ExportProgramResult(false, 'Error to process export', [
                'exception' => $e
            ]);
        }
    }

    protected function checkPermission()
    {
      $status = $this->program->status;
      if(
          $status->descriptionIs(Status::BIBLIOTECA) ||
          (PermisosHelpers::requerirSerDueno($this->program->id)) ||
          (PermisosHelpers::requerirMinimoRol("Departamento") && PermisosHelpers::requireMinStatus($this->program->id, Status::EN_ESPERA_ID)) // ||
          //(PermisosHelpers::requerirDirector($this->program->id)) todavia no se puede activar
       ){
         return true;
       }
      return false;
    }
}

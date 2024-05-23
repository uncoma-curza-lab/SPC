<?php

use yii\db\Migration;

/**
 * Class m240508_023356_full_courses_view
 */
class m240508_023356_full_courses_view extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("

            CREATE PROCEDURE refresh_full_courses_materialized_view()
            BEGIN
                DROP TABLE full_courses_view;
                CREATE TABLE full_courses_view AS
                SELECT
                    c.id,
                    c.orden,
                    c.nomenclatura,
                    c.curso,
                    c.cuatrimestre,
                    c.carga_horaria_sem,
                    c.carga_horaria_cuatr,
                    c.requisitos,
                    p.planordenanza,
                    d.nom AS department_name,
                    d.id AS department_id,
                    department_auditor.id AS department_auditor_id,
                    department_auditor.nom AS department_auditor_name
                FROM
                    asignatura c
                JOIN plan p ON
                    p.id = c.plan_id
                JOIN carrera career ON career.id = p.carrera_id
                LEFT JOIN asignatura c_parent ON
                    c_parent.id = c.parent_id
                JOIN departamento department_auditor ON
                    department_auditor.id = c.departamento_id
                JOIN departamento d ON d.id = career.departamento_id;
            END
        ");


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("
            DROP TABLE full_courses_view;
            DROP PROCEDURE IF EXISTS refresh_full_courses_materialized_view;
         ");
    }

}

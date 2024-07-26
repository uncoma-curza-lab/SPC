<?php

use yii\db\Migration;

/**
 * Class m240508_024905_course_syllabus_view
 */
class m240508_024905_course_syllabus_view extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            CREATE PROCEDURE refresh_syllabus_materialized_view()
            BEGIN
                DROP TABLE syllabus_view;
                CREATE TABLE syllabus_view AS
                SELECT
                    p.id AS syllabus_id
                    ,p.YEAR
                    ,p.created_at
                    ,p.updated_at
                    ,s.value AS status_value
                    ,s.descripcion AS status_description
                    ,department_auditor_assigned.nom AS department_auditor_assigned_name
                    ,c.nomenclatura AS course_name
                    ,CONCAT(creator_profile.nombre, \" \", creator_profile.apellido) AS creator_name
                    ,cu.id AS user_identifier
                FROM
                    programa p
                LEFT JOIN departamento department_auditor_assigned ON
                    department_auditor_assigned.id = p.departamento_id
                JOIN status s ON
                    s.id = p.status_id
                JOIN asignatura c ON
                    c.id = p.asignatura_id
                JOIN user cu ON
                    cu.id = p.created_by
                JOIN perfil creator_profile ON cu.id = creator_profile.user_id
                JOIN plan syllabus_plan ON
                    syllabus_plan.id = p.current_plan_id
                JOIN modules m ON
                    m.program_id = p.id
                WHERE
                p.deleted_at IS NULL;
            END
        ");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("
            DROP TABLE syllabus_view;
            DROP PROCEDURE IF EXISTS refresh_syllabus_materialized_view;
         ");
    }
}

<?php

namespace common\models;

use Yii;
use frontend\models\Perfil;

/**
 * This is the model class for table "departamento".
 *
 * @property int $id
 * @property string $nom
 * @property string $slug
 * @property int $director
 * @property Asignatura[] $asignaturas
 * @property Carrera[] $carreras
 * @property User $director0
 * @property Programa[] $programas
 */
class DepartamentoElastic extends \yii\elasticsearch\ActiveRecord
{

     /**
     * @return array the list of attributes for this record
     */
    public function attributes()
    {
        // path mapping for '_id' is setup to field 'id'
        return [
            'id', 
            'nom', 'director'];
    }

     /**
     * @return array This model's mapping
     */
    public static function mapping()
    {
        return [
            static::type() => [
                'properties' => [
                    'id' => ['type' => 'integer'],
                    'nom'           => ['type' => 'text'],
                    'director'    => ['type' => 'integer'],
                ]
            ],
        ];
    }

    /**
     * Set (update) mappings for this model
     */
    public static function updateMapping()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->setMapping(static::index(), static::type(), static::mapping());
    }

    /**
     * Create this model's index
     */
    public static function createIndex()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->createIndex(static::index(), [
            //'settings' => [ /* ... */ ],
            'mappings' => static::mapping(),
            //'warmers' => [ /* ... */ ],
            //'aliases' => [ /* ... */ ],
            //'creation_date' => '...'
        ]);
    }

    /**
     * Delete this model's index
     */
    public static function deleteIndex()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->deleteIndex(static::index(), static::type());
    }
}

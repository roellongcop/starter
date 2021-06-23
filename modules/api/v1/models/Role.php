<?php

namespace app\modules\api\v1\models;

use Yii;

/**
 * This is the model class for table "{{%roles}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $main_navigation
 * @property string|null $role_access
 * @property string|null $module_access
 * @property string $slug
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Role extends \app\models\Role
{
    
}
<?php
namespace App\Modules\Crm\schedule\src\factories;

use App\Modules\Crm\schedule\src\entity\CorrectionCardEntity;

class CorrectionScheduleCardFactory
{
    public static function createCorrectionCard($data): CorrectionCardEntity
    {
        return new CorrectionCardEntity(
            $data['id'],
            $data['cardName'],
            $data['numberPair'],
        );
    }
}

<?php

namespace App\Enum;

enum Role: int
{
    case CLIENT = 0;
    case BOUTIQUIER = 1;
    case ADMIN = 2;

    // Méthode pour obtenir toutes les valeurs
    public static function getValues(): array
    {
        return [
            self::CLIENT->value => 'Client',
            self::BOUTIQUIER->value => 'Boutiquier',
            self::ADMIN->value => 'Administrator',
        ];
    }
}

<?php

namespace App\Enum;

enum Etat: int
{
    case EN_COURS = 0;
    case REJETEE = 1;
    case ACCEPTEE = 2;

    // Méthode pour obtenir toutes les valeurs
    public static function getValues(): array
    {
        return [
            self::EN_COURS->value => 'En cours',
            self::REJETEE->value => 'Rejetée',
            self::ACCEPTEE->value => 'Acceptée',
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Enum;

enum GenderEnum: int
{
    case ACTION = 28;
    case AVENTURE = 12;
    case ANIMATION = 16;
    case COMEDIE = 35;
    case CRIME = 80;
    case DOCUMENTAIRE = 99;
    case DRAME = 18;
    case FAMILIAL = 10751;
    case FANTASTIQUE = 14;
    case HISTOIRE = 36;
    case HORREUR = 27;
    case MUSIQUE = 10402;
    case MYSTERE = 9648;
    case ROMANCE = 10749;
    case SCIENCE_FICTION = 878;
    case TELEFILM = 10770;
    case THRILLER = 53;
    case GUERRE = 10752;
    case WESTERN = 37;
}

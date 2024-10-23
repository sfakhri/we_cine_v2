<?php

declare(strict_types=1);

namespace App\Enum;

enum CallApiEnum: string
{
    case SEARCH_MOVIE = 'https://api.themoviedb.org/3/search/movie';
    case SEARCH_LINK_MOVIE = 'https://api.themoviedb.org/3/movie';
    case SEARCH_TV = 'https://api.themoviedb.org/3/search/tv';
    case SEARCH_PERSON = 'https://api.themoviedb.org/3/search/person';
    case SEARCH_COLLECTION = 'https://api.themoviedb.org/3/search/collection';
    case SEARCH_COMPANY = 'https://api.themoviedb.org/3/search/company';
    case SEARCH_KEYWORD = 'https://api.themoviedb.org/3/search/keyword';
    case SEARCH_MULTI = 'https://api.themoviedb.org/3/search/multi';
    case SEARCH_DISCOVER = 'https://api.themoviedb.org/3/discover/movie';
}

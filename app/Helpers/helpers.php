<?php

function partToCollection($partName)
{
    return collect(explode(' ', str_replace(['.', '-'], ' ', $partName)));
}


function make_non_unique_slug($text)
{
    $replacements = [
        '.'      => '',
        ','      => '',
        '--'     => '-',
        '/'      => '-and-',
        '\\'     => '-and-',
        ' & '    => '-and-',
        '&'      => '-and-',
        ' '      => '-',
        '['      => '-',
        ']'      => '-',
    ];

    $atTheRate = strpos($text, '@');
    if ($atTheRate && $atTheRate >= 0) {
        $text = substr($text, 0, $atTheRate); // only consider values before @
    }

    return trim(str_replace(
        array_keys($replacements),
        array_values($replacements),
        strtolower($text)
    ), "- \t\n\r\0\x0B");
}

function registerationRoles()
{
    $roles = collect();
    $roles->push(['value' => 'client', 'title' => 'Client']);
    $roles->push(['value' => 'guest', 'title' => 'Guest']);

    return $roles->map(function ($role) {
        return (object) $role;
    });
}

function gendersAllowed()
{
    $genders = collect();

    $genders->push(['value' => 'male', 'title' => 'Male']);
    $genders->push(['value' => 'female', 'title' => 'Female']);
    $genders->push(['value' => 'other', 'title' => 'Other']);

    return $genders->map(function ($gender) {
        return (object) $gender;
    });
}

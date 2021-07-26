<?php

/* https://gist.github.com/sunaoka/6362065 */


function dec2dohex(int $dec): string
{
    $hashtable = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $result = '';

    while ($dec > 0) {
        $mod = $dec % 52;
        $result = $hashtable[$mod] . $result;
        $dec = ($dec - $mod) / 52;
    }

    return $result;
}


function dohex2dec(string $dohex): int
{
    $hashtable = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $result = 0;

    foreach (str_split($dohex) as $string) {
        $result = $result * 52 + strpos($hashtable, $string);
    }

    return $result;
}

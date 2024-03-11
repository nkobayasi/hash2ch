<?php

function tripkey($key)
{
    $key = ltrim($key, "#");
    $salt = substr($key . "H.", 1, 2);
    $salt = preg_replace('/[^.-z]/', ".", $salt); //print($salt."\n");
    $salt = str_replace([':', ';', '<', '=', '>', '?', '@', '[', '\\', ']', '^', '_', '`'], ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'a', 'b', 'c', 'd', 'e', 'f', 'g'], $salt);
    $result = crypt($key, $salt);
    return substr($result, -10);
}

function tripkey12($key)
{
    $mark = substr($key, 0, 1);
    if($mark == '#' || $mark == '$'){
        if(preg_match('{^#([[:xdigit:]]{16})([./0-9A-Za-z]{0,2})?$}', $key, $matches)){
            return substr(crypt(pack("H*", $matches[1]), "{$matches[2]}.."), -10);
        }else{
            return '???';
        }
    }else{
        return str_replace(['+'], ['.'], substr(rtrim(base64_encode(sha1($key, true)), "="), 0, 12));
    }
}

printf("tripkey('#password') = '%s'\n", tripkey("#password"));
printf("tripkey('#istrip') = '%s'\n", tripkey("#istrip"));
printf("tripkey('#Wikipedia') = '%s'\n", tripkey("#Wikipedia"));
printf("tripkey('#0123') = '%s'\n", tripkey("#0123"));
printf("tripkey12('password') = '%s'\n", tripkey12("password"));
printf("tripkey12('istrip') = '%s'\n", tripkey12("istrip"));
printf("tripkey12('Wikipedia') = '%s'\n", tripkey12("Wikipedia"));
printf("tripkey12('123') = '%s'\n", tripkey12("0123"));
printf("tripkey12('1234567890123456') = '%s'\n", tripkey12("1234567890123456"));
printf("tripkey12('1234567890123456sb') = '%s'\n", tripkey12("1234567890123456sb"));
printf("tripkey12('0123456789abcdef') = '%s'\n", tripkey12("0123456789abcdef"));
printf("tripkey12('0123456789abcdefzz') = '%s'\n", tripkey12("0123456789abcdefzz"));
printf("tripkey12('#password') = '%s'\n", tripkey12("#password"));
printf("tripkey12('#istrip') = '%s'\n", tripkey12("#istrip"));
printf("tripkey12('#Wikipedia') = '%s'\n", tripkey12("#Wikipedia"));
printf("tripkey12('#0123') = '%s'\n", tripkey12("#0123"));
printf("tripkey12('#1234567890123456') = '%s'\n", tripkey12("#1234567890123456"));
printf("tripkey12('#1234567890123456sb') = '%s'\n", tripkey12("#1234567890123456sb"));
printf("tripkey12('#0123456789abcdef') = '%s'\n", tripkey12("#0123456789abcdef"));
printf("tripkey12('#0123456789abcdefzz') = '%s'\n", tripkey12("#0123456789abcdefzz"));
printf("base64(md5('#Wikipedia')) = '%s'\n", base64_encode(md5("#Wikipedia", true)));
printf("base64(sha1('#Wikipedia')) = '%s'\n", base64_encode(sha1("#Wikipedia", true)));

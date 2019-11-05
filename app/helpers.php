<?php

function gravatar_url($email)
{
    $mail = md5($email);

    return "https://gravatar.com/avatar/{$mail}".http_build_query([
            's' => 60
        ]);
}

<?php

header('Content-Type: text/plain; charset=utf-8');

try {


    if (
        !isset($_FILES['upfile']['error']) ||
        is_array($_FILES['upfile']['error'])
    ) {
        throw new RuntimeException('Nieprawidłowe wejście');
    }

    switch ($_FILES['upfile']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('Nie zaznaczono plików');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Nooo trochę za duże te pliki');
        default:
            throw new RuntimeException('Coś się stało, ale nikt nie wie co');
    }

    if ($_FILES['upfile']['size'] > 1000000) {
        throw new RuntimeException('Nooo trochę za duże te pliki');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
            $finfo->file($_FILES['upfile']['tmp_name']),
            array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            ),
            true
        )) {
        throw new RuntimeException('Nieprawidłowy format');
    }


    if (!move_uploaded_file(
        $_FILES['upfile']['tmp_name'],
        sprintf('./uploads/%s.%s',
            sha1_file($_FILES['upfile']['tmp_name']),
            $ext
        )
    )) {
        throw new RuntimeException('Błąd przy przenoszeniu plików');
    }

    echo 'Wszystko okej, można kontynuować :>';

} catch (RuntimeException $e) {

    echo $e->getMessage();

}

<?php
require_once('Validation.php');

$_POST = json_decode(file_get_contents('php://input'), true);

/* -- Variables --*/

$name = $_POST['form']['name'];
$surname = $_POST['form']['surname'];
$email = $_POST['form']['email'];
$birthday = $_POST['form']['birthday'];
$phone = $_POST['form']['phone'];
$city = $_POST['form']['city'];

/* -- Convert --*/

$phone = str_replace([' ','+','(',')', '-'],'',$phone);

$Validator = new Validator([
    "name" 	=> $name,
    "surname" => $surname,
    "email" => $email,
    "birthday" => $birthday,
    "phone" => $phone,
    "city" => $city
]);

$Validator->Expect("name", "required");
$Validator->Expect("surname", "required");
$Validator->Expect("email", "required, email");
$Validator->Expect("birthday", "required");
$Validator->Expect("phone", "required, PHONE");
$Validator->Expect("city", "required");

if ($Validator->Validate()) {
    $queryURL = "https://cc24650.tmweb.ru/rest/1/ni1xyz6wa3ls4s6b/crm.lead.add.json";
    $queryData = http_build_query(array(
        "fields" => array(

            "TITLE" => "Заявка с сайта",
            "NAME" => $name,
            "LAST_NAME" => $surname,
            'EMAIL' => [['VALUE' => $email, 'VALUE_TYPE' => 'WORK']],
            "BIRTHDATE" => $birthday,
            "PHONE" => array(
                "n0" => array(
                    "VALUE" =>  $phone,
                    "VALUE_TYPE" => "MOBILE",
                ),
            ),
            "UF_CRM_1632314889582" => $city
        )
    ));

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $queryURL,
        CURLOPT_POSTFIELDS => $queryData,
    ));
    $result = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($result,1);

    // если произошла какая-то ошибка - выведем её
    if(array_key_exists('error', $result))
    {
        die("Ошибка при сохранении лида: ".$result['error_description']);
    }
} else {

}

?>
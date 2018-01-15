<?php
  include('smsUnisender.php');
  $token = 'xxx';
  $phone = '375291234567';


// Отправка простого сообщения:
  $sms = new smsUnisender($token);
  $res = $sms->createSMSMessage('Моё сообщение');
  $message_id = $res[0]->message_id;
  $res2 = $sms->sendSms($message_id, $phone);
  if ($res2 == false)
    echo "Во время отправки сообщения произошла ошибка";
  else
    echo "Сообщение успешно отправлено, его ID: {$res2->sms_id}";


// Отправка сообщения с паролем от альфа-имени с ID=123:
  $sms = new smsUnisender($token);
  $alphaname_id = 123;
  $res = $sms->createPasswordObject('both', 5);
  $password_object_id = $res->result->password_object_id;
  $res2 = $sms->sendSmsMessageWithCode('Ваш пароль: %CODE%', $password_object_id, $phone, $alphaname_id);
  if ($res2 == false)
    echo "Во время отправки сообщения произошла ошибка";
  else
    echo "Сообщение успешно отправлено, его ID: {$res2[0]->sms_id}";


// Получение списка своих сообщений:
  $sms = new smsUnisender($token);
  $messages = $sms->getMessagesList();
  echo "<pre>";
  print_r($messages->result);
  echo "</pre>";
?>
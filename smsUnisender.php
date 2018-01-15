<?php
  class smsUnisender {
    private $token;

/**
 * $token - API ����
 */
    public function __construct($token) {
      $this->token = $token;
    }

/**
 * ���������� ������� �� sms.unisender.by/api/v1/.
 *   ���� ������� ���������� �������, ���������� ����� �� API � ���� �������.
 *   ���� ������� ���������� ��������� - ������� ������ ������ error() � ���������� false.
 * $command - ������� API
 * $params - ������������� ������, ����� �������� �������� ���������� ���������� ������� ����� token, �������� - �� ����������.
 *   token � $params ���������� �� �����.
 *   �������������� ��������, ��� ��� ��� ����� ������, ��� getLimit, getMessagesList, getPasswordObjects ������� ���������� ���������� �� �����.
 */
    private function sendRequest($command, $params=array()) {
      $url = 'http://sms.unisender.by/api/v1/'.$command.'?token='.$this->token;
      if (!empty($params)) {
        foreach ($params as $k => $v)
          $url .= '&'.$k.'='.urlencode($v);
      }
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, 20);
      $result = curl_exec($ch);
      curl_close($ch);

      $result = json_decode($result);
      if (isset($result->error)) {
        $this->error($result->error);
        return false;
      }
      else
        return $result;
    }

/**
 * ������������ ������.
 *   ����� ����� ���� ����� ���, �������������� ��������� �� API ������, ��������������� ������ ����������.
 * $error - ����� ������
 */
    private function error($error) {
      trigger_error("<b>smsUnisender error:</b> $error");
    }

/**
 * �����-������ ��� ������� getLimit
 */
    public function getLimit() {
      return $this->sendRequest('getLimit');
    }

/**
 * �����-������ ��� ������� createSMSMessage
 * $message - ����� ������������ ���������
 * $alphaname_id - ID �����-�����, �������������� ��������
 */
    public function createSMSMessage($message, $alphaname_id=0) {
      $params['message'] = $message;
      if (!empty($alphaname_id))
        $params['alphaname_id'] = (integer)$alphaname_id;
      return $this->sendRequest('createSmsMessage', $params);
    }

/**
 * �����-������ ��� ������� checkSMSMessageStatus
 * $message_id - ID ���������� ���������
 */
    public function checkSMSMessageStatus($message_id) {
      $params['message_id'] = (integer)$message_id;
      return $this->sendRequest('checkSMSMessageStatus', $params);
    }

/**
 * �����-������ ��� ������� getMessagesList
 */
    public function getMessagesList() {
      return $this->sendRequest('getMessagesList');
    }

/**
 * �����-������ ��� ������� sendSms
 * $message_id - ID ���������� ���������
 * $phone - ����� �������� � ������� 375291234567
 */
    public function sendSms($message_id, $phone) {
      $params['message_id'] = (integer)$message_id;
      $params['phone'] = $phone;
      return $this->sendRequest('sendSms', $params);
    }

/**
 * �����-������ ��� ������� checkSMS
 * $sms_id - ID ������������� SMS
 */
    public function checkSMS($sms_id) {
      $params['sms_id'] = (integer)$sms_id;
      return $this->sendRequest('checkSMS', $params);
    }

/**
 * �����-������ ��� ������� createPasswordObject
 * $type_id - ��� ������������ ������� ������, ����� ��������� �������� letters, numbers � both
 * $len - ����� ������������ ������� ������, ����� ����� �� 1 �� 16
 */
    public function createPasswordObject($type_id, $len) {
      $params['type_id'] = $type_id;
      $params['len'] = (integer)$len;
      return $this->sendRequest('createPasswordObject', $params);
    }

/**
 * �����-������ ��� ������� editPasswordObject
 * $password_object_id - ID ���������� ������� ������
 * $type_id - ��� ������������ ������� ������, ����� ��������� �������� letters, numbers � both
 * $len - ����� ������������ ������� ������, ����� ����� �� 1 �� 16
 */
    public function editPasswordObject($password_object_id, $type_id, $len) {
      $params['id'] = (integer)$password_object_id;
      $params['type_id'] = $type_id;
      $params['len'] = (integer)$len;
      return $this->sendRequest('editPasswordObject', $params);
    }

/**
 * �����-������ ��� ������� deletePasswordObject
 * $password_object_id - ID ���������� ������� ������
 */
    public function deletePasswordObject($password_object_id) {
      $params['id'] = (integer)$password_object_id;
      return $this->sendRequest('deletePasswordObject', $params);
    }

/**
 * �����-������ ��� ������� getPasswordObjects
 */
    public function getPasswordObjects() {
      return $this->sendRequest('getPasswordObjects');
    }

/**
 * �����-������ ��� ������� getPasswordObject
 * $password_object_id - ID ���������� ������� ������
 */
    public function getPasswordObject($password_object_id) {
      $params['id'] = (integer)$password_object_id;
      return $this->sendRequest('getPasswordObject', $params);
    }

/**
 * �����-������ ��� ������� sendSmsMessageWithCode
 * $message - ����� ������������ ���������
 * $password_object_id - ID ���������� ������� ������
 * $phone - ����� �������� � ������� 375291234567
 * $alphaname_id - ID �����-�����, �������������� ��������
 */
    public function sendSmsMessageWithCode($message, $password_object_id, $phone, $alphaname_id=0) {
      $params['message'] = $message;
      $params['password_object_id'] = (integer)$password_object_id;
      $params['phone'] = $phone;
      if (!empty($alphaname_id))
        $params['alphaname_id'] = (integer)$alphaname_id;
      return $this->sendRequest('sendSmsMessageWithCode', $params);
    }

  }
?>
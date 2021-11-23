<?php

namespace App\Helper;

use App\Model\ResponseObject;
use App\Exception\ValidationException;

class ResponseHelper {
    private $response;

    public function __construct() {
        $this->response = new ResponseObject();
    }

    public function getResponse($data = []) {
        $this->response->status = 200;
        $this->response->statusText = 'success';
        $this->response->message = '';
        $this->response->data = $data;
        return $this->response; 
    }
    
    public function getExceptionResponse($e) {
        $this->response->status = 400;
        $this->response->statusText = 'error';
        $this->response->message = $e->getMessage();
        $this->response->data = [];
        return $this->response; 
    }
}
<?php

namespace App\Helper;


class ResponseApi
{
    public $data = [];

    public function __construct($args)
    {
        $this->data = $args;
    }

    /**
     * @param $message pesan response
     * @return $this
     */
    public function message($message)
    {
        $this->data['message'] = $message;
        return $this;
    }

    /**
     * @param $data
     * @return $this
     * setter data response
     */
    public function data($data)
    {
        $this->data['data'] = $data;
        return $this;
    }

    /**
     * @param $info
     * @return $this
     * setter info tambahan untuk response, berisi apapun untuk menjelaskan response
     * baik error atau pun success, ini bersifat nullable
     */
    public function info($info)
    {
        $this->data['info'] = $info;
        return $this;
    }

    /**
     * @param $error
     * @return ResponseApiInterface
     * setter untuk message error yang terjadi.
     */
    public function error($error)
    {
        $this->data['error'] = $error;
        return $this;
    }

    /**
     * @param $status
     * @return mixed
     * setter status response , number response
     */
    public function setStatus($status)
    {
        return  $this->data['status'] = $status;
    }

    /**
     * @return mixed
     * get error yang sudah di set.
     */
    public function getError()
    {
        return  $this->data['error'];
    }

    /**
     * @return mixed
     * get pesan yang sudah di set
     */
    public function getMessage()
    {
        return  $this->data['message'];
    }

    /**
     * @return mixed
     * get data yang sudah di set
     */
    public function getData()
    {
        return  $this->data['data'];
    }

    /**
     * @return mixed
     * get info yang sudah di set
     */
    public function getInfo()
    {
        return  $this->data['info'];
    }

    /**
     * @return mixed
     * get status response
     * nomor status response.
     */
    public function getStatus()
    {
        return  $this->data['status'];
    }


    /**
     * @return array
     * mengembalikan response dalam bentuk array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * menegmbalikan response dalam bentuk json response laravel
     */
    public function json()
    {
        $status = $this->getStatus();
        $statusBol = $status != 200 && $status != 201 ? false : true;
        $this->setStatus($statusBol);
        return response()->json($this->toArray(), $status);
    }

    public static function statusFatalError(): ResponseApi
    {
        return new ResponseApi([
            'error' => 'A fatal error has occurred.',
            'status' => 500,
        ]);
    }

    public static function statusValidateError(): ResponseApi
    {
        return new ResponseApi([
            'error' => 'Validation error.',
            'status' => 402
        ]);
    }

    public static function statusQueryError(): ResponseApi
    {
        return new ResponseApi([
            'error' => 'query error',
            'status' => 401,
        ]);
    }

    public static function statusUniversalError(): ResponseApi
    {
        return new ResponseApi([
            'error' => 'error invalid scema',
            'status' => 403,
        ]);
    }

    public static function statusSuccessCreated(): ResponseApi
    {
        return new ResponseApi([
            'status' => 201,
            'message' => 'Resource created successfully.',
        ]);
    }

    public static function statusSuccess(): ResponseApi
    {
        return new ResponseApi([
            'status' => 200,
            'message' => 'Request completed successfully.',
        ]);
    }

    public static function statusDefault(): ResponseApi
    {
        return new ResponseApi([
            'status' => 203,
            'message' => 'unknown',
        ]);
    }
}

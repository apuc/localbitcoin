<?php
namespace frontend\components;


class LocalBitcoinsDto
{

    public $error = '';
    public $params = [];
    public $query = null;
    public $data = null;

    public function hasResult(): bool
    {
        return (bool)!empty($this->data) && empty($this->errors);
    }

}
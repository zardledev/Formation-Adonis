<?php
require_once __DIR__ . '/../BaseModel.php';

class UsersModel extends BaseModel
{
    public ?int $user_id;
    public string $user_name;
    public string $user_password;

    public function __construct(?int $user_id = null, string $user_name = '', string $user_password = '')
    {
        parent::__construct();
        $this->user_id = $user_id;
        $this->user_name = $user_name;
        $this->user_password = $user_password;
    }
}

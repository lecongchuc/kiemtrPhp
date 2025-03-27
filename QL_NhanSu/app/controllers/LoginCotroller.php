<?php
require_once('app/models/UserModel.php');
class LoginController
{
    private $userModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->userModel = new UserModel($this->db);
    }

    public function index()
    {
        include 'app/views/login/login.php';
    }
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? null;

            $result = $this->userModel->getUserByUserName($username);

            if (is_array($result)) {
                $errors = $result;
                include 'app/views/login/login.php';
            } elseif ($result->password == $password) {
                header('Location: /manguonmo/QL_NhanSu/NhanVien');
            } else {
                $errors = "Tài khoản hoặc mật khẩu không đúng!";
                include 'app/views/login/login.php';
            }
        }
    }
}

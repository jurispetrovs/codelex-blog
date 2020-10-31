<?php

namespace App\Controllers;

use App\Models\User;
use Respect\Validation\Validator;

class RegisterController
{
    public function __construct()
    {
        if (isset($_SESSION['auth_id'])) {
            header('Location: /');
        }
    }

    public function index()
    {
        $referredBy = $_GET['r'] ?? null;

        return require_once __DIR__ . '/../Views/RegisterIndexView.php';
    }

    public function register()
    {
        $validEmail = Validator::email()->validate($_POST['email']);
        $validName = $_POST['name'] !== '';
        $validPassword = $_POST['password'] !== '' && $_POST['password_confirmation'] === $_POST['password'];

        if ($validEmail && $validName && $validPassword) {

            $referredBy = null;

            if (isset($_GET['r'])) {
                $referredBy = query()
                    ->select('id')
                    ->from('users')
                    ->where('referral_code = ?')
                    ->setParameter(0, $_GET['r'])
                    ->execute()
                    ->fetchAssociative();
            }

            $user = User::create($_POST, $referredBy['id']);

            $query = query();
            $query->insert('users')
                ->values([
                    'name' => ':name',
                    'email' => ':email',
                    'password' => ':password',
                    'referral_code' => ':referralCode',
                    'referred_by' => ':referredBy'
                ])
                ->setParameters($user->toArray())
                ->execute();

            $_SESSION['auth_id'] = (int)$query->getConnection()->lastInsertId();

            return header('Location: /');
        }

        return header('Location: /register');
    }
}
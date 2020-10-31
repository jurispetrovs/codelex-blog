<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;

class User
{
    private string $name;
    private string $email;
    private string $password;
    private string $referralCode;
    private ?string $referredBy;
    private ?int $id;

    public function __construct(
        string $name,
        string $email,
        string $password,
        string $referralCode,
        ?string $referredBy = null,
        ?int $id = null
    )
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->referralCode = $referralCode;
        $this->referredBy = $referredBy;
        $this->id = $id;
    }

    public static function create(array $data, string $referredBy = null): User
    {
        return new self(
            $data['name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            Uuid::uuid4()->toString(),
            $referredBy
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'referralCode' => $this->referralCode,
            'referredBy' => $this->referredBy
        ];
    }
}
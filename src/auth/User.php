<?php

namespace iutnc\deefy\auth;

class User
{
    private int $id;
    private string $email;
    private string $password;
    private int $role;

    public function __construct($id,$email, $password, $role)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
    public function getRole(): int
    {
        return $this->role;
    }
}
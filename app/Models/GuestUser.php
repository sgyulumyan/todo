<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use ArrayAccess;

class GuestUser implements Authenticatable, ArrayAccess
{
    protected array $attributes = [
        'id' => 0,
        'name' => 'Guest',
        'email' => 'guest@example.com',
        'is_admin' => false,
    ];

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return 0;
    }

    public function getAuthPassword()
    {
        return null;
    }

    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value)
    {
        // Ничего не делаем
    }

    public function getRememberTokenName()
    {
        return null;
    }

    public function getAuthPasswordName()
    {
        return 'password';
    }

    // Позволяет обращаться к атрибутам как к свойствам объекта
    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }

    // Добавляем поддержку метода getAttribute()
    public function getAttribute($key)
    {
        return $this->attributes[$key] ?? null;
    }

    // Реализация интерфейса ArrayAccess
    public function offsetExists($offset): bool
    {
        return isset($this->attributes[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return $this->attributes[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        $this->attributes[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->attributes[$offset]);
    }
}


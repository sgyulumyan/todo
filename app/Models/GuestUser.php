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
        
    }

    public function getRememberTokenName()
    {
        return null;
    }

    public function getAuthPasswordName()
    {
        return 'password';
    }

    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function getAttribute($key)
    {
        return $this->attributes[$key] ?? null;
    }

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


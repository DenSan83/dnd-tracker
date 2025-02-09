<?php

namespace app\enum;

enum Role
{
    case Admin;
    case DM;
    case User;
    case NPC;

    public static function fromKey(string $key): self
    {
        return match($key) {
            'admin' => self::Admin,
            'dm' => self::DM,
            'user' => self::User,
            //'npc' => self::NPC,
            default => self::NPC
        };
    }

    public static function isAdmin(string $roleKey): string
    {
        $role = self::fromKey($roleKey);
        return $role === self::Admin;
    }

    public static function isDM(string $roleKey): string
    {
        $role = self::fromKey($roleKey);
        return $role === self::DM;
    }

    public static function isNpc(string $roleKey): string
    {
        $role = self::fromKey($roleKey);
        return $role === self::NPC;
    }

    public function getDescription(): string
    {
        return match($this) {
            self::Admin => 'admin',
            self::DM => 'dm',
            self::User => 'user',
            self::NPC => 'npc',
        };
    }

    public function hasAdminAccess(): bool
    {
        return $this === self::Admin;
    }
}
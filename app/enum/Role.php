<?php

namespace app\enum;

enum Role: string
{
    case Admin = 'admin';
    case DM = 'dm';
    case User = 'user';
    case NPC = 'npc';
}
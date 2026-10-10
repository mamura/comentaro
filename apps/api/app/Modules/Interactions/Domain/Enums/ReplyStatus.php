<?php

namespace App\Modules\Interactions\Domain\Enums;

enum ReplyStatus: string
{
    case NotReplied = 'not_replied';
    case Draft = 'draft';
    case Sending = 'sending';
    case Replied = 'replied';
    case SendFailed = 'send_failed';
    case Unavailable = 'unavailable';
}

<?php

namespace App\Modules\Connections\Domain\Enums;

enum IntegrationStatus: string
{
    case Draft = 'draft';
    case AccessRequested = 'access_requested';
    case AwaitingApproval = 'awaiting_approval';
    case Activating = 'activating';
    case Active = 'active';
    case AuthorizationRevoked = 'authorization_revoked';
    case ConnectionFailed = 'connection_failed';
    case Disconnected = 'disconnected';
}

<?php

namespace App\Modules\Interactions\Domain\Enums;

enum ProcessingStatus: string
{
    case Received = 'received';
    case Analyzing = 'analyzing';
    case Available = 'available';
    case ProcessingFailed = 'processing_failed';
}

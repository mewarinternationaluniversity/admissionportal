<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self SUBMITTED()
 * @method static self PROCESSING()
 * @method static self APPROVED()
 * @method static self REJECTED()
 */

 final class ApplicationStatusEnum extends Enum {}
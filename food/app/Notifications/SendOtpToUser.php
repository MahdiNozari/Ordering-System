<?php

namespace App\Notifications; // ✅ must match "app/Notifications" folder

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Ghasedak\DataTransferObjects\Request\InputDTO;
use Ghasedak\DataTransferObjects\Request\ReceptorDTO;
use Ghasedaksms\GhasedaksmsLaravel\Message\GhasedaksmsVerifyLookUp;
use Ghasedaksms\GhasedaksmsLaravel\Notification\GhasedaksmsBaseNotification;

class SendOtpToUser extends GhasedaksmsBaseNotification
{
    use Queueable;

    protected $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function toGhasedaksms($notifiable): GhasedaksmsVerifyLookUp
    {
        $message = new GhasedaksmsVerifyLookUp();
        $message->setSendDate(Carbon::now());
        $message->setReceptors([new ReceptorDTO($notifiable->phone, 'client referenceId')]);
        $message->setTemplateName('Ghasedak');
        $message->setInputs([new InputDTO('code', $this->otp)]);
        return $message;
    }
}

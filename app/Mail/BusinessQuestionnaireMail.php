<?php

namespace App\Mail;

use App\Models\BusinessQuestionnaire;
use Illuminate\Mail\Mailable;

class BusinessQuestionnaireMail extends Mailable
{
    public $questionnaire;

    /**
     * Create a new message instance.
     */
    public function __construct(BusinessQuestionnaire $questionnaire)
    {
        $this->questionnaire = $questionnaire;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Business Questionnaire Submission')
                    ->view('emails.business_questionnaire', [
                        'questionnaire' => $this->questionnaire
                    ]);
    }
}

<?php

namespace App\Models;

use App\Mail\FirstJobPostingMail;
use Illuminate\Database\Eloquent\Model;
use App\Models\JobOpening;
use App\Services\GmailEmailService;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Foundation\Auth\User;

class Employer extends Model
{
    public function getJobOpenings($user_id)
    {
        return JobOpening::where('user_id', $user_id)->get();
    }

    public function storeJobOpening($userId, $data)
    {
        $jobOpening = new JobOpening();
        $jobOpening->user_id = $userId;
        $jobOpening->title = $data['title'];
        $jobOpening->description = $data['description'];
        $jobOpening->save();

        $this->isFirstJobPost($userId);
    }

    public function isFirstJobPost($userId)
    {
        $user = User::find($userId); // Ensure the user exists

        $jobCount = JobOpening::where('user_id', $user->id)->count();

        // if ($jobCount === 1) {
            // This is the first job post for the employer. Please send an email notification to the admin.
            $this->sendFirstJobPostNotification($userId);
        // }
    }

    public function sendFirstJobPostNotification($userId)
    {
        $mailer = new GmailEmailService();

        $to = 'rm.abales.abao@gmail.com';

        $mailer->send(
            $to,
            'New Employer Job Post',
            new FirstJobPostingMail('Congratulations on Your First Job Posting!', $userId)
        );
        
    }
        
}

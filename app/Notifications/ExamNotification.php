<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExamNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private $exam)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('New Exam Notification: '.$this->exam->name)
                    ->greeting('Hello There,')
                    ->line("We are pleased to inform you that your teacher, ".$this->exam->user->name.", has added a new exam on our platform. Below are the details of the exam:")
                    ->line("Exam Name: ".$this->exam->name)
                    ->line("Course: ".$this->exam->course->name)
                    ->line("Exam Date: ".Carbon::parse($this->exam->exam_date)->format('d M Y'))
                    ->action('View Exam Details', route('singleCourse', $this->exam->course_id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

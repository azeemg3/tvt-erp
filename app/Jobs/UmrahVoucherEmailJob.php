<?php

namespace App\Jobs;

use App\Mail\UmrahVouhcerEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Storage;
ini_set('max_execution_time', '0');

class UmrahVoucherEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data["email"] = "azeemkhalidg3@gmail.com";
        $data["title"] = "From uotrips.com";
        $data["body"] = "This is Demo";
        $files = [
            Storage::get('public/umrah_voucher/invoice_14.pdf'),
        ];
        $email=new UmrahVouhcerEmail();
//        Mail::to('azeemkhalidg3@gmail.com')->send($email);
        Mail::send('emails.umrahVouhcerEmail', $data, function($message)use($data, $files) {
            $message->to($data["email"], $data["email"])
                ->subject($data["title"]);

            foreach ($files as $file){
                $message->attach($file);
            }
        });
    }
}

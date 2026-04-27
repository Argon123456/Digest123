<?php
namespace App\Http\Controllers;

//use App\Attachment;
use App\Log;
use App\Mail\DigestMail;
use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;



class EmailController extends Controller
{

    public function send(Request $request)
    {
        $emailContent = $request->email;
        $subject = $request->subject;
        $list = $request->list;
        $digest_type_id = $request->digest_type_id;
        //$emails = ['aliaksandraua@gmail.com','aliaksandrau@live.com','aliaksei.aliaksandrau@mail.ru','a.gladkiy@vds.by','a.vasiliev@vds.by'];
/*        Mail::send(new DigestMail($emailContent) ,function($message) use ($emails, $subject) {
            $message
                ->from('news@vds.by', 'Компания VDS')
                ->subject($subject);
            $message->to($emails);
        });*/

        $subscription = Subscription::with('contacts')->where('id',$list)->firstOrFail();

        $emails = [];

/*        foreach ($subscription->contacts as $c){
            $emails[] = $c->email;
        }*/

/*        $result = Mail::send('emails.digest', ['html' => $emailContent], function($message) use ($emails, $subject)
        {
            $message->to('news@vds.by')
                ->from('news@vds.by', 'Компания VDS')
                ->bcc($emails)
                ->subject($subject);
        });*/
        //$emails[0] = 'qefwwefqfewqefqw';
        foreach ($subscription->contacts as $c) {
            $log = new Log();
            $log->email = $c->email;
            $log->subject = $subject;
            $log->html = $emailContent;
            $log->contact_id = $c->id;
            $log->subscription_id = $list;
            $log->digest_type_id = $digest_type_id;
            $log->status = 'created';
            $log->save();

            try {
                $emailContentWithTracking = str_replace('digest.vds.group/tracker','digest.by/tracker?id='.$log->id, $emailContent);
                $email = new DigestMail($emailContentWithTracking);
                $email->subject($subject);
                $result = Mail::to($c->email)/*->bcc('news@vds.by')*/->send( $email );

                $log->status = 'ok';
                $log->save();
                //echo $result;
            } catch (\Exception $e) {
                $log->status = 'error';
                $log->error = $e->getMessage();
                $log->save();
            }
        }
        
        return response()->json(array('email' => $emailContent), 200);
    }

}

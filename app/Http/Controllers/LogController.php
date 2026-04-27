<?php


namespace App\Http\Controllers;

use App\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{

    public function index()
    {
        return view('logs.show');
    }

    public function all()
    {
        //$emails = //Log:://select('id','email','subject','status','error','created_at','opened','IF (updated_at = created_at , "", updated_at )')
        $emails = DB::table('logs')//select('id','email','subject','status','error','created_at','opened','IF (updated_at = created_at , "", updated_at )')
            ->selectRaw('id, email, subject, status, error,created_at, opened, IF ( opened = 0 , "", updated_at ) as updated_at')
            ->orderBy('created_at', 'desc')
            ->take(500)->get();
        return $emails;
    }

    public function iframe(Log $log)
    {
        //echo $log;
        return $log->html;
    }

    public function groupByDigests()
    {
        return view('logs.digests');
    }

    public function digestsJson(Request $request)
    {
        $r = $request->all();

        //$begin = getdate($r['firstDate']);
        $begin = new \DateTime();
        $begin->setTimestamp($r['firstDate']);
        $begin->setTime(0, 0, 0);
        //$end = getDate($r['lastDate']);
        $end = new \DateTime();
        $end->setTimestamp($r['lastDate']);
        $end->setTime(23, 59, 59);

        $logs = DB::table('logs')
            ->select(DB::raw('count(*) as total_count, sum(opened = 1) as opened_count, digest_types.name as name, DATE(logs.created_at) as sended_at'))
            //->join('contacts', 'logs.contact_id', '=', 'contacts.id')
            ->join('digest_types', 'logs.digest_type_id', '=', 'digest_types.id')
            ->whereDate('logs.created_at', '>=', $begin)
            ->whereDate('logs.created_at', '<=', $end)
            ->whereRaw('logs.contact_id not in (
                select contacts.id
                from contacts join contact_subscription on contacts.id = contact_subscription.contact_id
                where contact_subscription.subscription_id in (1)
                )')
            ->groupByRaw('digest_types.name, DATE(logs.created_at)')
            ->orderByRaw('DATE(logs.created_at) DESC')
            ->get();

        return $logs;
    }

    public function groupByContacts()
    {
        return view('logs.contacts');
    }

    public function contactsJson(Request $request)
    {
        $r = $request->all();

        //$begin = getdate($r['firstDate']);
        $begin = new \DateTime();
        $begin->setTimestamp($r['firstDate']);
        $begin->setTime(0, 0, 0);
        //$end = getDate($r['lastDate']);
        $end = new \DateTime();
        $end->setTimestamp($r['lastDate']);
        $end->setTime(23, 59, 59);

        $logs = DB::table('logs')
            ->select(DB::raw('count(*) as total_count, 
                sum(opened = 1) as opened_count, 
                digest_types.name as digest_name, 
                DATE(logs.created_at) as sended_at,
                contacts.name as contact_name,
                companies.name as company_name'
            ))
            ->join('digest_types', 'logs.digest_type_id', '=', 'digest_types.id')
            ->join('contacts', 'logs.contact_id', '=', 'contacts.id')
            ->join('companies', 'contacts.company_id', '=', 'companies.id')
            ->whereDate('logs.created_at', '>=', $begin)
            ->whereDate('logs.created_at', '<=', $end)
            ->whereRaw('contacts.id not in (
                select contacts.id
                from contacts join contact_subscription on contacts.id = contact_subscription.contact_id
                where contact_subscription.subscription_id in (1)
                )')
            ->groupByRaw('contacts.name, companies.name, digest_types.name, DATE(logs.created_at)')
            ->orderByRaw('contacts.name, digest_types.name')
            ->get();

        return $logs;
    }
}

<?php
namespace App\Repository;

use App\job_post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class job_posts
{
    CONST CACHE_KEY = 'JOB_POSTS';


public function all($request){
   $uid = $request->user_id; //else  $uid = Auth::id();

    $cacheKey = "post_job_all.{ $request->status . $request->searchfilter }";
    $key = $this->getCacheKey($cacheKey);

    //dd($cacheKey);
    $query = job_post::with(['projectInfo','company','countryName', 'postby', 'placement_company', 'applied_jobs', 'jobEmploymentStatus'])->where('deleteitem','0')
        ->withCount(['job_compliances as total_compliances'])
        ->withCount(['jobQuestion as total_jobQuestion'])
        ->withCount(['jobs_candidate as total_listed'])->withCount(['jobs_candidate as total_interview' => function ($q) {
            $q->where('interview', '1');
        }])->withCount(['interview_call as phone_call' => function ($q) {
            $q->where('interview_system_id', '3');
        }])->withCount(['send_cv_toclient as total_send_cv']);


    if(!empty($request->search_field) && !empty($request->search_keyword)){
        if($request->search_field == 'country'){
            $query = $query->whereHas('countryName',function($q) use($request){
                $q->where('country', 'LIKE' , "%". $request->search_keyword ."%");
            });
        }else
            if($request->search_field == 'client'){
                $query = $query->whereHas('placement_company',function($q) use($request){
                  $q->where('company_name', 'LIKE' , "%". $request->search_keyword ."%");
                });
            }else
        $query = $query->where($request->search_field, 'LIKE' , "%". $request->search_keyword ."%");
    }



    if (isset($request->todate) && isset($request->fromdate)) {
        $todate = (isset($request->todate)) ? Carbon::createFromFormat('d/m/Y', $request->todate)->format('Y-m-d') : '';
        $fromdate = (isset($request->fromdate)) ? Carbon::createFromFormat('d/m/Y', $request->fromdate)->format('Y-m-d') : '';
        $query = $query->whereBetween('published_date', [$fromdate, $todate]);
    }elseif(isset($request->todate)) {
        $todate = (isset($request->todate)) ? Carbon::createFromFormat('d/m/Y', $request->todate)->format('Y-m-d') : '';
        $now = Carbon::now();
        $query = $query->whereBetween('published_date', [$now, $todate]);
    } elseif (isset($request->fromdate)) {
        $fromdate = (isset($request->fromdate)) ? Carbon::createFromFormat('d/m/Y', $request->fromdate)->format('Y-m-d') : '';
        $now = Carbon::now();
        $query = $query->whereBetween('published_date', [$fromdate, $now]);
    }

    if (isset($request->status)) {
        $query = $query->where('status', $request->status);
    }
    if (isset($request->job_id)) {
        $query = $query->where('job_id', $request->job_id);
    }

    if (empty($uid)) {
         //$userIds = app('App\Http\Controllers\adminControllers\adminController')->treeUserIDs($uid) ;
         $query =   $query  ; // ->whereIn('recruiter_id', $userIds);
    }
    elseif ($uid =='team') {
        $uid =Auth::id();
        $userIds = app('App\Http\Controllers\adminControllers\adminController')->treeUserIDs($uid) ;
        $query =   $query->whereIn('recruiter_id', $userIds);
    }
    elseif (!empty($uid) && $uid !='team') {
        $query =   $query->where('recruiter_id', $uid);
    }

    if (!empty($request->status)) {
        $query = $query->where('status', $request->status);
    }
    /*    $query->addSelect(DB::raw("*,(SELECT count(*) FROM agent_jobs_candidates WHERE agent_jobs_candidates.interview  =  1 AND agent_jobs_candidates.job_id= job_posts.job_id limit 1 ) as total_interview,
       (SELECT count(*)  FROM agent_jobs_candidates WHERE agent_jobs_candidates.listed  =  1 AND agent_jobs_candidates.job_id= job_posts.job_id limit 1 ) as total_listed "));
       */

    $query->with(['jobs_candidate.todolist' => function ($q) {
        $q->select('id', 'agent_jobs_candidate_id');
    }]);


    if ($request->searchfilter == 'Weekly') {
        $now = Carbon::now();
        $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');
        $query = $query->whereBetween('published_date', [$weekStartDate, $weekEndDate]);
    }


    if ($request->searchfilter == 'Monthly') {
        $currentMonth = date('m');
        $currentYear = date('Y');
        $query = $query->whereMonth('published_date', $currentMonth)->whereYear('published_date', $currentYear);
    }


    if ($request->searchfilter == 'ThreeMonths') {
        $now = Carbon::now();
        $EndDate = $now->endOfMonth()->toDateTimeString(); //$now->startOfMonth()->format('Y-m-d');
        $StartDate = $now->startOfMonth()->subMonth(3)->format('Y-m-d');
        $query = $query->whereBetween('published_date', [$StartDate, $EndDate]);
    }


    if ($request->searchfilter == '6months') {
        $now = Carbon::now();
        $EndDate = $now->endOfMonth()->format('Y-m-d');
        $StartDate = $now->startOfMonth()->subMonth(6)->format('Y-m-d');
        $query = $query->whereBetween('published_date', [$StartDate, $EndDate]);
    }

    if ($request->searchfilter == 'Yearly') {
        $currentYear = date('Y');
        $query = $query->whereYear('published_date', $currentYear);
    }



//////////////////expireJobfilter/////

  /*  if ($request->expireJobfilter == 'Weekly') {
        $now = Carbon::now();
        $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');
        $query = $query->whereBetween('application_deadline', [$weekStartDate, $weekEndDate]);
    }*/

    if ($request->expireJobfilter == 'Weekly') {
        $now = Carbon::now();
        $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
        $weekEndDate = $now->addWeeks(1)->format('Y-m-d H:i');
        $query = $query->whereBetween('application_deadline', [$weekStartDate, $weekEndDate]);
    }
/*    if ($request->expireJobfilter == '1 Month') {
        $currentMonth = date('m');
        $currentYear = date('Y');
        $query = $query->whereMonth('application_deadline', $currentMonth)->whereYear('application_deadline', $currentYear);
    }*/
    if ($request->expireJobfilter == '1 Month') {
        $now = Carbon::now();
       $StartDate =  $now->endOfMonth()->toDateTimeString(); //$now->startOfMonth()->format('Y-m-d');
        $EndDate =$now->startOfMonth()->addMonth(1)->format('Y-m-d');
        $query = $query->whereBetween('application_deadline', [$StartDate, $EndDate]);
    }

    if ($request->expireJobfilter == '2 Months') {
        $now = Carbon::now();
       $StartDate =$now->endOfMonth()->toDateTimeString(); //$now->startOfMonth()->format('Y-m-d');
        $EndDate =$now->startOfMonth()->addMonths(2)->format('Y-m-d');
        $query = $query->whereBetween('application_deadline', [$StartDate, $EndDate]);
    }

    if ($request->expireJobfilter == '3 Months') {
        $now = Carbon::now();
        $StartDate =$now->endOfMonth()->toDateTimeString(); //$now->startOfMonth()->format('Y-m-d');
        $EndDate = $now->startOfMonth()->addMonths(3)->format('Y-m-d');

        $query = $query->whereBetween('application_deadline', [$StartDate, $EndDate]);
    }








    $keywordapplication_deadline = (isset($request->application_deadline)) ? Carbon::createFromFormat('d/m/Y', $request->application_deadline)->format('Y-m-d') : '';

    if (!empty($keywordapplication_deadline)) {
        $query = $query->whereDate('application_deadline', $keywordapplication_deadline);
    }


    $total=$query->count();
    $query=$query->skip($request->start)->take($request->limit);

 $Result = cache()->remember($cacheKey, Carbon::now()->addSeconds(1), function () use($query){
      return $query->latest()->get();
  });


    $data['totaldata'] =$total;
    $data['result'] =  $Result;
    return  $data;

}



    public function getCacheKey($key){
        $key = strtoupper($key);
        return self::CACHE_KEY .".$key";
    }

}

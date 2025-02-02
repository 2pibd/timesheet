<?php
namespace App\Repository;

use App\candidate_personal_info;
use Auth;
use Carbon\Carbon;
use DB;

class cv_boxs
{
    CONST CACHE_KEY = 'CV_BOXS';


    public function all($request)
    {
        $cacheKey = "cv_box_all.{ $request->status . $request->searchfilter }";
        $key = $this->getCacheKey($cacheKey);

        $query = candidate_personal_info::latest('candidate_personal_infos.created_at')->where('deleteitem', '0');

        if (isset($request->section) && $request->section == 'favoriteCandidate') {
            $query = $query->whereHas('favoritecv', function ($q) {
                $q->where('user_id', Auth::id())->where('favorite', '1');
            });
        }

        $query = $query->with([
            'candidateAcademicSummary.eduLevelDetails',
            'addressDefault',
            'Specialization',
            'languageProficiency',
            'profile' => function ($q) {
                $q->select('id', 'name_title', 'name', 'middle_name', 'last_name');
            }
        ])
            ->withCount([
                'job_apply as shortlist' => function ($q) {
                    $q->whereHas('agent_copy');
                },
                'job_apply as total_interview' => function ($q) {
                    $q->whereHas('agent_copy', function ($qq) {
                        $qq->where('interview', '1');
                    });
                },
                'vfiles as cvs' => function ($q2) {
                    $q2->where('upload_type', 'cv');
                },
                'vfiles as videos' => function ($q3) {
                    $q3->where('upload_type', 'video');
                },
                'job_apply as total_apply'
            ]);

        if (!isset($request->section)) {
            $uid = !empty($request->user_id) ? $request->user_id : Auth::id();
        } else {
            $uid = '';
        }

        if (!empty($request->search_field)) {
            if ($request->search_field == 'test' && !empty($request->search_keyword)) {
                $query = $query->whereHas('Specialization', function ($q) use ($request) {
                    $q->where('skills', 'LIKE', "%" . $request->search_keyword . "%");
                });
            } elseif ($request->search_field == 'candidateAcademicSummary'  && !empty($request->search_keyword)) {
                $query = $query->whereHas('Specialization', function ($q) use ($request) {
                    $q->where('majorGroup', 'LIKE', "%" . $request->search_keyword . "%");
                });
            } elseif ($request->search_field == 'preferred_areas' && !empty($request->search_keyword)) {
                $query = $query->whereHas('relevantInformation.industryinfo', function ($q) use ($request) {
                    $q->where('industry', 'LIKE', "%" . $request->search_keyword . "%");
                });
            } elseif ($request->search_field == 'total_apply') {
                $query = $query->havingRaw('total_apply = ?', [$request->search_keyword]);
            } elseif ($request->search_field == 'shortlist') {
                $query = $query->havingRaw('shortlist = ?', [$request->search_keyword]);
            } elseif ($request->search_field == 'total_interview') {
                $query = $query->havingRaw('total_interview = ?', [$request->search_keyword]);
            }


             elseif ($request->search_field == 'experience') {
                $expreance_from = $request->experience_from * 365;
                $expreance_to = $request->experience_to * 365;

                $query = $query->join('candidate_employment_histories', 'candidate_personal_infos.rtoken', '=', 'candidate_employment_histories.rtoken')
                    ->selectRaw('candidate_personal_infos.*,
                      SUM(DATEDIFF(
                    IFNULL(NULLIF(candidate_employment_histories.emp_prd_to, ""), CURDATE()),
                    STR_TO_DATE(candidate_employment_histories.emp_prd_from, "%Y-%m-%d")
                )) as total_experience_duration_days')
                 ->groupBy('candidate_personal_infos.id')
                   ->havingRaw('total_experience_duration_days >= '.$expreance_from )
                    ->havingRaw('total_experience_duration_days <= '.$expreance_to );
              // dd($expreance_to);
            } elseif ($request->search_field == 'name') {
                $query = $query->WhereRaw('CONCAT_WS(" ", trim(name_title), trim(first_name), trim(middle_name), trim(last_name)) like "%' . $request->search_keyword  . '%"');
            } else {
                $query = $query->where($request->search_field, 'LIKE', "%" . $request->search_keyword . "%");
            }
        }


        if (!empty($request->filterBySkill)) {
            $query = $query->where(function ($subQuery) use ($request) {
                foreach ($request->filterBySkill as $key => $item) {
                    $subQuery->orWhereHas('preferredAreas', function ($q1) use ($item) {
                        $q1->whereRaw("FIND_IN_SET('$item', job_cat_func)<>0");
                    });
                }
            });
        }

        if (!empty($request->filterByDegree)) {
            $query->withCount(['candidateAcademicSummary as totalEdu' => function ($q2) use ($request) {
                $q2->whereIn('eduLevel', $request->filterByDegree);
            }]);
        }

        if (!empty($request->gender)) {
            foreach ($request->gender as $item) {
                $gender[] = $item['value'];
            }
            $query = $query->whereIn('gender', $gender);
        }

        if (!empty($request->min_age)) {
            $max = $request->max_age;
            $min = $request->min_age;
            $minDate = Carbon::today()->subYears($max); // make sure to use Carbon\Carbon in the class
            $maxDate = Carbon::today()->subYears($min)->endOfDay();
            $query = $query->whereBetween('date_of_birth', [$minDate, $maxDate]);
        }

        if (isset($request->todate) && isset($request->fromdate)) {
            $todate = Carbon::createFromFormat('d/m/Y', $request->todate)->format('Y-m-d');
            $fromdate = Carbon::createFromFormat('d/m/Y', $request->fromdate)->format('Y-m-d');
            $query = $query->whereBetween('candidate_personal_infos.created_at', [$fromdate, $todate]);
        } elseif (isset($request->todate)) {
            $todate = Carbon::createFromFormat('d/m/Y', $request->todate)->format('Y-m-d');
            $now = Carbon::now();
            $query = $query->whereBetween('candidate_personal_infos.created_at', [$now, $todate]);
        } elseif (isset($request->fromdate)) {
            $fromdate = Carbon::createFromFormat('d/m/Y', $request->fromdate)->format('Y-m-d');
            $now = Carbon::now();
            $query = $query->whereBetween('candidate_personal_infos.created_at', [$fromdate, $now]);
        }

        if ($request->searchfilter == 'Weekly') {
            $now = Carbon::now();
            $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
            $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');
            $query = $query->whereBetween('candidate_personal_infos.created_at', [$weekStartDate, $weekEndDate]);
        } elseif ($request->searchfilter == 'Monthly') {
            $currentMonth = date('m');
            $currentYear = date('Y');
            $query = $query->whereMonth('candidate_personal_infos.created_at', $currentMonth)->whereYear('candidate_personal_infos.created_at', $currentYear);
        } elseif ($request->searchfilter == 'ThreeMonths') {
            $now = Carbon::now();
            $EndDate = $now->endOfMonth()->toDateTimeString();
            $StartDate = $now->startOfMonth()->subMonth(3)->format('Y-m-d');
            $query = $query->whereBetween('candidate_personal_infos.created_at', [$StartDate, $EndDate]);
        } elseif ($request->searchfilter == '6months') {
            $now = Carbon::now();
            $EndDate = $now->endOfMonth()->format('Y-m-d');
            $StartDate = $now->startOfMonth()->subMonth(6)->format('Y-m-d');
            $query = $query->whereBetween('candidate_personal_infos.created_at', [$StartDate, $EndDate]);
        } elseif ($request->searchfilter == 'Yearly') {
            $currentYear = date('Y');
            $query = $query->whereYear('candidate_personal_infos.created_at', $currentYear);
        }

        if ($request->lastloginfilter == 'Weekly') {
            $now = Carbon::now();
            $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
            $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');
            $query = $query->whereHasNot('lastlogin', function ($q) use ($weekStartDate, $weekEndDate, $request) {
                if ($request->lastYNlogin == 'Not') {
                    $q->whereNotBetween('login_time', [$weekStartDate, $weekEndDate]);
                } else {
                    $q->whereBetween('login_time', [$weekStartDate, $weekEndDate]);
                }
            });
        }

        if ($request->lastloginfilter >= 1) {
            $now = Carbon::now();
            $EndDate = $now->endOfMonth()->toDateTimeString();
            $StartDate = $now->startOfMonth()->subMonth($request->lastloginfilter)->format('Y-m-d');
            $query = $query->whereHas('lastlogin', function ($q) use ($StartDate, $EndDate) {
                $q->whereBetween('login_time', [$StartDate, $EndDate]);
            });
        }

        if ($request->user_id == '*' || isset($request->section)) {
            // No additional filtering needed
        } elseif ($request->user_id == 'team') {
            $uid = Auth::id();
            $userIds = app('App\Http\Controllers\adminControllers\adminController')->treeUserIDs($uid);
            $query = $query->whereIn('user_id', $userIds);
        } else {
            $query = $query->where('user_id', $uid);
        }
        $total=$query->count();
        $query = $query->skip($request->start)->take($request->limit);

        $Result = $query->get();

        $Result = cache()->remember($cacheKey, Carbon::now()->addSeconds(1), function () use ($Result) {
            return $Result;
        });

/*
  if (!empty($request->filterByDegree)) {
      $Result = $Result->filter(function ($value, $key) {
          return $value->totalEdu > 0;
      });


      $total=$Result->count();
  }*/
       // $total=$Result->count();

        $data['result'] =  $Result;
        $data['totaldata'] =$total;
        return  $data;

    }

    public function removeCommonWords($input)
    {
        $commonWords = array('a', 'able', 'about', 'above', 'abroad', 'according', 'accordingly', 'across', 'actually', 'adj', 'after', 'afterwards', 'again', 'against', 'ago', 'ahead', 'ain\'t', 'all', 'allow', 'allows', 'almost', 'alone', 'along', 'alongside', 'already', 'also', 'although', 'always', 'am', 'amid', 'amidst', 'among', 'amongst', 'an', 'and', 'another', 'any', 'anybody', 'anyhow', 'anyone', 'anything', 'anyway', 'anyways', 'anywhere', 'apart', 'appear', 'appreciate', 'appropriate', 'are', 'aren\'t', 'around', 'as', 'a\'s', 'aside', 'ask', 'asking', 'associated', 'at', 'available', 'away', 'awfully', 'b', 'back', 'backward', 'backwards', 'be', 'became', 'because', 'become', 'becomes', 'becoming', 'been', 'before', 'beforehand', 'begin', 'behind', 'being', 'believe', 'below', 'beside', 'besides', 'best', 'better', 'between', 'beyond', 'both', 'brief', 'but', 'by', 'c', 'came', 'can', 'cannot', 'cant', 'can\'t', 'caption', 'cause', 'causes', 'certain', 'certainly', 'changes', 'clearly', 'c\'mon', 'co', 'co.', 'com', 'come', 'comes', 'concerning', 'consequently', 'consider', 'considering', 'contain', 'containing', 'contains', 'corresponding', 'could', 'couldn\'t', 'course', 'c\'s', 'currently', 'd', 'dare', 'daren\'t', 'definitely', 'described', 'despite', 'did', 'didn\'t', 'different', 'directly', 'do', 'does', 'doesn\'t', 'doing', 'done', 'don\'t', 'down', 'downwards', 'during', 'e', 'each', 'edu', 'eg', 'eight', 'eighty', 'either', 'else', 'elsewhere', 'end', 'ending', 'enough', 'entirely', 'especially', 'et', 'etc', 'even', 'ever', 'evermore', 'every', 'everybody', 'everyone', 'everything', 'everywhere', 'ex', 'exactly', 'example', 'except', 'f', 'fairly', 'far', 'farther', 'few', 'fewer', 'fifth', 'first', 'five', 'followed', 'following', 'follows', 'for', 'forever', 'former', 'formerly', 'forth', 'forward', 'found', 'four', 'from', 'further', 'furthermore', 'g', 'get', 'gets', 'getting', 'given', 'gives', 'go', 'goes', 'going', 'gone', 'got', 'gotten', 'greetings', 'h', 'had', 'hadn\'t', 'half', 'happens', 'hardly', 'has', 'hasn\'t', 'have', 'haven\'t', 'having', 'he', 'he\'d', 'he\'ll', 'hello', 'help', 'hence', 'her', 'here', 'hereafter', 'hereby', 'herein', 'here\'s', 'hereupon', 'hers', 'herself', 'he\'s', 'hi', 'him', 'himself', 'his', 'hither', 'hopefully', 'how', 'howbeit', 'however', 'hundred', 'i', 'i\'d', 'ie', 'if', 'ignored', 'i\'ll', 'i\'m', 'immediate', 'in', 'inasmuch', 'inc', 'inc.', 'indeed', 'indicate', 'indicated', 'indicates', 'inner', 'inside', 'insofar', 'instead', 'into', 'inward', 'is', 'isn\'t', 'it', 'it\'d', 'it\'ll', 'its', 'it\'s', 'itself', 'i\'ve', 'j', 'just', 'k', 'keep', 'keeps', 'kept', 'know', 'known', 'knows', 'l', 'last', 'lately', 'later', 'latter', 'latterly', 'least', 'less', 'lest', 'let', 'let\'s', 'like', 'liked', 'likely', 'likewise', 'little', 'look', 'looking', 'looks', 'low', 'lower', 'ltd', 'm', 'made', 'mainly', 'make', 'makes', 'many', 'may', 'maybe', 'mayn\'t', 'me', 'mean', 'meantime', 'meanwhile', 'merely', 'might', 'mightn\'t', 'mine', 'minus', 'miss', 'more', 'moreover', 'most', 'mostly', 'mr', 'mrs', 'much', 'must', 'mustn\'t', 'my', 'myself', 'n', 'name', 'namely', 'nd', 'near', 'nearly', 'necessary', 'need', 'needn\'t', 'needs', 'neither', 'never', 'neverf', 'neverless', 'nevertheless', 'new', 'next', 'nine', 'ninety', 'no', 'nobody', 'non', 'none', 'nonetheless', 'noone', 'no-one', 'nor', 'normally', 'not', 'nothing', 'notwithstanding', 'novel', 'now', 'nowhere', 'o', 'obviously', 'of', 'off', 'often', 'oh', 'ok', 'okay', 'old', 'on', 'once', 'one', 'ones', 'one\'s', 'only', 'onto', 'opposite', 'or', 'other', 'others', 'otherwise', 'ought', 'oughtn\'t', 'our', 'ours', 'ourselves', 'out', 'outside', 'over', 'overall', 'own', 'p', 'particular', 'particularly', 'past', 'per', 'perhaps', 'placed', 'please', 'plus', 'possible', 'presumably', 'probably', 'provided', 'provides', 'q', 'que', 'quite', 'qv', 'r', 'rather', 'rd', 're', 'really', 'reasonably', 'recent', 'recently', 'regarding', 'regardless', 'regards', 'relatively', 'respectively', 'right', 'round', 's', 'said', 'same', 'saw', 'say', 'saying', 'says', 'second', 'secondly', 'see', 'seeing', 'seem', 'seemed', 'seeming', 'seems', 'seen', 'self', 'selves', 'sensible', 'sent', 'serious', 'seriously', 'seven', 'several', 'shall', 'shan\'t', 'she', 'she\'d', 'she\'ll', 'she\'s', 'should', 'shouldn\'t', 'since', 'six', 'so', 'some', 'somebody', 'someday', 'somehow', 'someone', 'something', 'sometime', 'sometimes', 'somewhat', 'somewhere', 'soon', 'sorry', 'specified', 'specify', 'specifying', 'still', 'sub', 'such', 'sup', 'sure', 't', 'take', 'taken', 'taking', 'tell', 'tends', 'th', 'than', 'thank', 'thanks', 'thanx', 'that', 'that\'ll', 'thats', 'that\'s', 'that\'ve', 'the', 'their', 'theirs', 'them', 'themselves', 'then', 'thence', 'there', 'thereafter', 'thereby', 'there\'d', 'therefore', 'therein', 'there\'ll', 'there\'re', 'theres', 'there\'s', 'thereupon', 'there\'ve', 'these', 'they', 'they\'d', 'they\'ll', 'they\'re', 'they\'ve', 'thing', 'things', 'think', 'third', 'thirty', 'this', 'thorough', 'thoroughly', 'those', 'though', 'three', 'through', 'throughout', 'thru', 'thus', 'till', 'to', 'together', 'too', 'took', 'toward', 'towards', 'tried', 'tries', 'truly', 'try', 'trying', 't\'s', 'twice', 'two', 'u', 'un', 'under', 'underneath', 'undoing', 'unfortunately', 'unless', 'unlike', 'unlikely', 'until', 'unto', 'up', 'upon', 'upwards', 'us', 'use', 'used', 'useful', 'uses', 'using', 'usually', 'v', 'value', 'various', 'versus', 'very', 'via', 'viz', 'vs', 'w', 'want', 'wants', 'was', 'wasn\'t', 'way', 'we', 'we\'d', 'welcome', 'well', 'we\'ll', 'went', 'were', 'we\'re', 'weren\'t', 'we\'ve', 'what', 'whatever', 'what\'ll', 'what\'s', 'what\'ve', 'when', 'whence', 'whenever', 'where', 'whereafter', 'whereas', 'whereby', 'wherein', 'where\'s', 'whereupon', 'wherever', 'whether', 'which', 'whichever', 'while', 'whilst', 'whither', 'who', 'who\'d', 'whoever', 'whole', 'who\'ll', 'whom', 'whomever', 'who\'s', 'whose', 'why', 'will', 'willing', 'wish', 'with', 'within', 'without', 'wonder', 'won\'t', 'would', 'wouldn\'t', 'x', 'y', 'yes', 'yet', 'you', 'you\'d', 'you\'ll', 'your', 'you\'re', 'yours', 'yourself', 'yourselves', 'you\'ve', 'z', 'zero');
        return preg_replace('/\b(' . implode('|', $commonWords) . ')\b/', '', $input);
    }


    public function getCacheKey($key)
    {
        $key = strtoupper($key);
        return self::CACHE_KEY . ".$key";
    }
}

?>

<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRecruitmentNewsRequest;
use App\Models\Campaign;
use App\Models\Interview;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecruitmentController extends Controller
{
    public function list_recruitment_news(Request $request)
    {
        $jobs = Job::orderByDesc('created_at')->get();
        foreach ($jobs as $job) {
            $job->campaign = Campaign::where("id", $job->campaign_id)->first();
            $job->application_count = $job->applications->count();
        }

        $campaign = $request->query('campaign-id') ? Campaign::findOrFail($request->query('campaign-id')) : null;

        if (!is_null($campaign)) {
            $jobs = $jobs->filter(function ($job) use ($campaign) {
                return $job->campaign->id === $campaign->id;
            });
        }

        $query = $campaign ? "?campaign-id=" . $campaign->id : "";

        return view('company.recruitment-news.index', [
            "role" => User::DISPLAYED_ROLE[Auth::user()->role],
            "breadcrumb_tabs" => ["Tin tuyển dụng" => ""],
            "jobs" => $jobs,
            "campaign" => $campaign,
            "query" => $query
        ]);
    }

    public function create(Request $request)
    {
        $campaigns = Campaign::all();

        $current_campaign = $request->query('campaign-id') ? Campaign::findOrFail($request->query('campaign-id')) : null;

        $query = $current_campaign ? "?campaign-id=" . $current_campaign->id : "";

        return view('company.recruitment-news.create', [
            "role" => User::DISPLAYED_ROLE[Auth::user()->role],
            "breadcrumb_tabs" => [
                "Tin tuyển dụng" => is_null($current_campaign) ? "/company/recruitment-news" : "/company/recruitment-news?campaign-id=" . $current_campaign->id,
                "Đăng tin tuyển dụng" => ""
            ],
            "campaigns" => $campaigns,
            "current_campaign" => $current_campaign,
            "query" => $query
        ]);
    }

    public function post_create(CreateRecruitmentNewsRequest $request)
    {
        $validated = $request->validated();

        $salary = "";

        if ($request->input('negotiable', 1) == 0) {
            $salary = "Thỏa thuận";
        } else {
            if ($request->input('min_salary') == "0") {
                $salary = "Lên đến " . $request->input('max_salary') . " triệu";
            } else {
                $salary = $request->input('min_salary') . " - " . $request->input('max_salary') . " triệu";
            }
        }

        $working_time = $validated['start_date'] . " - " . $validated['end_date'] . " (" . $validated['start_time'] . " - " . $validated['end_time'] . ")";

        DB::beginTransaction();

        try {
            Job::create([
                'campaign_id' => $validated['campaign_id'],
                'name' => $validated['name'],
                'employment_type' => $validated['employment_type'],
                'position' => $validated['position'],
                'salary' => $salary,
                'deadline' => $validated['deadline'],
                'description' => $validated['description'],
                'requirement' => $validated['requirement'],
                'benefit' => $validated['benefit'],
                'location' => $validated['location'],
                'workplace' => $validated['workplace'],
                'working_time' => $working_time
            ]);

            session()->flash('success', 'Đăng tin tuyển dụng thành công!');

            DB::commit();
        } catch (\Throwable $th) {
            throw $th;
            session()->flash('error', 'Có lỗi xảy ra');

            DB::rollBack();
        }

        return redirect('/company/recruitment-news' . $request->input('query'));
    }

    public function update($id, Request $request)
    {
        $job = Job::findOrFail($id);

        if ($job->salary != "Thỏa thuận") {
            if (str_contains($job->salary, " - ")) {
                $job->min_salary = explode(" ", $job->salary)[0];
                $job->max_salary = explode(" ", $job->salary)[2];
            } else {
                $job->min_salary = 0;
                $job->max_salary = explode(" ", $job->salary)[2];
            }
        }

        preg_match("/^(.*?) - (.*?) \((\d{2}:\d{2}) - (\d{2}:\d{2})\)$/", $job->working_time, $matches);

        $job->start_date = $matches[1];
        $job->end_date = $matches[2];
        $job->start_time = $matches[3];
        $job->end_time = $matches[4];

        $campaign = $request->query('campaign-id') ? Campaign::findOrFail($request->query('campaign-id')) : null;

        $query = $campaign ? "?campaign-id=" . $campaign->id : "";

        return view('company.recruitment-news.update', [
            "role" => User::DISPLAYED_ROLE[Auth::user()->role],
            "breadcrumb_tabs" => ["Tin tuyển dụng" => "/company/recruitment-news" . $query, "Cập nhật tin tuyển dụng" => ""],
            "job" => $job,
            "query" => $query
        ]);
    }

    public function post_update(CreateRecruitmentNewsRequest $request, $id)
    {
        $validated = $request->validated();

        $job = job::findOrFail($id);

        $salary = "";

        if ($request->input('negotiable', 1) == 0) {
            $salary = "Thỏa thuận";
        } else {
            if ($request->input('min_salary') == "0") {
                $salary = "Lên đến " . $request->input('max_salary') . " triệu";
            } else {
                $salary = $request->input('min_salary') . " - " . $request->input('max_salary') . " triệu";
            }
        }

        $working_time = $validated['start_date'] . " - " . $validated['end_date'] . " (" . $validated['start_time'] . " - " . $validated['end_time'] . ")";

        $job->name = !is_null($validated['name']) ? $validated['name'] : $job->name;
        $job->employment_type = !is_null($validated['employment_type']) ? $validated['employment_type'] : $job->employment_type;
        $job->position = !is_null($validated['position']) ? $validated['position'] : $job->position;
        $job->salary = $salary != "" ? $salary : $job->salary;
        $job->deadline = !is_null($validated['deadline']) ? $validated['deadline'] : $job->deadline;
        $job->description = !is_null($validated['description']) ? $validated['description'] : $job->description;
        $job->requirement = !is_null($validated['requirement']) ? $validated['requirement'] : $job->requirement;
        $job->benefit = !is_null($validated['benefit']) ? $validated['benefit'] : $job->benefit;
        $job->location = !is_null($validated['location']) ? $validated['location'] : $job->location;
        $job->workplace = !is_null($validated['workplace']) ? $validated['workplace'] : $job->location;
        $job->working_time = $working_time != "" ? $working_time : $job->working_time;

        $job->save();

        session()->flash('success', 'Cập nhật tin tuyển dụng thành công!');

        return redirect('/company/recruitment-news' . $request->input("query"));
    }

    public function delete($id, Request $request)
    {
        $job = Job::findOrFail($id);

        $applications = $job->applications;

        $job->delete();

        foreach ($applications as $application) {
            $candidate = $application->candidate;
            $interview_candidates = $candidate->interview_candidates;
            $candidate->delete();

            foreach ($interview_candidates as $interview_candidate) {
                $interview = Interview::findOrFail($interview_candidate->interview_id);

                if ($interview->interview_candidate->count() === 0) {
                    $interview->delete();
                }
            }
        }

        session()->flash('success', 'Xóa tin tuyển dụng thành công!');

        $campaign = $request->query('campaign-id') ? Campaign::findOrFail($request->query('campaign-id')) : null;
        $query = $campaign ? "?campaign-id=" . $campaign->id : "";

        return redirect('/company/recruitment-news' . $query);
    }

    public function hide($id)
    {
        $job = Job::findOrFail($id);
        $job->status = "hidden";
        $job->save();

        session()->flash('success', 'Đã ẩn tin tuyển dụng khỏi trang đăng tuyển');

        return back();
    }

    public function show($id)
    {
        $job = Job::findOrFail($id);
        $job->status = "shown";
        $job->save();

        session()->flash('success', 'Tin tuyển dụng sẽ xuất hiện lại trên trang đăng tuyển');

        return back();
    }
}

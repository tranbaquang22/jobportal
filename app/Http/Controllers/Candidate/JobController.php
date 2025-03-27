<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyJobRequest;
use App\Models\Application;
use App\Models\Candidate;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Log;



class JobController extends Controller
{
    public function home()
    {
        $latest_jobs = Job::where('status', 'shown')->orderByDesc('created_at')->limit(5)->get();
        $popular_jobs = Job::where('status', 'shown')->withCount('applications')->orderByDesc('applications_count')->limit(5)->get();

        return view('candidate.home', [
            'current_page' => 'home',
            'latest_jobs' => $latest_jobs,
            'popular_jobs' => $popular_jobs
        ]);
    }

    public function list_jobs(Request $request)
    {
        $jobs = Job::query()->where('status', 'shown');

        $is_jobs_empty = $jobs->get()->count();

        $query_title = $request->query('title');
        $query_location = $request->query('location');
        $query_employment_type = $request->query('employment_type');
        $query_position = $request->query('position');
        $query_min_salary = $request->query('min_salary');
        $query_max_salary = $request->query('max_salary');
        $query_negotiable = $request->query('negotiable');

        $salary_display_input = "";

        if ($query_title) {
            $jobs = $jobs->where('name', 'like', '%' . $query_title . '%');
        }
        if ($query_location) {
            $jobs = $jobs->where('location', $query_location);
        }
        if ($query_employment_type) {
            $jobs = $jobs->where('employment_type', $query_employment_type);
        }
        if ($query_position) {
            $jobs = $jobs->where('position', $query_position);
        }

        if ($query_negotiable === "1") {
            $jobs = $jobs->where('salary', 'Thỏa thuận');
            $salary_display_input = "Thỏa thuận";
        } else {
            if ($query_min_salary != "" && $query_max_salary) {
                $jobs = $jobs->where('salary', '<>', 'Thỏa thuận')->get();

                $jobs = $jobs->filter(function ($job) use ($query_min_salary, $query_max_salary) {
                    if (str_contains($job->salary, " - ")) {
                        $job->min_salary = explode(" ", $job->salary)[0];
                        $job->max_salary = explode(" ", $job->salary)[2];
                    } else {
                        $job->min_salary = 0;
                        $job->max_salary = explode(" ", $job->salary)[2];
                    }

                    return intval($job->min_salary) >= intval($query_min_salary) && intval($job->max_salary) <= intval($query_max_salary);
                });

                $salary_display_input = $query_min_salary . " - " . $query_max_salary . " triệu";
            }
        }

        if (!is_a($jobs, 'Illuminate\Database\Eloquent\Collection')) {
            $jobs = $jobs->get();
        }

        return view('candidate.job-list', [
            'current_page' => 'job-list',
            'jobs' => $jobs,
            'is_jobs_empty' => $is_jobs_empty,
            'query_title' => $query_title,
            'query_location' => $query_location,
            'query_employment_type' => $query_employment_type,
            'query_position' => $query_position,
            'query_min_salary' => $query_min_salary,
            'query_max_salary' => $query_max_salary,
            'query_negotiable' => $query_negotiable,
            'salary_display_input' => $salary_display_input
        ]);
    }

    public function search_jobs(Request $request)
    {
        $urlWithQuery = $request->fullUrlWithQuery([
            'title' => $request->input('title'),
            'location' => $request->input('location'),
            'employment_type' => $request->input('employment_type'),
            'position' => $request->input('position'),
            'negotiable' => $request->input('negotiable'),
            'min_salary' => $request->input('min_salary'),
            'max_salary' => $request->input('max_salary'),
        ]);

        return redirect($urlWithQuery . "#search_field");
    }

    public function job_detail($id)
    {
        $job = Job::findOrFail($id);

        return view('candidate.job-detail', [
            'current_page' => 'job-detail',
            'job' => $job
        ]);
    }

    public function apply(ApplyJobRequest $request, $id)
{
    $validated = $request->validated();

    $current_job = Job::findOrFail($id);

    $candidates = Application::where('job_id', $current_job->id)
        ->with('candidate')->get()->pluck('candidate');

    foreach ($candidates as $candidate) {
        if ($candidate->email === $validated['candidate_email']) {
            session()->flash('error', 'Email đã được sử dụng để ứng tuyển cho vị trí này.');
            return back();
        }
    }

    $cv_path = "";
    $video_path = "";

    if ($request->hasfile('cv')) {
        $cv = $request->file('cv');
        $cvName = time() . rand(1, 100) . '.' . $cv->extension();

        if ($cv->move(public_path('uploads'), $cvName)) {
            $cv_path = '/uploads/' . $cvName;
        } else {
            session()->flash('error', 'Upload CV thất bại');
            return back();
        }
    } else {
        session()->flash('error', 'Không tìm thấy CV');
        return back();
    }

// Xử lý tải lên Video
if ($request->hasfile('video')) {
    Log::info('Video file detected.');

    $video = $request->file('video');

    if ($video->getSize() > 20 * 1024 * 1024) {
        session()->flash('error', 'Video không được vượt quá 20MB.');
        return back();
    }

    $videoName = time() . rand(101, 200) . '.' . $video->extension();

    if ($video->move(public_path('uploads/videos'), $videoName)) {
        $video_path = '/uploads/videos/' . $videoName;
    } else {
        session()->flash('error', 'Upload Video thất bại');
        return back();
    }
}


    DB::beginTransaction();

    try {
        $new_candidate = Candidate::create([
            'name' => $validated['candidate_name'],
            'email' => $validated['candidate_email'],
            'phone' => $validated['candidate_phone'],
            'cv_path' => $cv_path,
            'video_path' => $video_path, 
            'cover_letter' => $request->input('cover_letter'),
            'status' => 'Ứng tuyển'
        ]);

        Application::create([
            'job_id' => $current_job->id,
            'candidate_id' => $new_candidate->id
        ]);

        session()->flash('success', 'Ứng tuyển thành công!');

        DB::commit();
    } catch (\Throwable $th) {
        DB::rollBack();
        session()->flash('error', 'Có lỗi xảy ra');
    }

    return redirect('/jobs');
}



    public function search(Request $request)
    {

        return view('candidate.job-list', [
            'current_page' => 'job-list',
            // 'jobs' => $jobs
        ]);
    }
}

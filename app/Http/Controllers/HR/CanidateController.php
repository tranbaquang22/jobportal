<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateApplicationRequest;
use App\Models\Application;
use App\Models\Candidate;
use App\Models\Interview;
use App\Models\InterviewCandidate;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CanidateController extends Controller
{
    public function list_applications(Request $request)
    {
        $candidates = Candidate::query();

        $candidates_before_filtered = $candidates->get();

        $query_name = $request->query('name');
        $query_status = $request->query('status');

        if ($query_name) {
            $candidates = $candidates->where('name', 'like', '%' . $query_name . '%');
        }
        if ($query_status) {
            $candidates = $candidates->where('status', $query_status);
        }

        if (!is_a($candidates, 'Illuminate\Database\Eloquent\Collection')) {
            $candidates = $candidates->get();
        }

        foreach ($candidates as $candidate) {
            $candidate->job_title = $candidate->application->job?->name;
            $candidate->job_id = $candidate->application->job?->id;
        }

        return view('company.applications.index', [
            "role" => User::DISPLAYED_ROLE[Auth::user()->role],
            "breadcrumb_tabs" => ["Quản lý ứng viên" => ""],
            'candidates' => $candidates,
            'candidates_before_filtered' => $candidates_before_filtered,
            'query_name' => $query_name,
            'query_status' => $query_status
        ]);
    }

    public function search_applications(Request $request)
    {
        $urlWithQuery = $request->fullUrlWithQuery([
            'name' => $request->input('name'),
            'status' => $request->input('status')
        ]);

        return redirect($urlWithQuery);
    }

    public function create()
    {
        $jobs = Job::all();

        return view('company.applications.create', [
            "role" => User::DISPLAYED_ROLE[Auth::user()->role],
            "breadcrumb_tabs" => ["Quản lý ứng viên" => "/company/applications", "Thêm ứng viên" => ""],
            "jobs" => $jobs
        ]);
    }

    public function post_create(CreateApplicationRequest $request)
    {
        $validated = $request->validated();

        $current_job = Job::findOrFail($validated['job_id']);

        $cv_path = "";

        if ($request->hasfile('cv')) {
            $cv = $request->file('cv');
            $cvName = time() . rand(1, 100) . '.' . $cv->extension();

            if ($cv->move(public_path('uploads'), $cvName)) {
                $cv_path = '/' . 'uploads/' . $cvName;
                echo $cv_path;
            } else {
                session()->flash('error', 'Upload CV thất bại');
                return back();
            }
        } else {
            session()->flash('error', 'Không tìm thấy CV');
            return back();
        }

        DB::beginTransaction();

        try {
            $new_candidate = Candidate::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'cv_path' => $cv_path,
                'status' => 'Ứng tuyển'
            ]);

            Application::create([
                'job_id' => $current_job->id,
                'candidate_id' => $new_candidate->id
            ]);

            session()->flash('success', 'Thêm ứng viên thành công!');

            DB::commit();
        } catch (\Throwable $th) {
            throw $th;
            // session()->flash('error', 'Có lỗi xảy ra');

            DB::rollBack();
        }

        return redirect('/company/applications');
    }

    public function show($id)
    {
        $application = Application::findOrFail($id);

        return view('company.applications.show', [
            "role" => User::DISPLAYED_ROLE[Auth::user()->role],
            "breadcrumb_tabs" => ["Quản lý ứng viên" => "/company/applications", "Chi tiết ứng viên" => ""],
            'application' => $application
        ]);
    }

    public function update(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $candidate = $application->candidate;

        $candidate->birthday = !is_null($request->input('birthday')) ? $request->input('birthday') : $candidate->birthday;
        $candidate->gender = !is_null($request->input('gender')) ? $request->input('gender') : $candidate->gender;
        $candidate->identity_card = !is_null($request->input('identity_card')) ? $request->input('identity_card') : $candidate->identity_card;
        $candidate->address = !is_null($request->input('address')) ? $request->input('address') : $candidate->address;

        $candidate->save();

        session()->flash('success', 'Cập nhật hồ sơ ứng viên thành công!');

        return back();
    }

    public function show_recruiment_process($id)
    {
        $application = Application::findOrFail($id);
        $candidate_status = $application->candidate->status;
        $candidate_comment = $application->candidate->comment;

        $interview_candidate = InterviewCandidate::where('candidate_id', $application->candidate->id)
            ->where('type', $candidate_status)
            ->first();

        $interview = $interview_candidate?->interview;

        $interviewers = [];

        if ($interview) {
            $interviewer_names = unserialize($interview->interviewer_names);
            $interviewer_emails = unserialize($interview->interviewer_emails);

            for ($i = 0; $i < count($interviewer_names); $i++) {
                $interviewers[] = [
                    'name' => $interviewer_names[$i],
                    'email' => $interviewer_emails[$i]
                ];
            }
        }

        return view('company.applications.show-recruitment-process', [
            "role" => User::DISPLAYED_ROLE[Auth::user()->role],
            "breadcrumb_tabs" => ["Quản lý ứng viên" => "/company/applications", "Chi tiết ứng viên" => ""],
            'application' => $application,
            'status' => $candidate_status,
            'comment' => $candidate_comment,
            'interview' => $interview,
            'interviewers' => $interviewers
        ]);
    }

    public function post_comment(Request $request, $id)
    {
        // echo $request->input('comment');
        $application = Application::findOrFail($id);
        $candidate = $application->candidate;
        $candidate->comment = $request->input('comment');
        $candidate->save();

        session()->flash('success', 'Cập nhật thông tin thành công');

        return back();
    }

    public function update_status($id)
    {
        $application = Application::findOrFail($id);
        $candidate = $application->candidate;

        switch ($candidate->status) {
            case "Ứng tuyển":
                $candidate->status = "Phỏng vấn chuyên sâu";
                break;
            case "Phỏng vấn chuyên sâu":
                $candidate->status = "Phỏng vấn doanh nghiệp";
                break;
            case "Phỏng vấn doanh nghiệp":
                $candidate->status = "Trúng tuyển";
                break;
            default:
                break;
        }

        $candidate->save();
        return back();
    }

    public function delete($id)
    {
        $application = Application::findOrFail($id);
        $candidate = $application->candidate;
        $interview_candidates = $candidate->interview_candidates;
        $candidate->delete();

        foreach ($interview_candidates as $interview_candidate) {
            $interview = Interview::findOrFail($interview_candidate->interview_id);

            if ($interview->interview_candidate->count() === 0) {
                $interview->delete();
            }
        }

        session()->flash('success', 'Xóa ứng viên thành công!');

        return redirect('/company/applications');
    }
}

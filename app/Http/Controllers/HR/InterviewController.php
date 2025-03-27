<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInterviewRequest;
use App\Mail\InterviewNotification;
use App\Models\Application;
use App\Models\Candidate;
use App\Models\Interview;
use App\Models\InterviewCandidate;
use App\Models\Job;
use App\Models\Mail as MailModel;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class InterviewController extends Controller
{
    public function list_interviews(Request $request)
    {
        $interviews = Interview::query();

        $interviews_before_filtered = $interviews->get();

        $query_name = $request->query('name');
        $query_status = $request->query('status');
        $query_type = $request->query('type');
        $query_start_time = $request->query('start_time');
        $query_end_time = $request->query('end_time');

        if ($query_name) {
            $interviews = $interviews->where('name', 'like', '%' . $query_name . '%');
        }
        if ($query_status) {
            $interviews = $interviews->where('status', $query_status);
        }
        if ($query_type) {
            $interviews = $interviews->where('type', $query_type);
        }
        if ($query_start_time) {
            $minDateCarbon = Carbon::createFromFormat('d/m/Y', $query_start_time)->format('Y-m-d');
            $interviews = $interviews->whereRaw("STR_TO_DATE(date, '%d/%m/%Y') >= ?", [$minDateCarbon]);
        }
        if ($query_end_time) {
            $maxDateCarbon = Carbon::createFromFormat('d/m/Y', $query_end_time)->format('Y-m-d');
            $interviews = $interviews->whereRaw("STR_TO_DATE(date, '%d/%m/%Y') <= ?", [$maxDateCarbon]);
        }

        if (!is_a($interviews, 'Illuminate\Database\Eloquent\Collection')) {
            $interviews = $interviews->get();
        }

        $today = Carbon::today()->format('d/m/Y');

        $todayUrl = $request->fullUrlWithQuery([
            'start_time' => $today,
            'end_time' => $today
        ]);

        $isToday = $today === $query_start_time && $today === $query_end_time;

        return view('company.interviews.index', [
            "role" => User::DISPLAYED_ROLE[Auth::user()->role],
            "breadcrumb_tabs" => ["Lịch phỏng vấn" => ""],
            "interviews" => $interviews,
            "interviews_before_filtered" => $interviews_before_filtered,
            'query_name' => $query_name,
            'query_status' => $query_status,
            'query_type' => $query_type,
            'query_start_time' => $query_start_time,
            'query_end_time' => $query_end_time,
            'todayUrl' => $todayUrl,
            'isToday' => $isToday
        ]);
    }

    public function search_interviews(Request $request)
    {
        $urlWithQuery = $request->fullUrlWithQuery([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'status' => $request->input('status'),
            'start_time' => $request->input('start_date'),
            'end_time' => $request->input('end_date')
        ]);

        return redirect($urlWithQuery);
    }

    public function create()
    {
        return view('company.interviews.create', [
            "role" => User::DISPLAYED_ROLE[Auth::user()->role],
            "breadcrumb_tabs" => ["Lịch phỏng vấn" => "/company/interviews", "Tạo mới" => ""]
        ]);
    }

    public function post_create(CreateInterviewRequest $request)
    {
        $validated = $request->validated();

        $interviewer_names = [$validated['interviewer_name']];
        $interviewer_emails = [$validated['interviewer_email']];

        if ($request->input('interviewer_indices')) {
            $interviewer_indices = explode(",", $request->input('interviewer_indices'));
            foreach ($interviewer_indices as $interviewer_index) {
                if (
                    $request->input('interviewer_name_' . $interviewer_index)
                    && $request->input('interviewer_email_' . $interviewer_index)
                ) {
                    $interviewer_names[] = $request->input('interviewer_name_' . $interviewer_index);
                    $interviewer_emails[] = $request->input('interviewer_email_' . $interviewer_index);
                }
            }
        }

        $pre_interview_info = [
            'name' => $validated['name'],
            'type' => $validated['type'],
            'date' => $validated['date'],
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'interviewer_names' => $interviewer_names,
            'interviewer_emails' => $interviewer_emails,
        ];

        $request->session()->put('pre_interview_info', $pre_interview_info);

        return redirect('/company/interviews/create/select-candidate');
    }

    public function select_candidate(Request $request)
    {
        $interview_type = $request->session()->get('pre_interview_info')['type'];

        $candidates = Candidate::where('status', $interview_type)->whereNotIn('id', function ($query) use ($interview_type) {
            $query->select('candidate_id')->from('interview_candidate')->where('type', '=', $interview_type);
        })->get();

        return view('company.interviews.create-select-candidate', [
            "role" => User::DISPLAYED_ROLE[Auth::user()->role],
            "breadcrumb_tabs" => ["Lịch phỏng vấn" => "/company/interviews", "Tạo mới" => ""],
            "candidates" => $candidates
        ]);
    }

    public function post_select_candidate(Request $request)
    {
        $pre_interview_info = $request->session()->get('pre_interview_info');

        DB::beginTransaction();

        try {
            $new_interview = Interview::create([
                'name' => $pre_interview_info['name'],
                'type' => $pre_interview_info['type'],
                'date' => $pre_interview_info['date'],
                'start_time' => $pre_interview_info['start_time'],
                'end_time' => $pre_interview_info['end_time'],
                'interviewer_names' => serialize($pre_interview_info['interviewer_names']),
                'interviewer_emails' => serialize($pre_interview_info['interviewer_emails']),
                'status' => "Chờ xác nhận"
            ]);

            $candidate_ids = explode(",", $request->input("candidates"));

            foreach ($candidate_ids as $candidate_id) {
                InterviewCandidate::create([
                    'interview_id' => $new_interview->id,
                    'candidate_id' => $candidate_id,
                    'type' => $new_interview->type
                ]);
            }

            session()->flash('success', 'Tạo lịch phỏng vấn thành công!');

            DB::commit();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }

        $request->session()->forget('pre_interview_info');

        return redirect('/company/interviews');
    }

    public function show($id)
    {
        $interview = Interview::findOrFail($id);

        $interviewer_names = unserialize($interview->interviewer_names);
        $interviewer_emails = unserialize($interview->interviewer_emails);

        $first_interviewer = [
            'name' => $interviewer_names[0],
            'email' => $interviewer_emails[0]
        ];

        $interviewers = [];

        for ($i = 1; $i < count($interviewer_names); $i++) {
            $interviewers[] = [
                'name' => $interviewer_names[$i],
                'email' => $interviewer_emails[$i]
            ];
        }

        $interview->interviewers = $interviewers;

        $candidates = InterviewCandidate::where('interview_id', $interview->id)
            ->with('candidate')
            ->get()
            ->pluck('candidate');

        $interviewer_mail = MailModel::where('name', 'interviewer-notification')->first();

        $candidate_mail = MailModel::where('name', 'candidate-online-notification')->first();

        $passed_mail = MailModel::where('name', 'passed-notification')->first();

        if ($interview->type === "Phỏng vấn doanh nghiệp") {
            $candidate_mail = MailModel::where('name', 'candidate-offline-notification')->first();
            $passed_mail = MailModel::where('name', 'final-passed-notification')->first();
        }

        $failed_mail = MailModel::where('name', 'failed-notification')->first();

        return view('company.interviews.show', [
            "role" => User::DISPLAYED_ROLE[Auth::user()->role],
            "breadcrumb_tabs" => ["Lịch phỏng vấn" => "/company/interviews", "Thông tin chi tiết" => ""],
            "interview" => $interview,
            "first_interviewer" => $first_interviewer,
            "candidates" => $candidates,
            "interviewer_mail" => $interviewer_mail,
            "candidate_mail" => $candidate_mail,
            "passed_mail" => $passed_mail,
            "failed_mail" => $failed_mail
        ]);
    }

    public function post_update($id, CreateInterviewRequest $request)
    {
        if ($request->input("update_type")) {
            $interview = Interview::findOrFail($id);
            $interview_candidates = InterviewCandidate::where('interview_id', $interview->id)->get();

            foreach ($interview_candidates as $interview_candidate) {
                $candidate_id = $interview_candidate->candidate_id;
                $candidate = Candidate::findOrFail($candidate_id);

                if ($request->input('status-' . $candidate_id) === 'passed') {
                    switch ($candidate->status) {
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
                } else {
                    $candidate->status = "Không trúng tuyển";
                    $candidate->save();
                }
            }

            $interview->status = "Đã kết thúc";
            $interview->save();
        } else {
            $validated = $request->validated();

            $interviewer_names = [$validated['interviewer_name']];
            $interviewer_emails = [$validated['interviewer_email']];

            if ($request->input('interviewer_indices')) {
                $interviewer_indices = explode(",", $request->input('interviewer_indices'));
                foreach ($interviewer_indices as $interviewer_index) {
                    if (
                        $request->input('interviewer_name_' . $interviewer_index)
                        && $request->input('interviewer_email_' . $interviewer_index)
                    ) {
                        $interviewer_names[] = $request->input('interviewer_name_' . $interviewer_index);
                        $interviewer_emails[] = $request->input('interviewer_email_' . $interviewer_index);
                    }
                }
            }

            $interview = Interview::findOrFail($id);

            $interview->name = !is_null($validated['name']) ? $validated['name'] : $interview->name;
            $interview->type = !is_null($validated['type']) ? $validated['type'] : $interview->type;
            $interview->date = !is_null($validated['date']) ? $validated['date'] : $interview->date;
            $interview->start_time = !is_null($request->input('start_time')) ? $request->input('start_time') : $interview->start_time;
            $interview->end_time = !is_null($request->input('end_time')) ? $request->input('end_time') : $interview->end_time;

            $interview->interviewer_names = serialize($interviewer_names);
            $interview->interviewer_emails = serialize($interviewer_emails);

            $interview->save();
        }

        session()->flash('success', 'Cập nhật lịch phỏng vấn thành công!');

        return redirect('/company/interviews');
    }

    public function delete($id)
    {
        $interview = Interview::findOrFail($id);
        $interview->delete();

        session()->flash('success', 'Xóa lịch phỏng vấn thành công!');

        return redirect('/company/interviews');
    }

    public function update_candidate($id)
    {
        $interview = Interview::findOrFail($id);

        $interview_type = $interview->type;

        $candidates_not_selected = Candidate::where('status', $interview_type)->whereNotIn('id', function ($query) use ($interview_type) {
            $query->select('candidate_id')->from('interview_candidate')->where('type', '=', $interview_type);
        })->get();

        $candidates_selected = InterviewCandidate::where('interview_id', $interview->id)
            ->with('candidate')
            ->get()
            ->pluck('candidate');

        return view('company.interviews.update-candidates', [
            "role" => User::DISPLAYED_ROLE[Auth::user()->role],
            "breadcrumb_tabs" => [
                "Lịch phỏng vấn" => "/company/interviews",
                "Thông tin chi tiết" => "/company/interviews/" . $id,
                "Cập nhật thông tin ứng viên" => ""
            ],
            "candidates_selected" => $candidates_selected,
            "candidates_not_selected" => $candidates_not_selected,
            "interview_id" => $interview->id
        ]);
    }

    public function post_update_candidate(Request $request, $id)
    {
        echo $request->input('candidates');

        $interview = Interview::findOrFail($id);

        DB::beginTransaction();

        try {
            $candidate_ids = explode(",", $request->input("candidates"));

            InterviewCandidate::where('interview_id', $interview->id)->delete();

            foreach ($candidate_ids as $candidate_id) {
                InterviewCandidate::create([
                    'interview_id' => $interview->id,
                    'candidate_id' => $candidate_id,
                    'type' => $interview->type
                ]);
            }

            session()->flash('success', 'Cập nhật danh sách ứng viên thành công!');

            DB::commit();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }

        return redirect('/company/interviews/' . $interview->id);
    }

    public function send_mai_to_interviewers(Request $request)
    {
        $interview = Interview::findOrFail($request->interview_id);
        // echo $interview->start_time . ' - ' . $interview->end_time . " ngày " . $interview->date;

        $interviewer_names = unserialize($interview->interviewer_names);
        $interviewer_emails = unserialize($interview->interviewer_emails);

        $interviewer_mail = MailModel::where('name', 'interviewer-notification')->first();

        for ($i = 0; $i < count($interviewer_names); $i++) {
            $content = str_replace('[Tên người phỏng vấn]', $interviewer_names[$i], $interviewer_mail->content);
            $content = str_replace('[Tên vòng phỏng vấn]', $interview->type, $content);
            $content = str_replace(
                '[Thời gian phỏng vấn]',
                $interview->start_time . ' - ' . $interview->end_time . " ngày " . $interview->date,
                $content
            );
            $content = str_replace(
                '[Số lượng ứng viên]',
                $interview->interview_candidate->count(),
                $content
            );
            // echo $content;
            Mail::to($interviewer_emails[$i])
                ->send(new InterviewNotification($interviewer_mail->subject, $content));
        }

        $interview->interviewer_mail_status = 'sent';
        $interview->status = 'Đang hoạt động';
        $interview->save();

        session()->flash('success', 'Gửi mail thành công!');

        return back();
    }

    public function send_mail_to_online_candidates(Request $request)
    {
        $interview = Interview::findOrFail($request->interview_id);

        $candidates = InterviewCandidate::where('interview_id', $interview->id)
            ->with('candidate')
            ->get()
            ->pluck('candidate');

        $candidate_mail = MailModel::where('name', 'candidate-online-notification')->first();

        foreach ($candidates as $candidate) {
            $content = str_replace(
                '[Tên ứng viên]',
                $candidate->name,
                $candidate_mail->content
            );
            $content = str_replace(
                '[Vị trí ứng tuyển]',
                $candidate->application->job->name,
                $content
            );
            $content = str_replace(
                '[Thời gian phỏng vấn]',
                $interview->start_time . ' - ' . $interview->end_time . " ngày " . $interview->date,
                $content
            );

            Mail::to($candidate->email)
                ->send(new InterviewNotification($candidate_mail->subject, $content));
        }

        $interview->candidate_mail_status = 'sent';
        $interview->status = 'Đang hoạt động';
        $interview->save();

        session()->flash('success', 'Gửi mail thành công!');

        return back();
    }

    public function send_mail_to_offline_candidates(Request $request)
    {
        $interview = Interview::findOrFail($request->interview_id);

        $candidates = InterviewCandidate::where('interview_id', $interview->id)
            ->with('candidate')
            ->get()
            ->pluck('candidate');

        $candidate_mail = MailModel::where('name', 'candidate-offline-notification')->first();

        foreach ($candidates as $candidate) {
            $content = str_replace(
                '[Tên ứng viên]',
                $candidate->name,
                $candidate_mail->content
            );
            $content = str_replace(
                '[Vị trí ứng tuyển]',
                $candidate->application->job->name,
                $content
            );
            $content = str_replace(
                '[Thời gian phỏng vấn]',
                $interview->start_time . ' - ' . $interview->end_time . " ngày " . $interview->date,
                $content
            );
            $content = str_replace(
                '[Địa điểm]',
                $candidate->application->job->workplace,
                $content
            );

            Mail::to($candidate->email)
                ->send(new InterviewNotification($candidate_mail->subject, $content));
        }

        $interview->candidate_mail_status = 'sent';
        $interview->status = 'Đang hoạt động';
        $interview->save();

        session()->flash('success', 'Gửi mail thành công!');

        return back();
    }

    public function send_passed_mail(Request $request)
    {
        $interview = Interview::findOrFail($request->interview_id);

        $candidates = InterviewCandidate::where('interview_id', $interview->id)
            ->with('candidate')
            ->get()
            ->pluck('candidate');

        $candidate_mail = MailModel::where('name', 'passed-notification')->first();

        foreach ($candidates as $candidate) {
            $content = str_replace(
                '[Tên ứng viên]',
                $candidate->name,
                $candidate_mail->content
            );

            if ($candidate->status !== "Không trúng tuyển") {
                Mail::to($candidate->email)
                    ->send(new InterviewNotification($candidate_mail->subject, $content));
            }
        }

        $interview->passed_mail_status = 'sent';
        $interview->save();

        session()->flash('success', 'Gửi mail thành công!');

        return back();
    }

    public function send_final_passed_mail(Request $request)
    {
        $interview = Interview::findOrFail($request->interview_id);

        $candidates = InterviewCandidate::where('interview_id', $interview->id)
            ->with('candidate')
            ->get()
            ->pluck('candidate');

        $candidate_mail = MailModel::where('name', 'final-passed-notification')->first();

        foreach ($candidates as $candidate) {
            $content = str_replace(
                '[Tên ứng viên]',
                $candidate->name,
                $candidate_mail->content
            );

            $content = str_replace(
                '[Vị trí ứng tuyển]',
                $candidate->application->job->name,
                $content
            );

            if ($candidate->status !== "Không trúng tuyển") {
                Mail::to($candidate->email)
                    ->send(new InterviewNotification($candidate_mail->subject, $content));
            }
        }

        $interview->passed_mail_status = 'sent';
        $interview->save();

        session()->flash('success', 'Gửi mail thành công!');

        return back();
    }

    public function send_failed_mail(Request $request)
    {
        $interview = Interview::findOrFail($request->interview_id);

        $candidates = InterviewCandidate::where('interview_id', $interview->id)
            ->with('candidate')
            ->get()
            ->pluck('candidate');

        $candidate_mail = MailModel::where('name', 'failed-notification')->first();

        foreach ($candidates as $candidate) {
            $content = str_replace(
                '[Tên ứng viên]',
                $candidate->name,
                $candidate_mail->content
            );
            $content = str_replace(
                '[Vị trí ứng tuyển]',
                $candidate->application->job->name,
                $content
            );

            if ($candidate->status === "Không trúng tuyển") {
                Mail::to($candidate->email)
                    ->send(new InterviewNotification($candidate_mail->subject, $content));
            }
        }

        $interview->failed_mail_status = 'sent';
        $interview->save();

        session()->flash('success', 'Gửi mail thành công!');

        return back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetUpMailTemplateRequest;
use App\Models\Mail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MailController extends Controller
{
    public function update_interviewer_mail($id)
    {
        $mail = Mail::where('name', 'interviewer-notification')->first();

        return view('company.mail-setting', [
            "role" => User::DISPLAYED_ROLE[Auth::user()->role],
            "breadcrumb_tabs" => [
                "Lịch phỏng vấn" => "/company/interviews",
                "Thông tin chi tiết" => "/company/interviews/" . $id,
                "Thiết lập email" => ""
            ],
            "title" => "Thiết lập email thông báo cho người phỏng vấn",
            "mail" => $mail
        ]);
    }

    public function post_update_interviewer_mail(SetUpMailTemplateRequest $request, $id)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $mail = Mail::where('name', 'interviewer-notification')->first();

            if ($mail) {
                $mail->subject = $validated['subject'];
                $mail->content = $validated['content'];
                $mail->save();
            } else {
                Mail::create([
                    'name' => 'interviewer-notification',
                    'subject' => $validated['subject'],
                    'content' => $validated['content']
                ]);
            }

            session()->flash('success', 'Thiết lập email thành công!');

            DB::commit();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }

        return redirect('/company/interviews/' . $id);
    }

    public function update_online_candidate_mail($id)
    {
        $mail = Mail::where('name', 'candidate-online-notification')->first();

        return view('company.mail-setting', [
            "role" => User::DISPLAYED_ROLE[Auth::user()->role],
            "breadcrumb_tabs" => [
                "Lịch phỏng vấn" => "/company/interviews",
                "Thông tin chi tiết" => "/company/interviews/" . $id,
                "Thiết lập email" => ""
            ],
            "title" => "Thiết lập email thông báo phỏng vấn chuyên sâu",
            "mail" => $mail
        ]);
    }

    public function post_update_online_candidate_mail(SetUpMailTemplateRequest $request, $id)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $mail = Mail::where('name', 'candidate-online-notification')->first();

            if ($mail) {
                $mail->subject = $validated['subject'];
                $mail->content = $validated['content'];
                $mail->save();
            } else {
                Mail::create([
                    'name' => 'candidate-online-notification',
                    'subject' => $validated['subject'],
                    'content' => $validated['content']
                ]);
            }

            session()->flash('success', 'Thiết lập email thành công!');

            DB::commit();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }

        return redirect('/company/interviews/' . $id);
    }

    public function update_offline_candidate_mail($id)
    {
        $mail = Mail::where('name', 'candidate-offline-notification')->first();

        return view('company.mail-setting', [
            "role" => User::DISPLAYED_ROLE[Auth::user()->role],
            "breadcrumb_tabs" => [
                "Lịch phỏng vấn" => "/company/interviews",
                "Thông tin chi tiết" => "/company/interviews/" . $id,
                "Thiết lập email" => ""
            ],
            "title" => "Thiết lập email thông báo phỏng vấn doanh nghiệp",
            "mail" => $mail
        ]);
    }

    public function post_update_offline_candidate_mail(SetUpMailTemplateRequest $request, $id)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $mail = Mail::where('name', 'candidate-offline-notification')->first();

            if ($mail) {
                $mail->subject = $validated['subject'];
                $mail->content = $validated['content'];
                $mail->save();
            } else {
                Mail::create([
                    'name' => 'candidate-offline-notification',
                    'subject' => $validated['subject'],
                    'content' => $validated['content']
                ]);
            }

            session()->flash('success', 'Thiết lập email thành công!');

            DB::commit();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }

        return redirect('/company/interviews/' . $id);
    }

    public function update_passed_mail($id)
    {
        $mail = Mail::where('name', 'passed-notification')->first();

        return view('company.mail-setting', [
            "role" => User::DISPLAYED_ROLE[Auth::user()->role],
            "breadcrumb_tabs" => [
                "Lịch phỏng vấn" => "/company/interviews",
                "Thông tin chi tiết" => "/company/interviews/" . $id,
                "Thiết lập email" => ""
            ],
            "title" => "Thiết lập email thông báo đạt phỏng vấn chuyên sâu",
            "mail" => $mail
        ]);
    }

    public function post_update_passed_mail(SetUpMailTemplateRequest $request, $id)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $mail = Mail::where('name', 'passed-notification')->first();

            if ($mail) {
                $mail->subject = $validated['subject'];
                $mail->content = $validated['content'];
                $mail->save();
            } else {
                Mail::create([
                    'name' => 'passed-notification',
                    'subject' => $validated['subject'],
                    'content' => $validated['content']
                ]);
            }

            session()->flash('success', 'Thiết lập email thành công!');

            DB::commit();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }

        return redirect('/company/interviews/' . $id);
    }

    public function update_final_passed_mail($id)
    {
        $mail = Mail::where('name', 'final-passed-notification')->first();

        return view('company.mail-setting', [
            "role" => User::DISPLAYED_ROLE[Auth::user()->role],
            "breadcrumb_tabs" => [
                "Lịch phỏng vấn" => "/company/interviews",
                "Thông tin chi tiết" => "/company/interviews/" . $id,
                "Thiết lập email" => ""
            ],
            "title" => "Thiết lập email thông báo trúng tuyển",
            "mail" => $mail
        ]);
    }

    public function post_update_final_passed_mail(SetUpMailTemplateRequest $request, $id)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $mail = Mail::where('name', 'final-passed-notification')->first();

            if ($mail) {
                $mail->subject = $validated['subject'];
                $mail->content = $validated['content'];
                $mail->save();
            } else {
                Mail::create([
                    'name' => 'final-passed-notification',
                    'subject' => $validated['subject'],
                    'content' => $validated['content']
                ]);
            }

            session()->flash('success', 'Thiết lập email thành công!');

            DB::commit();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }

        return redirect('/company/interviews/' . $id);
    }

    public function update_failed_mail($id)
    {
        $mail = Mail::where('name', 'failed-notification')->first();

        return view('company.mail-setting', [
            "role" => User::DISPLAYED_ROLE[Auth::user()->role],
            "breadcrumb_tabs" => [
                "Lịch phỏng vấn" => "/company/interviews",
                "Thông tin chi tiết" => "/company/interviews/" . $id,
                "Thiết lập email" => ""
            ],
            "title" => "Thiết lập email thông báo đạt phỏng vấn chuyên sâu",
            "mail" => $mail
        ]);
    }

    public function post_update_failed_mail(SetUpMailTemplateRequest $request, $id)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $mail = Mail::where('name', 'failed-notification')->first();

            if ($mail) {
                $mail->subject = $validated['subject'];
                $mail->content = $validated['content'];
                $mail->save();
            } else {
                Mail::create([
                    'name' => 'failed-notification',
                    'subject' => $validated['subject'],
                    'content' => $validated['content']
                ]);
            }

            session()->flash('success', 'Thiết lập email thành công!');

            DB::commit();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }

        return redirect('/company/interviews/' . $id);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Mail;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'name' => 'Admin',
            'role' => 'ADMIN',
            'phone' => '0123456789'
        ]);

        Mail::create([
            'name' => 'interviewer-notification',
            'subject' => 'Thông báo lịch phỏng vấn ứng viên',
            'content' => '<div>Thân gửi, <strong>[Tên người phỏng vấn]</strong><br><br>Phòng Nhân sự xin gửi đến bạn lịch phỏng vấn ứng viên sắp diễn ra<br>Thông tin chi tiết như sau:</div><ul><li>Vòng phỏng vấn: <strong>[Tên vòng phỏng vấn]</strong></li><li>Thời gian: <strong>[Thời gian phỏng vấn]</strong></li><li>Số lượng ứng viên: <strong>[Số lượng ứng viên]</strong></li></ul><div>Nếu có vấn đề gì thắc mắc hoặc khó khăn trong quá trình ứng tuyển, vui lòng liên hệ:</div><ul><li>SĐT: 0123456789</li><li>Email: hr@gmail.com</li></ul><div>Xin cảm ơn!<br>Trân trọng.</div>',
        ]);

        Mail::create([
            'name' => 'candidate-online-notification',
            'subject' => 'Thư mời phỏng vấn',
            'content' => '<div>Thân gửi <strong>[Tên ứng viên]</strong>,<br>Lời đầu tiên, chúng tôi xin cảm ơn bạn đã dành thời gian tìm hiểu và ứng tuyển tại công ty chúng tôi.<br>Qua vòng lọc CV, xem xét thông tin hồ sơ, chúng tôi nhận thấy bạn là ứng viên tiềm năng cho vị trí <strong>[Vị trí ứng tuyển]</strong>. Phòng nhân sự chúng tôi xin mời bạn tham gia vòng phỏng vấn Chuyên sâu với thông tin cụ thể như sau:</div><ul><li>Thời gian: <strong>[Thời gian phỏng vấn]</strong></li><li>Hình thức: ONLINE</li><li>Link phỏng vấn:</li></ul><div>Bạn vui lòng truy cập đường dẫn đã được cung cấp vào đúng thời gian phỏng vấn đồng thời chuẩn bị đường truyền mạng ổn định để buổi phỏng vấn diễn ra thành công tốt đẹp.<br><br>Nếu có vấn đề gì thắc mắc hoặc khó khăn trong quá trình ứng tuyển, bạn vui lòng liên hệ:</div><ul><li>SĐT: 0123456789</li><li>Email: hr@gmail.com</li></ul><div><br>Xin cảm ơn!<br>Trân trọng.</div>'
        ]);
    }
}

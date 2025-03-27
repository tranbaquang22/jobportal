@extends('candidate.layouts.default')

@section('content')

<!-- Header End -->
<div class="container-xxl py-5 bg-dark page-header">
    <div class="container my-5 pt-5 pb-4">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Danh sách việc làm</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb text-uppercase">
                <li class="breadcrumb-item"><a href="/" class="text-light">Trang chủ</a></li>
                <!-- <li class="breadcrumb-item"><a href="#" class="text-white">Pages</a></li> -->
                <li class="breadcrumb-item text-white active" aria-current="page">Danh sách việc làm</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Header End -->

<!-- Search Start -->
<div class="container-fluid bg-primary mb-5 wow fadeIn" data-wow-delay="0.1s" style="padding: 35px;" id="search_field">
    <div class="container">
        <form method="POST" action="/jobs">
            @csrf
            <div class="row g-4">
                <div class="col-md-10">
                    <div class="row g-4">
                        <div class="col-md-8">
                            <input type="text" name="title" value="{{$query_title}}" class="form-control border-0" placeholder="Vị trí tuyển dụng" />
                        </div>
                        <div class="col-md-4">
                            @php
                            $provinces = [
                            "Hà Nội", "Hồ Chí Minh", "Bình Dương", "Bắc Ninh", "Đồng Nai", "Hưng Yên", "Hải Dương", "Đà Nẵng",
                            "Hải Phòng", "An Giang", "Bà Rịa-Vũng Tàu", "Bắc Giang", "Bắc Kạn", "Bạc Liêu", "Bến Tre",
                            "Bình Định", "Bình Phước", "Bình Thuận", "Cà Mau", "Cần Thơ", "Cao Bằng", "Đắk Lắk",
                            "Đắk Nông", "Điện Biên", "Đồng Tháp", "Gia Lai", "Hà Giang", "Hà Nam", "Hà Tĩnh",
                            "Hậu Giang", "Hoà Bình", "Khánh Hoà", "Kiên Giang", "Kon Tum", "Lai Châu", "Lâm Đồng",
                            "Lạng Sơn", "Lào Cai", "Long An", "Nam Định", "Nghệ An", "Ninh Bình", "Ninh Thuận",
                            "Phú Thọ", "Phú Yên", "Quảng Bình", "Quảng Nam", "Quảng Ngãi", "Quảng Ninh", "Quảng Trị",
                            "Sóc Trăng", "Sơn La", "Tây Ninh", "Thái Bình", "Thái Nguyên", "Thanh Hoá", "Thừa Thiên Huế",
                            "Tiền Giang", "Trà Vinh", "Tuyên Quang", "Vĩnh Long", "Vĩnh Phúc", "Yên Bái"
                            ];
                            @endphp
                            <select class="form-select border-0" name="location">
                                <option value="" selected>Chọn địa điểm</option>
                                @foreach($provinces as $province)
                                <option value="{{$province}}" @if($query_location=="$province" ) selected @endif>{{$province}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <select class="form-select" name="employment_type" id="employment_type">
                                <option value="">Chọn hình thức</option>
                                <option value="Toàn thời gian" @if($query_employment_type=="Toàn thời gian" ) selected @endif>Toàn thời gian</option>
                                <option value="Bán thời gian" @if($query_employment_type=="Bán thời gian" ) selected @endif>Bán thời gian</option>
                                <option value="Thực tập" @if($query_employment_type=="Thực tập" ) selected @endif>Thực tập</option>
                            </select>
                        </div>
                        @php
                        $levels = ["Nhân viên","Trưởng nhóm","Trưởng/Phó phòng","Quản lý/Giám sát", "Trưởng chi nhánh", "Phó giám đốc", "Giám đốc", "Thực tập sinh"];
                        @endphp
                        <div class="col-md-4">
                            <select class="form-select" name="position" id="position">
                                <option value="">Chọn cấp bậc</option>
                                @foreach($levels as $level)
                                <option value="{{$level}}" @if($query_position==$level) selected @endif>{{$level}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 position-relative">
                            <input type="text" readonly id="salary_input" class="form-control bg-white border-0" placeholder="Mức lương" value="{{$salary_display_input}}" />
                            <div class="w-100 bg-white position-absolute border rounded mt-2 p-4 d-none" id="salary_dropdown">
                                <div class="d-flex gap-2 align-items-center pe-2">
                                    <input type="number" id="min_salary" name="min_salary" value="{{$query_min_salary}}" class="form-control" placeholder="Từ" />
                                    <div>-</div>
                                    <input type="number" id="max_salary" name="max_salary" value="{{$query_max_salary}}" class="form-control" placeholder="Đến" />
                                    <div>triệu</div>
                                </div>
                                <button type="button" id="salary_save_btn" class="btn btn-primary py-1 w-100 mt-2">Áp dụng</button>

                                <hr>
                                <div>Khác</div>
                                <input type="hidden" name="negotiable" id="negotiable_input" value="{{$query_negotiable}}" />
                                <button type="button" id="salary_negotiable_btn" class="btn btn-info text-white py-1 w-100 mt-2">Thỏa thuận</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-dark border-0 w-100" type="submit">Tìm kiếm</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Search End -->

<!-- Jobs Start -->
<div class="container-xxl pb-5">
    <div class="container">
        <!-- <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Việc làm tốt nhất</h1> -->
        @if ($jobs->count() > 0)
        <div class="text-center wow fadeInUp" data-wow-delay="0.3s">
            <!-- <div class="tab-content"> -->
            <div class="fade show p-0 active">
                @foreach($jobs as $job)
                <div class="job-item p-4 mb-4">
                    <div class="row g-4">
                        <div class="col-sm-12 col-md-8 d-flex align-items-center">
                            <!-- <img class="flex-shrink-0 img-fluid border rounded" src="/assets/candidate/img/com-logo-1.jpg" alt="" style="width: 80px; height: 80px;"> -->
                            <div class="text-start ps-4">
                                <h5 class="mb-3">{{$job->name}}</h5>
                                <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>{{$job->location}}</span>
                                <span class="text-truncate me-3"><i class="fa fa-clock text-primary me-2"></i>{{$job->employment_type}}</span>
                                <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>{{$job->salary}}</span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                            <div class="d-flex mb-3">
                                <a class="btn btn-light btn-square me-3" href=""><i class="far fa-heart text-primary"></i></a>
                                <a class="btn btn-primary" href="/jobs/{{$job->id}}#job-detail">Xem chi tiết</a>
                            </div>
                            <small class="text-truncate"><i class="far fa-calendar-alt text-primary me-2"></i>Hạn ứng tuyển: {{$job->deadline}}</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!-- </div> -->
        </div>
        @elseif ($is_jobs_empty === 0)
        <h3 class="text-center pt-5 wow fadeInUp" data-wow-delay="0.1s">Hiện không có tin tuyển dụng nào trên hệ thống</h3>
        @else
        <h3 class="text-center pt-5 wow fadeInUp" data-wow-delay="0.1s">Không tìm thấy công việc phù hợp</h3>
        @endif
    </div>
</div>
<!-- Jobs End -->

<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

<script>
    const salaryInput = document.getElementById('salary_input');
    const dropdown = document.getElementById('salary_dropdown');

    salaryInput.addEventListener("click", function() {
        dropdown.classList.toggle("d-none");
    });

    document.addEventListener('click', (event) => {
        if (!dropdown.contains(event.target) && event.target !== salaryInput) {
            dropdown.classList.add('d-none');
        }
    });

    document.getElementById("salary_save_btn").addEventListener("click", function() {
        const minSalary = document.getElementById('min_salary').value;
        const maxSalary = document.getElementById('max_salary').value;

        if (minSalary && maxSalary && minSalary >= 0 && maxSalary > 0 && parseInt(minSalary) <= parseInt(maxSalary)) {
            if (parseInt(minSalary) == parseInt(maxSalary)) {
                salaryInput.value = `${minSalary} triệu`;
            } else {
                salaryInput.value = `${minSalary} - ${maxSalary} triệu`;
            }

            document.getElementById("negotiable_input").value = 0;
            dropdown.classList.toggle("d-none");
        } else {
            alert("Vui lòng chọn múc lương hợp lệ");
        }
    });

    document.getElementById("salary_negotiable_btn").addEventListener("click", function() {
        salaryInput.value = `Thỏa thuận`;
        document.getElementById("negotiable_input").value = 1;
        dropdown.classList.add("d-none");
    });
</script>


@endsection
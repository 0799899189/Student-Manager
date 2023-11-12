<?php
class SubjectController
{
    // class này không cần thuộc tính

    // Nếu khai báo hàm __construct() thì hàm __construct() không tham số mặc định sẽ được gọi
    // function __construct() {

    // }

    // Hiển thị danh sách môn học
    public function index()
    {
        // gọi model lấy dữ liệu
        $subjectRepository = new SubjectRepository();
        $search = $_GET['search'] ?? '';
        if ($search) {
            $subjects = $subjectRepository->getByPattern($search);
        } else {
            $subjects = $subjectRepository->getAll();
        }

        require 'view/subject/index.php';
    }

    // Hiển thị form thêm môn học
    public function create()
    {
        require 'view/subject/create.php';
    }

    // Thêm môn học
    public function store()
    {
        $subjectRepository = new SubjectRepository();
        if ($subjectRepository->save($_POST)) {
            // lưu thành công
            $name = $_POST['name'];
            $_SESSION['success'] = "Đã thêm môn học $name thành công";
            header('location: /?c=subject');
            exit;
        }
        // lưu thất bạ
        $_SESSION['error'] = $subjectRepository->error;
        header('location: /?c=subject');
    }

    public function edit()
    {
        $id = $_GET['id'];
        $subjectRepository = new SubjectRepository();
        $subject = $subjectRepository->find($id);
        require 'view/subject/edit.php';
    }

    public function update()
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $number_of_credit = $_POST['number_of_credit'];

        // Lấy subject từ database
        $subjectRepository = new SubjectRepository();
        $subject = $subjectRepository->find($id);

        // Cập nhật giá trị từ người dùng vào object subject
        $subject->name = $name;
        $subject->number_of_credit = $number_of_credit;

        // Update đối tượng này vào database
        if ($subjectRepository->update($subject)) {
            // lưu thành công
            $_SESSION['success'] = "Đã cập nhật môn học $name thành công";
            header('location: /?c=subject');
            exit;
        }
        // lưu thất bạ
        $_SESSION['error'] = $subjectRepository->error;
        header('location: /?c=subject');
    }

    public function destroy()
    {
        $id = $_GET['id'];
        // Lấy subject từ database
        $subjectRepository = new SubjectRepository();
        $subject = $subjectRepository->find($id);
        $name = $subject->name;

         // kiểm tra môn học này đã được sinh viên đăng ký chưa?
         $registerRepository = new RegisterRepository();
         $registers = $registerRepository->getBySubjectId($id);
         $number = count($registers);
         if ($number > 0) {
             $_SESSION['error'] = "Môn học $name đã được $number sinh viên đăng ký. Không thể xóa";
             header('location: /');
             exit;
         }

        // Update đối tượng này vào database
        if ($subjectRepository->delete($id)) {
            // lưu thành công
            $_SESSION['success'] = "Đã xóa môn học $name thành công";
            header('location: /?c=subject');
            exit;
        }
        // lưu thất bại
        $_SESSION['error'] = $subjectRepository->error;
        header('location: /?c=subject');

    }
}
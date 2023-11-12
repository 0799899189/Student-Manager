<?php
class RegisterController
{
    // class này không cần thuộc tính

    // Nếu khai báo hàm __construct() thì hàm __construct() không tham số mặc định sẽ được gọi
    // function __construct() {

    // }

    // Hiển thị danh sách môn học
    public function index()
    {
        // gọi model lấy dữ liệu
        $registerRepository = new RegisterRepository();
        $search = $_GET['search'] ?? '';
        if ($search) {
            $registers = $registerRepository->getByPattern($search);
        } else {
            $registers = $registerRepository->getAll();
        }

        require 'view/register/index.php';
    }

    // Hiển thị form thêm môn học
    public function create()
    {
        // Lấy danh sách sinh viên từ database
        $studentRepository = new StudentRepository();
        $students = $studentRepository->getAll();

        // Lấy danh sách môn học từ database
        $subjectRepository = new SubjectRepository();
        $subjects = $subjectRepository->getAll();
        require 'view/register/create.php';
    }

    // Thêm môn học
    public function store()
    {
        $registerRepository = new RegisterRepository();

        $student_id = $_POST['student_id'];
        $studentRepository = new StudentRepository();
        $student = $studentRepository->find($student_id);
        $student_name = $student->name;

        $subject_id = $_POST['subject_id'];
        $subjectRepository = new SubjectRepository();
        $subject = $subjectRepository->find($subject_id);
        $subject_name = $subject->name;

        if ($registerRepository->save($_POST)) {
            // lưu thành công
            $_SESSION['success'] = "Sinh viên $student_name đăng ký môn $subject_name thành công";
            header('location: /?c=register');
            exit;
        }
        // lưu thất bạ
        $_SESSION['error'] = $registerRepository->error;
        header('location: /?c=register');
    }

    public function edit()
    {
        $id = $_GET['id'];
        $registerRepository = new RegisterRepository();
        $register = $registerRepository->find($id);
        require 'view/register/edit.php';
    }

    public function update()
    {
        $id = $_POST['id'];
        $score = $_POST['score'];

        // Lấy register từ database
        $registerRepository = new RegisterRepository();
        $register = $registerRepository->find($id);

        // Cập nhật giá trị từ người dùng vào object register
        $register->score = $score;

        $student_name = $register->student_name;
        $subject_name = $register->subject_name;

        // Update đối tượng này vào database
        if ($registerRepository->update($register)) {
            // lưu thành công
            $_SESSION['success'] = "Sinh viên $student_name thi môn $subject_name được $score điểm";
            header('location: /?c=register');
            exit;
        }
        // lưu thất bạ
        $_SESSION['error'] = $registerRepository->error;
        header('location: /?c=register');
    }

    public function destroy()
    {
        $id = $_GET['id'];
        // Lấy register từ database
        $registerRepository = new RegisterRepository();
        $register = $registerRepository->find($id);
        $student_name = $register->student_name;
        $subject_name = $register->subject_name;

        // Update đối tượng này vào database
        if ($registerRepository->delete($id)) {
            // lưu thành công
            $_SESSION['success'] = "Xóa sinh viên $student_name đăng ký môn học $subject_name";
            header('location: /?c=register');
            exit;
        }
        // lưu thất bại
        $_SESSION['error'] = $registerRepository->error;
        header('location: /?c=register');
    }
}

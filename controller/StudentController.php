<?php
class StudentController
{
    // class này không cần thuộc tính

    // Nếu khai báo hàm __construct() thì hàm __construct() không tham số mặc định sẽ được gọi
    // function __construct() {

    // }

    // Hiển thị danh sách sinh viên
    public function index()
    {
        // gọi model lấy dữ liệu
        $studentRepository = new StudentRepository();
        $search = $_GET['search'] ?? '';
        if ($search) {
            $students = $studentRepository->getByPattern($search);
        } else {
            $students = $studentRepository->getAll();
        }

        require 'view/student/index.php';
    }

    // Hiển thị form thêm sinh viên
    public function create()
    {
        require 'view/student/create.php';
    }

    // Thêm sinh viên
    public function store()
    {
        $studentRepository = new StudentRepository();
        if ($studentRepository->save($_POST)) {
            // lưu thành công
            $name = $_POST['name'];
            $_SESSION['success'] = "Đã thêm sinh viên $name thành công";
            header('location: /');
            exit;
        }
        // lưu thất bạ
        $_SESSION['error'] = $studentRepository->error;
        header('location: /');
    }

    public function edit()
    {
        $id = $_GET['id'];
        $studentRepository = new StudentRepository();
        $student = $studentRepository->find($id);
        require 'view/student/edit.php';
    }

    public function update()
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $birthday = $_POST['birthday'];
        $gender = $_POST['gender'];

        // Lấy student từ database
        $studentRepository = new StudentRepository();
        $student = $studentRepository->find($id);

        // Cập nhật giá trị từ người dùng vào object student
        $student->name = $name;
        $student->birthday = $birthday;
        $student->gender = $gender;

        // Update đối tượng này vào database
        if ($studentRepository->update($student)) {
            // lưu thành công
            $_SESSION['success'] = "Đã cập nhật sinh viên $name thành công";
            header('location: /');
            exit;
        }
        // lưu thất bạ
        $_SESSION['error'] = $studentRepository->error;
        header('location: /');
    }

    public function destroy()
    {
        $id = $_GET['id'];
        // Lấy student từ database
        $studentRepository = new StudentRepository();
        $student = $studentRepository->find($id);
        $name = $student->name;

        // kiểm tra sinh viên này đã đăng ký môn học chưa?
        $registerRepository = new RegisterRepository();
        $registers = $registerRepository->getByStudentId($id);
        $number = count($registers);
        if ($number > 0) {
            $_SESSION['error'] = "Sinh viên $name đã đăng ký $number môn học. Không thể xóa";
            header('location: /');
            exit;
        }

        // Update đối tượng này vào database
        if ($studentRepository->delete($id)) {
            // lưu thành công
            $_SESSION['success'] = "Đã xóa sinh viên $name thành công";
            header('location: /');
            exit;
        }
        // lưu thất bại
        $_SESSION['error'] = $studentRepository->error;
        header('location: /');

    }
}
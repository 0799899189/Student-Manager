<?php
class RegisterRepository
{
    // lưu lại lỗi trong quá trình thực thi câu lệnh sql (nếu có)
    public $error;
    // Lấy các dòng dữ liệu trong bảng register chuyển thành danh sách các đối tượng register
    public function fetch($cond = null)
    {
        // rule: bên trong hàm không nhìn thấy biến bên ngoài hàm
        // để nhìn thấy biến bên ngoài hàm, ta dùng từ khóa global
        global $conn;
        $sql = 'SELECT register.*, student.name AS student_name, subject.name AS subject_name FROM register
        JOIN student ON register.student_id = student.id
        JOIN subject ON register.subject_id = subject.id';
        if ($cond) {
            $sql .= " WHERE $cond";
            // SELECT * FROM register WHERE student_id LIKE '%tý%'
        }
        $result = $conn->query($sql);
        $registers = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $student_id = $row['student_id'];
                $subject_id = $row['subject_id'];
                $score = $row['score'];
                $student_name = $row['student_name'];
                $subject_name = $row['subject_name'];
                // chuyển dữ liệu 1 dòng trong database thành 1 đối tượng register
                $register = new Register($id, $student_id, $subject_id, $score, $student_name, $subject_name);
                // Thêm 1 đối tượng register cuối danh sách
                $registers[] = $register;
            }
        }
        return $registers;
    }

    public function getAll()
    {
        return $this->fetch();
    }

    public function getByPattern($search)
    {
        $cond = "student_id LIKE '%$search%'";
        return $this->fetch($cond);
    }

    // nếu thành công trả về true
    // nếu thất bại trả về false và nội dung lỗi.
    public function save($data)
    {
        global $conn;
        $student_id = $data['student_id'];
        $subject_id = $data['subject_id'];

        $sql = "INSERT INTO register (student_id, subject_id) VALUES('$student_id', '$subject_id')";
        if ($conn->query($sql)) {
            // thành công
            return true;
        }
        // thất bại
        $this->error = "Error: $sql " . $conn->error;
        return false;
    }

    // Trả về 1 đối tượng register dựa vào id cụ thể
    public function find($id)
    {
        $cond = "register.id = $id";
        $registers = $this->fetch($cond);
        // tương tự $register = $registers[0];
        $register = current($registers);
        return $register;
    }

    // cập nhật môn học đã có sẵn với dữ liệu mới
    public function update($register)
    {
        global $conn;
        $id = $register->id;
        $score = $register->score;

        $sql = "UPDATE register SET score=$score WHERE id=$id";
        if ($conn->query($sql)) {
            // thành công
            return true;
        }
        // thất bại
        $this->error = "Error: $sql " . $conn->error;
        return false;
    }

    // xóa môn học trong database dựa vào id cụ thể
    public function delete($id)
    {
        global $conn;
        $sql = "DELETE FROM register WHERE id=$id";
        if ($conn->query($sql)) {
            // thành công
            return true;
        }
        // thất bại
        $this->error = "Error: $sql " . $conn->error;
        return false;
    }

    // lấy danh sách đăng ký môn học của 1 sinh viên cụ thể
    public function getByStudentId($student_id)
    {
        $cond = "student_id=$student_id";
        $registers = $this->fetch($cond);
        return $registers;
    }

    // lấy danh sách đăng ký sinh viên của 1 môn học cụ thể
    public function getBySubjectId($subject_id)
    {
        $cond = "subject_id=$subject_id";
        $registers = $this->fetch($cond);
        return $registers;
    }
}
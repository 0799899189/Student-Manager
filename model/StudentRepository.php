<?php
class StudentRepository
{
    // lưu lại lỗi trong quá trình thực thi câu lệnh sql (nếu có)
    public $error;
    // Lấy các dòng dữ liệu trong bảng student chuyển thành danh sách các đối tượng student
    public function fetch($cond = null)
    {
        // rule: bên trong hàm không nhìn thấy biến bên ngoài hàm
        // để nhìn thấy biến bên ngoài hàm, ta dùng từ khóa global
        global $conn;
        $sql = 'SELECT * FROM student';
        if ($cond) {
            $sql .= " WHERE $cond";
            // SELECT * FROM student WHERE name LIKE '%tý%'
        }
        $result = $conn->query($sql);
        $students = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $name = $row['name'];
                $birthday = $row['birthday'];
                $gender = $row['gender'];
                // chuyển dữ liệu 1 dòng trong database thành 1 đối tượng student
                $student = new Student($id, $name, $birthday, $gender);
                // Thêm 1 đối tượng student cuối danh sách
                $students[] = $student;
            }
        }
        return $students;
    }

    public function getAll()
    {
        return $this->fetch();
    }

    public function getByPattern($search)
    {
        $cond = "name LIKE '%$search%'";
        return $this->fetch($cond);
    }

    // nếu thành công trả về true
    // nếu thất bại trả về false và nội dung lỗi.
    public function save($data)
    {
        global $conn;
        $name = $data['name'];
        $birthday = $data['birthday'];
        $gender = $data['gender'];
        $sql = "INSERT INTO student (name, birthday, gender) VALUES('$name', '$birthday', '$gender')";
        if ($conn->query($sql)) {
            // thành công
            return true;
        }
        // thất bại
        $this->error = "Error: $sql " . $conn->error;
        return false;
    }

    // Trả về 1 đối tượng student dựa vào id cụ thể
    public function find($id)
    {
        $cond = "id = $id";
        $students = $this->fetch($cond);
        // tương tự $student = $students[0];
        $student = current($students);
        return $student;
    }

    // cập nhật sinh viên đã có sẵn với dữ liệu mới
    public function update($student)
    {
        global $conn;
        $id = $student->id;
        $name = $student->name;
        $birthday = $student->birthday;
        $gender = $student->gender;

        $sql = "UPDATE student SET name='$name', birthday='$birthday', gender='$gender' WHERE id=$id";
        if ($conn->query($sql)) {
            // thành công
            return true;
        }
        // thất bại
        $this->error = "Error: $sql " . $conn->error;
        return false;
    }

    // xóa sinh viên trong database dựa vào id cụ thể
    public function delete($id)
    {
        global $conn;
        $sql = "DELETE FROM student WHERE id=$id";
        if ($conn->query($sql)) {
            // thành công
            return true;
        }
        // thất bại
        $this->error = "Error: $sql " . $conn->error;
        return false;
    }
}

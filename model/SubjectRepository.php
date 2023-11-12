<?php
class SubjectRepository
{
    // lưu lại lỗi trong quá trình thực thi câu lệnh sql (nếu có)
    public $error;
    // Lấy các dòng dữ liệu trong bảng subject chuyển thành danh sách các đối tượng subject
    public function fetch($cond = null)
    {
        // rule: bên trong hàm không nhìn thấy biến bên ngoài hàm
        // để nhìn thấy biến bên ngoài hàm, ta dùng từ khóa global
        global $conn;
        $sql = 'SELECT * FROM subject';
        if ($cond) {
            $sql .= " WHERE $cond";
            // SELECT * FROM subject WHERE name LIKE '%tý%'
        }
        $result = $conn->query($sql);
        $subjects = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $name = $row['name'];
                $number_of_credit = $row['number_of_credit'];
                // chuyển dữ liệu 1 dòng trong database thành 1 đối tượng subject
                $subject = new Subject($id, $name, $number_of_credit);
                // Thêm 1 đối tượng subject cuối danh sách
                $subjects[] = $subject;
            }
        }
        return $subjects;
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
        $number_of_credit = $data['number_of_credit'];

        $sql = "INSERT INTO subject (name, number_of_credit) VALUES('$name', '$number_of_credit')";
        if ($conn->query($sql)) {
            // thành công
            return true;
        }
        // thất bại
        $this->error = "Error: $sql " . $conn->error;
        return false;
    }

    // Trả về 1 đối tượng subject dựa vào id cụ thể
    public function find($id)
    {
        $cond = "id = $id";
        $subjects = $this->fetch($cond);
        // tương tự $subject = $subjects[0];
        $subject = current($subjects);
        return $subject;
    }

    // cập nhật môn học đã có sẵn với dữ liệu mới
    public function update($subject)
    {
        global $conn;
        $id = $subject->id;
        $name = $subject->name;
        $number_of_credit = $subject->number_of_credit;

        $sql = "UPDATE subject SET name='$name', number_of_credit='$number_of_credit' WHERE id=$id";
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
        $sql = "DELETE FROM subject WHERE id=$id";
        if ($conn->query($sql)) {
            // thành công
            return true;
        }
        // thất bại
        $this->error = "Error: $sql " . $conn->error;
        return false;
    }
}

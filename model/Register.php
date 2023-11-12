<?php
// Tạo class (khuông bánh)
class Register
{
    // tạo 4 thuộc tính (có tên nhưng chưa có giá trị)
    public $id;
    public $student_id;
    public $subject_id;
    public $score;
    public $student_name;
    public $subject_name;

    // Hàm xây dựng đối tượng
    public function __construct($id, $student_id, $subject_id, $score, $student_name, $subject_name)
    {
        $this->id = $id;
        $this->student_id = $student_id;
        $this->subject_id = $subject_id;
        $this->score = $score;
        $this->student_name = $student_name;
        $this->subject_name = $subject_name;
    }
}
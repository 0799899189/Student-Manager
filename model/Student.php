<?php
// Tạo class (khuông bánh)
class Student
{
    // tạo 4 thuộc tính (có tên nhưng chưa có giá trị)
    public $id;
    public $name;
    public $birthday;
    public $gender;

    // Hàm xây dựng đối tượng
    public function __construct($id, $name, $birthday, $gender)
    {
        $this->id = $id;
        $this->name = $name;
        $this->birthday = $birthday;
        $this->gender = $gender;
    }

}

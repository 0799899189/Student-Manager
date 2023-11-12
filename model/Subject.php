<?php
// Tạo class (khuông bánh)
class Subject
{
    // tạo 4 thuộc tính (có tên nhưng chưa có giá trị)
    public $id;
    public $name;
    public $number_of_credit;

    // Hàm xây dựng đối tượng
    public function __construct($id, $name, $number_of_credit)
    {
        $this->id = $id;
        $this->name = $name;
        $this->number_of_credit = $number_of_credit;
    }

}

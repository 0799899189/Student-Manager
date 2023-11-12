// jqClick
$('button.destroy').click(function (e) {
	e.preventDefault();
	// lấy giá trị thuộc tính data-href của button được click và gán vào hằng dataHref
	// this là button được click
	// attr là attribute
	const dataHref = $(this).attr('data-href');
	// cập nhật giá trị trong dataHref vào href của thẻ a trong modal
	$('#exampleModal a').attr('href', dataHref);
});

$(".form-student-create,.form-student-edit").validate({
	rules: {
		// simple rule, converted to {required:true}
		name: {
			required: true,
			maxlength: 50,
			// regular expression (biểu thức chính quy)
			// con gà 2 => false
			regex: /^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+$/i
		},
		birthday: {
			required: true,
		},

		gender: {
			required: true,
		}
	},
	messages: {
		// simple rule, converted to {required:true}
		name: {
			required: 'Vui lòng nhập họ và tên',
			maxlength: 'Vui lòng không nhập quá 50 ký tự',
			regex: 'Vui lòng không nhập số hoặc ký tự đặc biệt'
		},
		birthday: {
			required: 'Vui lòng chọn ngày sinh',
		},
		gender: {
			required: 'Vui lòng chọn giới tính',
		}
	}
});

$(".form-subject-create,.form-subject-edit").validate({
	rules: {
		// simple rule, converted to {required:true}
		name: {
			required: true,
			maxlength: 50,
		},
		number_of_credit: {
			required: true,
			digits: true,
			range: [1, 10]
		},
	},
	messages: {
		// simple rule, converted to {required:true}
		name: {
			required: 'Vui lòng nhập tên môn học',
			maxlength: 'Vui lòng không nhập quá 50 ký tự',
		},
		number_of_credit: {
			required: 'Vui lòng nhập số tín chỉ',
			digits: 'Vui lòng nhập con số nguyên',
			range: 'Vui lòn nhập con số từ 1 đến 10'
		}
	}
});

$(".form-register-create").validate({
	rules: {
		// simple rule, converted to {required:true}
		student_id: {
			required: true,
		},
		subject_id: {
			required: true,
		},
	},
	messages: {
		// simple rule, converted to {required:true}
		student_id: {
			required: 'Vui lòng chọn sinh viên',
		},
		subject_id: {
			required: 'Vui lòng chọn môn học'
		}
	}
});

$(".form-register-edit").validate({
	rules: {
		// simple rule, converted to {required:true}
		score: {
			required: true,
			range: [0, 10]
		}
	},
	messages: {
		// simple rule, converted to {required:true}
		score: {
			required: 'Vui lòng nhập điểm',
			range: 'Vui lòng nhập con số từ 0 đến 10'
		}
	}
});


$.validator.addMethod(
	"regex",
	function (value, element, regexp) {
		var re = new RegExp(regexp);
		return this.optional(element) || re.test(value);
	},
	"Please check your input."
);
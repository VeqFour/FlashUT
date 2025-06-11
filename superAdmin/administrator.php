<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once  '../includes/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'superadmin') {
    header("Location: ../login.php");
    exit();
}

$collegeQuery = "SELECT department_id, department_name FROM departments";
$collegeResult = mysqli_query($conn, $collegeQuery);



$colleges = [];
if ($collegeResult) {
    while ($row = mysqli_fetch_assoc($collegeResult)) {
        $colleges[] = $row;
    }
} else {
    die("Failed to fetch colleges");
}

$semesterQuery = "SELECT semester_id, semester_name FROM semesters";
$semesterResult = mysqli_query($conn, $semesterQuery);

$semesters = [];
if ($semesterResult) {
    while ($row = mysqli_fetch_assoc($semesterResult)) {
        $semesters[] = $row;
    }
} else {
    die("Failed to fetch semesters");
}
?>

<title>Administrator Panel</title>

<style>
body {
    font-family: 'Baloo Bhai 2', sans-serif;
    background: #f8f8f8;
    margin: 0;
    padding: 20px;
}
h1 {
    text-align: center;
    color: #9A2828;
}
.admin-section {
    background: white;
    border-radius: 12px;
    box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
    margin: 20px auto;
    padding: 20px;
    max-width: 1000px;
}
.admin-section h2 {
    color: #9A2828;
}
select, button {
    padding: 8px;
    margin: 5px 0;
    border-radius: 5px;
    width: 100%;
}
button {
    background-color: #9A2828;
    color: white;
    border: none;
    cursor: pointer;
}
button:hover {
    background-color: #7a2020;
}
</style>

<h1>Administrator Panel</h1>
<div style="text-align: center;">
    <a href="../controllers/logout.php" style="background-color: #9A2828; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none;">Logout</a>
</div>
<?php if (isset($_GET['message'])): ?>
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin: 10px 0; text-align: center;">
        <?= htmlspecialchars($_GET['message']) ?>
    </div>
<?php elseif (isset($_GET['error'])): ?>
    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin: 10px 0; text-align: center;">
        <?= htmlspecialchars($_GET['error']) ?>
    </div>
<?php endif; ?>

<!-- STUDENT ASSIGN -->
<div class="admin-section">
    <h2>Assign Student to Section</h2>
    <form action="actions/assign_student.php" method="POST">

        <label>College:</label><br>
        <select name="department" onchange="filterStudentsByDepartment(this.value)">
            <option value="">Select College</option>
            <?php foreach ($colleges as $college): ?>
                <option value="<?= htmlspecialchars($college['department_id']) ?>">
                    <?= htmlspecialchars($college['department_name']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Student:</label><br>
        <select name="student_id" id="studentSelect" onchange="filterSectionsForStudent(this.value)">
            <option value="">Select student</option>
        </select><br><br>

        <label>Section:</label><br>
        <select name="section_id" id="sectionSelect">
            <option value="">Select Section</option>
        </select><br><br>

        <button type="submit">Assign</button>
    </form>
</div>

<!-- UNASSIGN STUDENT FROM SECTION -->
<div class="admin-section">
    <h2>Unassign Student from Section</h2>
    <form action="actions/unassign_student.php" method="POST">

        <label>College:</label><br>
        <select name="department_id" onchange="filterStudentsForUnassign(this.value)" required>
            <option value="">Select College</option>
            <?php foreach ($colleges as $college): ?>
                <option value="<?= htmlspecialchars($college['department_id']) ?>">
                    <?= htmlspecialchars($college['department_name']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Student:</label><br>
        <select name="student_id" id="unassignStudentSelect" onchange="filterStudentSections(this.value)" required>
            <option value="">Select Student</option>
        </select><br><br>

        <label>Section:</label><br>
        <select name="section_id" id="unassignStudentSectionSelect" required>
            <option value="">Select Section</option>
        </select><br><br>

        <button type="submit" style="background-color: #a94442;">Unassign Section</button>
    </form>
</div>

<!-- INSTRUCTOR ASSIGN -->
<div class="admin-section">
    <h2>Assign Instructor to Section</h2>
    <form action="actions/assign_instructor.php" method="POST">

    <label>College:</label><br>
<select name="instructor_department" onchange="filterInstructorsByDepartment(this.value)">
    <option value="">Select College</option>
    <?php foreach ($colleges as $college): ?>
        <option value="<?= htmlspecialchars($college['department_id']) ?>">
            <?= htmlspecialchars($college['department_name']) ?>
        </option>
    <?php endforeach; ?>
</select><br><br>

<label>Instructor (Admin):</label><br>
<select name="admin_id" id="adminSelect" onchange="filterSectionsForInstructor(this.value)">
    <option value="">Select Instructor</option>
</select><br><br>

<label>Section:</label><br>
<select name="section_id" id="sectionSelectInstructor">
    <option value="">Select Section</option>
</select><br><br>
        <button type="submit">Assign</button>
    </form>
</div>


<!-- UNASSIGN INSTRUCTOR FROM SECTION -->
<div class="admin-section">
    <h2>Unassign Instructor from Section</h2>
    <form action="actions/unassign_instructor.php" method="POST">

        <label>College:</label><br>
        <select name="department_id" onchange="filterInstructorsForUnassign(this.value)" required>
            <option value="">Select College</option>
            <?php foreach ($colleges as $college): ?>
                <option value="<?= htmlspecialchars($college['department_id']) ?>">
                    <?= htmlspecialchars($college['department_name']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Instructor:</label><br>
        <select name="admin_id" id="unassignInstructorSelect" onchange="filterInstructorSections(this.value)" required>
            <option value="">Select Instructor</option>
        </select><br><br>

        <label>Section:</label><br>
        <select name="section_id" id="unassignSectionSelect" required>
            <option value="">Select Section</option>
        </select><br><br>

        <button type="submit" style="background-color: #a94442;">Unassign Section</button>
    </form>
</div>

<!-- ADD SECTIONS -->
<div class="admin-section">
    <h2>Add New Course</h2>
    <form action="actions/add_course.php" method="POST" enctype="multipart/form-data">

        <label>College:</label><br>
        <select name="department_id" required>
            <option value="">Select College</option>
            <?php foreach ($colleges as $college): ?>
                <option value="<?= htmlspecialchars($college['department_id']) ?>">
                    <?= htmlspecialchars($college['department_name']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Course Name:</label><br>
        <input type="text" name="course_name" placeholder="e.g., Computer Networks" required><br><br>

        <label>Course Image (JPG/PNG):</label><br>
        <input type="file" name="course_image" accept="image/*" required><br><br>

        <button type="submit">Add Course</button>
    </form>
</div>

<!-- CREATE SECTIONS -->

<div class="admin-section">
    <h2>Create Section for a Course</h2>
    <form action="actions/create_section.php" method="POST">

        <label>College:</label><br>
        <select name="department_id" onchange="filterCoursesByDepartment(this.value)" required>
            <option value="">Select College</option>
            <?php foreach ($colleges as $college): ?>
                <option value="<?= htmlspecialchars($college['department_id']) ?>">
                    <?= htmlspecialchars($college['department_name']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Course:</label><br>
        <select name="course_id" id="courseSelect" required>
            <option value="">Select Course</option>
        </select><br><br>

        <label>Section Name:</label><br>
        <input type="text" name="section_name" placeholder="e.g., Section A or Group 1" required><br><br>

        <label>Semester:</label><br>
<select name="semester_id" required>
    <option value="">Select Semester</option>
    <?php foreach ($semesters as $semester): ?>
        <option value="<?= htmlspecialchars($semester['semester_id']) ?>">
            <?= htmlspecialchars($semester['semester_name']) ?>
        </option>
    <?php endforeach; ?>
</select><br><br>

        <button type="submit">Create Section</button>
    </form>
</div>

<!-- ADD Instructor -->

<div class="admin-section">
    <h2>Add New Instructor (Admin)</h2>
    <form action="actions/add_instructor.php" method="POST">

        <label>First Name:</label><br>
        <input type="text" name="firstName" required><br><br>

        <label>Last Name:</label><br>
        <input type="text" name="lastName" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Academic ID:</label><br>
        <input type="text" name="academicID" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>College:</label><br>
        <select name="department_id" required>
            <option value="">Select College</option>
            <?php foreach ($colleges as $college): ?>
                <option value="<?= htmlspecialchars($college['department_id']) ?>">
                    <?= htmlspecialchars($college['department_name']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">Add Instructor</button>
    </form>
</div>

<!-- DELETE INSTRUCTOR -->
<div class="admin-section">
    <h2>Delete Instructor</h2>
    <form action="actions/delete_instructor.php" method="POST">

        <label>College:</label><br>
        <select name="department_id" onchange="filterInstructorsForDelete(this.value)" required>
            <option value="">Select College</option>
            <?php foreach ($colleges as $college): ?>
                <option value="<?= htmlspecialchars($college['department_id']) ?>">
                    <?= htmlspecialchars($college['department_name']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Instructor:</label><br>
        <select name="admin_id" id="deleteInstructorSelect" required>
            <option value="">Select Instructor</option>
        </select><br><br>

        <button type="submit" style="background-color: #a94442;">Delete Instructor</button>
    </form>
</div>



<script>
let selectedDepartment = '';

function filterStudentsByDepartment(department) {
    selectedDepartment = department; 
    fetch('actions/get_students.php?department_id=' + department)
    .then(res => res.json())
    .then(data => {
        const studentSelect = document.getElementById('studentSelect');
        studentSelect.innerHTML = '<option value="">Select student</option>';
        data.forEach(student => {
            const option = document.createElement('option');
            option.value = student.user_id;
            option.textContent = student.firstName + ' ' + student.lastName + ' (' + student.academicID + ')';
            studentSelect.appendChild(option);
        });

        document.getElementById('sectionSelect').innerHTML = '<option value="">Select Section</option>';
    });
}

function filterSectionsForStudent(studentId) {
    if (!studentId || !selectedDepartment) return;

    fetch(`actions/get_sections.php?student_id=${studentId}&department_id=${selectedDepartment}`)
    .then(res => res.json())
    .then(data => {
        const sectionSelect = document.getElementById('sectionSelect');
        sectionSelect.innerHTML = '<option value="">Select Section</option>';
        data.forEach(section => {
            const option = document.createElement('option');
            option.value = section.section_id;
            option.textContent = section.section_name + ' (' + section.course_name + ')';
            sectionSelect.appendChild(option);
        });
    });
}

function filterStudentsForUnassign(department) {
    fetch('actions/get_students.php?department_id=' + department)
    .then(res => res.json())
    .then(data => {
        const select = document.getElementById('unassignStudentSelect');
        select.innerHTML = '<option value="">Select Student</option>';
        data.forEach(student => {
            const option = document.createElement('option');
            option.value = student.user_id;
            option.textContent = student.firstName + ' ' + student.lastName + ' (' + student.academicID + ')';
            select.appendChild(option);
        });
    });
}

function filterStudentSections(studentId) {
    fetch(`actions/get_sections_assigned.php?student_id=${studentId}`)
    .then(res => res.json())
    .then(data => {
        const select = document.getElementById('unassignStudentSectionSelect');
        select.innerHTML = '<option value="">Select Section</option>';
        data.forEach(section => {
            const option = document.createElement('option');
            option.value = section.section_id;
            option.textContent = section.section_name + ' (' + section.course_name + ')';
            select.appendChild(option);
        });
    });
}







// INSTRUCTOR FILTERING

let selectedInstructorDepartment = '';

function filterInstructorsByDepartment(department) {
    selectedInstructorDepartment = department;

    fetch('actions/get_instructors.php?department_id=' + department)
    .then(res => res.json())
    .then(data => {
        const adminSelect = document.getElementById('adminSelect');
        adminSelect.innerHTML = '<option value="">Select Instructor</option>';
        data.forEach(admin => {
            const option = document.createElement('option');
            option.value = admin.user_id;
            option.textContent = admin.firstName + ' ' + admin.lastName + ' (' + admin.email + ')';
            adminSelect.appendChild(option);
        });

        document.getElementById('sectionSelectInstructor').innerHTML = '<option value="">Select Section</option>';
    });
}

function filterSectionsForInstructor(adminId) {
    if (!adminId || !selectedInstructorDepartment) return;

    fetch(`actions/get_sections_instructor.php?admin_id=${adminId}&department_id=${selectedInstructorDepartment}`)
    .then(res => res.json())
    .then(data => {
        const sectionSelect = document.getElementById('sectionSelectInstructor');
        sectionSelect.innerHTML = '<option value="">Select Section</option>';
        data.forEach(section => {
            const option = document.createElement('option');
            option.value = section.section_id;
            option.textContent = section.section_name + ' (' + section.course_name + ')';
            sectionSelect.appendChild(option);
        });
    });
}



function filterCoursesByDepartment(departmentId) {
    fetch('actions/get_courses.php?department_id=' + departmentId)
    .then(res => res.json())
    .then(data => {
        const courseSelect = document.getElementById('courseSelect');
        courseSelect.innerHTML = '<option value="">Select Course</option>';
        data.forEach(course => {
            const option = document.createElement('option');
            option.value = course.course_id;
            option.textContent = course.course_name;
            courseSelect.appendChild(option);
        });
    });
}


// DELETE instructor
function filterInstructorsForDelete(department) {
    fetch('actions/get_instructors.php?department_id=' + department)
    .then(res => res.json())
    .then(data => {
        const deleteSelect = document.getElementById('deleteInstructorSelect');
        deleteSelect.innerHTML = '<option value="">Select Instructor</option>';
        data.forEach(admin => {
            const option = document.createElement('option');
            option.value = admin.user_id;
            option.textContent = admin.firstName + ' ' + admin.lastName + ' (' + admin.email + ')';
            deleteSelect.appendChild(option);
        });
    });
}

// UNASSIGN instructor sections
function filterInstructorsForUnassign(department) {
    fetch('actions/get_instructors.php?department_id=' + department)
    .then(res => res.json())
    .then(data => {
        const unassignSelect = document.getElementById('unassignInstructorSelect');
        unassignSelect.innerHTML = '<option value="">Select Instructor</option>';
        data.forEach(admin => {
            const option = document.createElement('option');
            option.value = admin.user_id;
            option.textContent = admin.firstName + ' ' + admin.lastName + ' (' + admin.email + ')';
            unassignSelect.appendChild(option);
        });
    });
}

function filterInstructorSections(adminId) {
    fetch(`actions/get_sections_assigned.php?admin_id=${adminId}`)
    .then(res => res.json())
    .then(data => {
        const sectionSelect = document.getElementById('unassignSectionSelect');
        sectionSelect.innerHTML = '<option value="">Select Section</option>';
        data.forEach(section => {
            const option = document.createElement('option');
            option.value = section.section_id;
            option.textContent = section.section_name + ' (' + section.course_name + ')';
            sectionSelect.appendChild(option);
        });
    });
}

</script>
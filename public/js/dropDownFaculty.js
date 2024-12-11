function filterDepartments() {
    const facultySelect = document.getElementById("faculty_id");
    const departmentSelect = document.getElementById("department_id");
    const departments = window.departments || [];  // Using window.departments to pass the data from Blade

    // Get selected faculty ID
    const selectedFacultyId = facultySelect.value;

    // Clear department options
    departmentSelect.innerHTML = '<option value="">--Select Department--</option>';

    // If a faculty is selected, filter the departments accordingly
    const filteredDepartments = selectedFacultyId
        ? departments.filter(department => department.faculty_id == selectedFacultyId)
        : departments;

    // Populate department dropdown with filtered or all departments
    filteredDepartments.forEach(department => {
        const option = document.createElement("option");
        option.value = department.id;
        option.textContent = `${department.code} - ${department.name}`;
        departmentSelect.appendChild(option);
    });

    // Ensure the previously selected department is still selected
    const selectedDepartmentId = departmentSelect.getAttribute('data-selected-department');
    if (selectedDepartmentId) {
        departmentSelect.value = selectedDepartmentId;
    }
}

// Initialize when the page is loaded
document.addEventListener("DOMContentLoaded", () => {
    const departmentSelect = document.getElementById("department_id");

    // Set data attribute to remember the initially selected department
    const selectedDepartment = departmentSelect.querySelector('option[selected]');
    if (selectedDepartment) {
        departmentSelect.setAttribute('data-selected-department', selectedDepartment.value);
    }

    // Call the filter function on page load to populate the department options
    filterDepartments();
});

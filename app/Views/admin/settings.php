<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - User Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="csrf-name" content="<?= csrf_token() ?>">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-900">Settings</h1>
                    <a href="<?= site_url('applications') ?>" class="text-blue-600 hover:text-blue-800">
                        ← Back to Applications
                    </a>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Add User Form -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Add New User</h2>
                    
                    <form id="addUserForm" class="space-y-6">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">First Name</label>
                                <input type="text" name="first_name" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Last Name</label>
                                <input type="text" name="last_name" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="password" name="password" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Role</label>
                                <select name="role" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select Role</option>
                                    <option value="hr">HR</option>
                                    <option value="interviewer">Interviewer</option>
                                </select>
                            </div>

                            <div id="typeDropdown" style="display: none;">
                                <label class="block text-sm font-medium text-gray-700">Department</label>
                                <select name="department" id="departmentSelect" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="">Select Department</option>
                                    <option value="tech">Tech</option>
                                    <option value="non_tech">Non Tech</option>
                                    <option value="add_department">+ Add Department...</option>
                                </select>
                                <input type="text" id="newDepartmentInput" style="display:none; margin-top: 8px;" placeholder="Enter new department" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <button type="button" id="saveDepartmentBtn" style="display:none; margin-top: 8px;" class="px-3 py-1 rounded bg-blue-600 text-white hover:bg-blue-700">Save</button>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Location</label>
                                <select name="location" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select Location</option>
                                    <option value="Delhi">Delhi</option>
                                    <option value="Bhubaneswar">Bhubaneswar</option>
                                    <option value="Noida">Noida</option>
                                    <option value="Hyderabad">Hyderabad</option>
                                    <option value="Asansol">Asansol</option>
                                    <option value="Mohali">Mohali</option>   
  
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Add User
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Users List -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Existing Users</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="usersList">
                                <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?= esc($user['first_name']) . ' ' . esc($user['last_name']) ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?= esc($user['email']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            <?= $user['role'] === 'hr' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' ?>">
                                            <?= ucfirst(esc($user['role'])) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?= esc($user['location']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button onclick="openEditUserModal(<?= htmlspecialchars(json_encode($user), ENT_QUOTES, 'UTF-8') ?>)" class="text-blue-600 hover:text-blue-900 mr-2">Edit</button>
                                        <button onclick="deleteUser(<?= $user['id'] ?>)" 
                                            class="text-red-600 hover:text-red-900">Delete</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-30">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg mx-auto">
            <h2 class="text-lg font-bold mb-4">Edit User</h2>
            <form id="editUserForm" class="space-y-4">
                <input type="hidden" name="id" id="editUserId">
                <div>
                    <label class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" name="first_name" id="editFirstName" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" name="last_name" id="editLastName" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="editEmail" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" id="editRole" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="hr">HR</option>
                        <option value="interviewer">Interviewer</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Location</label>
                    <select name="location" id="editLocation" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="Delhi">Delhi</option>
                        <option value="Bhubaneswar">Bhubaneswar</option>
                        <option value="Noida">Noida</option>
                        <option value="Hyderabad">Hyderabad</option>
                        <option value="Asansol">Asansol</option>
                        <option value="Mohali">Mohali</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeEditUserModal()" class="mr-2 px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('addUserForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            // Add CSRF token
            const csrfName = document.querySelector('meta[name="csrf-name"]').getAttribute('content');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            formData.append(csrfName, csrfToken);

            fetch('<?= site_url('admin/add-user') ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('User added successfully');
                    window.location.reload();
                } else {
                    alert(data.message || 'Failed to add user');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to add user');
            });
        });

        document.querySelector('select[name="role"]').addEventListener('change', function() {
            const typeDropdown = document.getElementById('typeDropdown');
            if (this.value === 'interviewer') {
                typeDropdown.style.display = 'block';
            } else {
                typeDropdown.style.display = 'none';
                document.getElementById('departmentSelect').value = '';
                document.getElementById('newDepartmentInput').style.display = 'none';
                document.getElementById('saveDepartmentBtn').style.display = 'none';
            }
        });

        const departmentSelect = document.getElementById('departmentSelect');
        const newDepartmentInput = document.getElementById('newDepartmentInput');
        const saveDepartmentBtn = document.getElementById('saveDepartmentBtn');

        departmentSelect.addEventListener('change', function() {
            if (this.value === 'add_department') {
                newDepartmentInput.style.display = 'inline-block';
                saveDepartmentBtn.style.display = 'inline-block';
            } else {
                newDepartmentInput.style.display = 'none';
                saveDepartmentBtn.style.display = 'none';
            }
        });

        saveDepartmentBtn.addEventListener('click', function() {
            const newDept = newDepartmentInput.value.trim();
            if (!newDept) return alert('Enter a department');
            // Add new option to dropdown
            const opt = document.createElement('option');
            opt.value = newDept;
            opt.text = newDept.charAt(0).toUpperCase() + newDept.slice(1);
            departmentSelect.insertBefore(opt, departmentSelect.querySelector('option[value="add_department"]'));
            departmentSelect.value = newDept;
            newDepartmentInput.value = '';
            newDepartmentInput.style.display = 'none';
            saveDepartmentBtn.style.display = 'none';
        });

        function deleteUser(userId) {
            if (!confirm('Are you sure you want to delete this user?')) {
                return;
            }

            

            const csrfName = document.querySelector('meta[name="csrf-name"]').getAttribute('content');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const formData = new FormData();
            formData.append('id', userId);
            formData.append(csrfName, csrfToken);

            fetch('<?= site_url('admin/delete-user') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('User deleted successfully');
                    window.location.reload();
                } else {
                    alert(data.message || 'Failed to delete user');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to delete user');
            });
        }

        function openEditUserModal(user) {
            document.getElementById('editUserId').value = user.id;
            document.getElementById('editFirstName').value = user.first_name;
            document.getElementById('editLastName').value = user.last_name;
            document.getElementById('editEmail').value = user.email;
            document.getElementById('editRole').value = user.role;
            document.getElementById('editLocation').value = user.location;
            document.getElementById('editUserModal').classList.remove('hidden');
            document.getElementById('editUserModal').classList.add('flex');
        }
        function closeEditUserModal() {
            document.getElementById('editUserModal').classList.add('hidden');
            document.getElementById('editUserModal').classList.remove('flex');
        }
        document.getElementById('editUserForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const csrfName = document.querySelector('meta[name="csrf-name"]').getAttribute('content');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            formData.append(csrfName, csrfToken);
            fetch('<?= site_url('admin/edit-user') ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('User updated successfully');
                    window.location.reload();
                } else {
                    alert(data.message || 'Failed to update user');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update user');
            });
        });
    </script>
</body>
</html> 
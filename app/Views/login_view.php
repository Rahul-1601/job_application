<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Super Admin Login - Job Application Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
  <div class="w-full max-w-md p-0 bg-transparent flex flex-col items-center">
    <div class="w-full bg-white rounded-lg shadow-md p-8">
      <h2 class="text-xl font-semibold text-center mb-6 text-gray-700">Select your role and sign in to continue</h2>
      <!-- Role Selection Tabs -->
      <div id="role-tabs" class="grid grid-cols-4 gap-2 mb-4">
        <button type="button" data-role="hr" class="role-tab py-2 rounded-t-lg bg-gray-100 text-gray-500 font-medium flex flex-col items-center">
          <span class="text-2xl mb-1">👤</span>
          HR
        </button>
        <button type="button" data-role="interviewer" class="role-tab py-2 rounded-t-lg bg-gray-100 text-gray-500 font-medium flex flex-col items-center">
          <span class="text-2xl mb-1">🗣️</span>
          Interviewer
        </button>
        <button type="button" data-role="admin" class="role-tab py-2 rounded-t-lg bg-gray-100 text-gray-500 font-medium flex flex-col items-center">
          <span class="text-2xl mb-1">🛡️</span>
          Admin
        </button>
        <button type="button" data-role="superadmin" class="role-tab py-2 rounded-t-lg bg-red-100 text-red-600 font-semibold flex flex-col items-center border-b-2 border-red-500">
          <span class="text-2xl mb-1">🛡️</span>
          Super Admin
        </button>
      </div>
      <!-- Super Admin Card -->
      <div id="role-card" class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6 flex items-center gap-4">
        <div class="text-3xl text-red-500">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-10 h-10"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.104.896-2 2-2s2 .896 2 2-.896 2-2 2-2-.896-2-2zm0 0V7m0 4v4m0 0c0 1.104-.896 2-2 2s-2-.896-2-2 .896-2 2-2 2 .896 2 2z" /></svg>
        </div>
        <div class="flex-1">
          <div class="text-lg font-bold text-red-700" id="role-title">Super Administrator</div>
          <div class="text-gray-700 text-sm" id="role-desc">Full system access and configuration</div>
        </div>
        <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full border border-red-200" id="role-badge">SUPER-ADMIN</span>
      </div>
      <!-- Login Form -->
      <form method="post" action="<?= site_url('auth/login') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="role" id="role-input" value="superadmin">
        <div class="mb-4">
          <label class="block text-sm font-semibold mb-1">Email Address</label>
          <input type="email" name="email" placeholder="Enter your super-admin email" class="w-full border rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-300" required value="<?= old('email') ?>">
          <?php if (session()->getFlashdata('errors')['email'] ?? false): ?>
            <div class="text-red-600 text-sm mt-1">
              <?= session()->getFlashdata('errors')['email'] ?>
            </div>
          <?php endif; ?>
        </div>
        <div class="mb-6">
          <label class="block text-sm font-semibold mb-1">Password</label>
          <input type="password" name="password" placeholder="Enter your password" class="w-full border rounded px-4 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
          <?php if (session()->getFlashdata('errors')['password'] ?? false): ?>
            <div class="text-red-600 text-sm mt-1">
              <?= session()->getFlashdata('errors')['password'] ?>
            </div>
          <?php endif; ?>
        </div>
        <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded font-semibold flex items-center justify-center gap-2 hover:bg-red-700 transition">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.104.896-2 2-2s2 .896 2 2-.896 2-2 2-2-.896-2-2zm0 0V7m0 4v4m0 0c0 1.104-.896 2-2 2s-2-.896-2-2 .896-2 2-2 2 .896 2 2z" /></svg>
          Sign in as <span id="role-btn-label">Super Administrator</span>
        </button>
      </form>
    </div>
  </div>
  <script>
    // Role data for card and button
    const roleData = {
      hr: {
        title: 'HR',
        desc: 'Manage applicants and recruitment process',
        badge: 'HR',
        card: 'bg-blue-50 border-blue-200 text-blue-700',
        btn: 'HR',
        color: 'blue'
      },
      interviewer: {
        title: 'Interviewer',
        desc: 'Schedule and conduct interviews',
        badge: 'INTERVIEWER',
        card: 'bg-green-50 border-green-200 text-green-700',
        btn: 'Interviewer',
        color: 'green'
      },
      admin: {
        title: 'Administrator',
        desc: 'System administration and user management',
        badge: 'ADMIN',
        card: 'bg-yellow-50 border-yellow-200 text-yellow-700',
        btn: 'Administrator',
        color: 'yellow'
      },
      superadmin: {
        title: 'Super Administrator',
        desc: 'Full system access and configuration',
        badge: 'SUPER-ADMIN',
        card: 'bg-red-50 border-red-200 text-red-700',
        btn: 'Super Administrator',
        color: 'red'
      }
    };
    const tabs = document.querySelectorAll('.role-tab');
    const roleInput = document.getElementById('role-input');
    const card = document.getElementById('role-card');
    const title = document.getElementById('role-title');
    const desc = document.getElementById('role-desc');
    const badge = document.getElementById('role-badge');
    const btnLabel = document.getElementById('role-btn-label');
    tabs.forEach(tab => {
      tab.addEventListener('click', function() {
        tabs.forEach(t => t.className = t.className.replace(/bg-\w+-100|text-\w+-600|font-semibold|border-b-2 border-\w+-500/g, 'bg-gray-100 text-gray-500 font-medium'));
        this.className = this.className.replace('bg-gray-100 text-gray-500 font-medium', '');
        this.classList.add('font-semibold', `bg-${roleData[this.dataset.role].color}-100`, `text-${roleData[this.dataset.role].color}-600`, `border-b-2`, `border-${roleData[this.dataset.role].color}-500`);
        roleInput.value = this.dataset.role;
        // Update card
        card.className = `flex items-center gap-4 rounded-lg p-4 mb-6 border ${roleData[this.dataset.role].card}`;
        title.textContent = roleData[this.dataset.role].title;
        desc.textContent = roleData[this.dataset.role].desc;
        badge.textContent = roleData[this.dataset.role].badge;
        badge.className = `text-xs font-bold px-3 py-1 rounded-full border border-${roleData[this.dataset.role].color}-200 bg-${roleData[this.dataset.role].color}-100 text-${roleData[this.dataset.role].color}-700`;
        btnLabel.textContent = roleData[this.dataset.role].btn;
      });
    });
  </script>
</body>
</html>

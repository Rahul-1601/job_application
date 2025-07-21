<div id="applications-table-wrapper">
    <div class="bg-white dark:bg-gray-800 border border-blue-200 dark:border-gray-700 shadow-sm rounded-lg">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-blue-200 dark:border-gray-700">
                        <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white">ID</th>
                        <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white">Candidate</th>
                        <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white">Experience</th>
                        <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white">Salary</th>
                        <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white">Resume</th>
                        <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white">Applied Date</th>
                        <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white">Status</th>
                        <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white">Position</th>
                        <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white">Date</th>
                        <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white">Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applications as $index => $app): ?>
                        <?php
                            $statusColors = [
                                'Accepted' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
                                'Rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400',
                                'Under Review' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400',
                                'Interview Scheduled' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400',
                                'Pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400',
                            ];
                            $statusColor = $statusColors[$app['status']] ?? $statusColors['Pending'];
                        ?>
                        <tr class="border-b border-blue-100 dark:border-gray-700 hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-colors duration-200">
                            <td class="py-3 px-6 text-gray-900 dark:text-white"><?= esc($app['id']) ?></td>
                            <td class="py-3 px-6">
                                <div class="flex items-center space-x-3">
                                    <div class="h-10 w-10 bg-blue-600 rounded-full flex items-center justify-center">
                                        <span class="text-white text-sm font-medium">
                                            <?= strtoupper(substr($app['first_name'], 0, 1) . substr($app['last_name'], 0, 1)) ?>
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white"><?= esc($app['first_name']) ?> <?= esc($app['last_name']) ?></p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400"><?= esc($app['email']) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-6">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white"><?= esc(ucfirst($app['experience_level'])) ?></p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400"><?= esc($app['total_experience'] ?? 'N/A') ?></p>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-gray-900 dark:text-white"><?= esc($app['last_salary'] ?? 'N/A') ?></td>
                            <td class="py-3 px-6">
                                <div class="flex items-center space-x-2">
                                    <a href="<?= base_url('view-resume/' . $app['resume']) ?>" target="_blank" 
                                       class="h-8 w-8 p-0 hover:bg-blue-100 dark:hover:bg-blue-900/20 transition-colors duration-200 rounded-md flex items-center justify-center" 
                                       title="View Resume">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </a>
                                    <a href="<?= base_url('view-resume/' . $app['resume']) ?>" download 
                                       class="h-8 w-8 p-0 hover:bg-blue-100 dark:hover:bg-blue-900/20 transition-colors duration-200 rounded-md flex items-center justify-center" 
                                       title="Download Resume">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="7,10 12,15 17,10"></polyline>
                                            <line x1="12" y1="15" x2="12" y2="3"></line>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-gray-900 dark:text-white"><?= date('m/d/Y', strtotime($app['created_at'])) ?></td>
                            <td class="py-3 px-6">
                                <?php if ($app['status'] === 'Accepted'): ?>
                                    <span class="status-badge <?= $statusColor ?>">Accepted</span>
                                <?php else: ?>
                                    <select id="status_dropdown_<?= $app['id'] ?>"
                                            onchange="updateStatus(<?= $app['id'] ?>, this.value)"
                                            class="text-xs font-semibold rounded-full px-3 py-1 border-0 <?= $statusColor ?> cursor-pointer">
                                        <option value="Pending" <?= $app['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="Under Review" <?= $app['status'] === 'Under Review' ? 'selected' : '' ?>>Under Review</option>
                                        <option value="Interview Scheduled" <?= $app['status'] === 'Interview Scheduled' ? 'selected' : '' ?>>Interview Scheduled</option>
                                        <option value="Accepted" <?= $app['status'] === 'Accepted' ? 'selected' : '' ?>>Accepted</option>
                                        <option value="Rejected" <?= $app['status'] === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                                    </select>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-6">
                                <select onchange="updatePosition(<?= $app['id'] ?>, this.value)" 
                                        class="px-3 py-1 border border-blue-200 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                                    <option value="">Select</option>
                                    <option value="Tech" <?= $app['position'] === 'Tech' ? 'selected' : '' ?>>Tech</option>
                                    <option value="Non-Tech" <?= $app['position'] === 'Non-Tech' ? 'selected' : '' ?>>Non-Tech</option>
                                </select>
                            </td>
                            <td class="py-3 px-6 text-gray-900 dark:text-white">
                                <input type="date" id="date_<?= $app['id'] ?>" value="<?= !empty($app['interview_date']) ? esc($app['interview_date']) : '' ?>"
                                       onchange="updateInterviewSchedule(<?= $app['id'] ?>)"
                                       class="w-32 px-2 py-1 border border-blue-200 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm" />
                            </td>
                            <td class="py-3 px-6 text-gray-900 dark:text-white">
                                <input type="time" id="time_<?= $app['id'] ?>" value="<?= !empty($app['interview_time']) ? esc($app['interview_time']) : '' ?>"
                                       onchange="updateInterviewSchedule(<?= $app['id'] ?>)"
                                       class="w-24 px-2 py-1 border border-blue-200 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm" />
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="flex items-center justify-between mt-6">
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-600 dark:text-gray-400">Rows per page:</span>
                <form id="perPageForm" method="get" class="inline">
                    <select name="per_page" id="rows" onchange="document.getElementById('perPageForm').submit()" 
                            class="w-16 h-8 px-2 border border-blue-200 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                        <option value="5" <?= $perPage == 5 ? 'selected' : '' ?>>5</option>
                        <option value="10" <?= $perPage == 10 ? 'selected' : '' ?>>10</option>
                        <option value="25" <?= $perPage == 25 ? 'selected' : '' ?>>25</option>
                    </select>
                </form>
            </div>
            <div class="flex items-center space-x-4">
                <?php
                    $currentPage = $pager->getCurrentPage();
                    $from = ($currentPage - 1) * $perPage + 1;
                    $to = min($from + $perPage - 1, $total);
                ?>
                <span class="text-sm text-gray-600 dark:text-gray-400"><?= $from ?>–<?= $to ?> of <?= $total ?></span>
                <div class="flex items-center space-x-2">
                    <?= $pager->makeLinks($currentPage, $perPage, $total, 'custom') ?>
                </div>
            </div>
        </div>
    </div>
</div> 
<script>
function updateInterviewSchedule(id) {
    const date = document.getElementById('date_' + id).value;
    const time = document.getElementById('time_' + id).value;
    const formData = new FormData();
    formData.append('id', id);
    if (date) formData.append('interview_date', date);
    if (time) formData.append('interview_time', time);
    // CSRF
    const csrfName = document.querySelector('meta[name="csrf-name"]').getAttribute("content");
    const csrfHash = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    formData.append(csrfName, csrfHash);
    fetch('<?= site_url('applications/update-interview-schedule') ?>', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) {
            alert('Failed to update interview schedule: ' + (data.message || 'Server error'));
        }
    })
    .catch(() => alert('AJAX request failed'));
}
</script> 
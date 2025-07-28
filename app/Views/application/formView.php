<!DOCTYPE html>
<html>
<head>
    <title>Job Application</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="max-w-3xl mx-auto py-10">
    <div class="bg-white p-8 rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-center">Job Application Form</h2>

        <form action="<?= site_url('application/submit') ?>" method="post" enctype="multipart/form-data">
            <!-- Personal Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label>First Name</label>
                    <input type="text" name="first_name" required class="w-full border px-3 py-2 rounded" value="<?= old('first_name') ?>">
                    <?php if (session('errors.first_name')): ?>
                        <div class="text-red-600 text-sm mt-1"><?= esc(session('errors.first_name')) ?></div>
                    <?php endif; ?>
                </div>
                <div>
                    <label>Last Name</label>
                    <input type="text" name="last_name" required class="w-full border px-3 py-2 rounded" value="<?= old('last_name') ?>">
                    <?php if (session('errors.last_name')): ?>
                        <div class="text-red-600 text-sm mt-1"><?= esc(session('errors.last_name')) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mb-6">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone_number" required class="w-full border px-3 py-2 rounded" value="<?= old('phone_number') ?>">
                <?php if (session('errors.phone_number')): ?>
                    <div class="text-red-600 text-sm mt-1"><?= esc(session('errors.phone_number')) ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-6">
                <label>Email</label>
                <input type="email" name="email" required class="w-full border px-3 py-2 rounded" value="<?= old('email') ?>">
                <?php if (session('errors.email')): ?>
                    <div class="text-red-600 text-sm mt-1"><?= esc(session('errors.email')) ?></div>
                <?php endif; ?>
            </div>

            <!-- Preferred Location -->
            <div class="mb-6">
                <label>Preferred Job Location</label>
                <select name="preferred_location" class="w-full border px-3 py-2 rounded">
                    <option value="">Select</option>
                    <?php
                    $preferredOptions = ['Delhi', 'Noida', 'Bangalore', 'Hyderabad', 'Bhubaneswar', 'Asansol', 'Mohali'];
                    foreach ($preferredOptions as $city):
                    ?>
                        <option value="<?= $city ?>" <?= old('preferred_location') === $city ? 'selected' : '' ?>><?= $city ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Current Location -->
            <div class="mb-6">
                <label>Current Location</label>
                <select name="current_location" class="w-full border px-3 py-2 rounded">
                    <option value="">Select</option>
                    <?php
                    $states = [
                        'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh', 'Goa',
                        'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jharkhand', 'Karnataka', 'Kerala',
                        'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland',
                        'Odisha', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana',
                        'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal'
                    ];
                    foreach ($states as $state):
                    ?>
                        <option value="<?= $state ?>" <?= old('current_location') === $state ? 'selected' : '' ?>><?= $state ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Experience -->
            <div class="mb-6">
                <label>Experience Level</label>
                <div>
                    <label><input type="radio" name="experience_level" value="fresher" onclick="toggleExperience(false)" required <?= old('experience_level') === 'fresher' ? 'checked' : '' ?>> Fresher</label>
                    <label class="ml-6"><input type="radio" name="experience_level" value="experienced" onclick="toggleExperience(true)" <?= old('experience_level') === 'experienced' ? 'checked' : '' ?>> Experienced</label>
                </div>
                <?php if (session('errors.experience_level')): ?>
                    <div class="text-red-600 text-sm mt-1"><?= esc(session('errors.experience_level')) ?></div>
                <?php endif; ?>
            </div>

            <!-- Conditional Fields -->
            <div id="experienceDetails" class="hidden mb-6 border p-4 bg-gray-50 rounded">
                <div class="mb-4">
                    <label>Last Salary Range</label>
                    <select name="last_salary" class="w-full border px-3 py-2 rounded">
                        <option value="">Select</option>
                        <option value="10k-20k" <?= old('last_salary') === '10k-20k' ? 'selected' : '' ?>>10k to 20k</option>
                        <option value="20k-40k" <?= old('last_salary') === '20k-40k' ? 'selected' : '' ?>>20k to 40k</option>
                        <option value="40k-1L" <?= old('last_salary') === '40k-1L' ? 'selected' : '' ?>>40k to 1L</option>
                        <option value="1L+" <?= old('last_salary') === '1L+' ? 'selected' : '' ?>>1L+</option>
                    </select>
                </div>
                <div>
                    <label>Total Experience</label>
                    <select name="total_experience" class="w-full border px-3 py-2 rounded">
                        <option value="">Select</option>
                        <option value="1-2" <?= old('total_experience') === '1-2' ? 'selected' : '' ?>>1 to 2 years</option>
                        <option value="2-4" <?= old('total_experience') === '2-4' ? 'selected' : '' ?>>2 to 4 years</option>
                        <option value="4-6" <?= old('total_experience') === '4-6' ? 'selected' : '' ?>>4 to 6 years</option>
                        <option value="6+" <?= old('total_experience') === '6+' ? 'selected' : '' ?>>6+ years</option>
                    </select>
                </div>
            </div>

            <!-- Resume Upload -->
            <div class="mb-6">
                <label>Resume</label>
                <input type="file" name="resume" required class="block w-full border px-3 py-2 rounded">
            </div>

            <!-- Terms -->
            <div class="mb-6">
                <label><input type="checkbox" name="terms" required <?= old('terms') ? 'checked' : '' ?>> I agree to the terms and conditions</label>
            </div>

            <div class="text-right">
                <button type="submit" class="bg-black text-white px-6 py-2 rounded">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleExperience(show) {
        document.getElementById('experienceDetails').classList.toggle('hidden', !show);
    }

    // auto show if experienced is selected (for edit/back with old values)
    <?php if (old('experience_level') === 'experienced'): ?>
    toggleExperience(true);
    <?php endif; ?>

function sendNotification() 
{
   document.getElementbyId('submit');



}


</script>

</body>
</html>

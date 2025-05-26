<!DOCTYPE html>
<html>

<head>
    <title>DentArch</title>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    <style>
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Raleway", sans-serif;
        }
    </style>
</head>

<body class="bg-[#1a1a1a] text-white">
    <!-- Navbar -->
    <div class="fixed top-0 w-full z-50">
        <div class="bg-black flex items-center p-4 shadow-lg">
            <a href="#" class="text-white font-bold text-xl">DENTARCH</a>
            <div class="ml-auto">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="px-4 py-2 text-white hover:bg-gray-800 rounded-lg transition-colors">
                    LOGOUT
                </button>
            </div>
        </div>
    </div>

    {{-- content --}}
    <div class="mt-[88px] p-6">
        {{-- Notification --}}
        @if (session('success'))
            <div class="bg-green-600 text-white p-4 rounded-lg mb-6">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-600 text-white p-4 rounded-lg mb-6">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Table --}}
        <div class="bg-[#2d2d2d] rounded-xl shadow-xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-2xl font-bold">PATIENT DATA</h4>
                <button onclick="document.getElementById('addPatientModal').classList.remove('hidden')"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors">
                    <i class="fa fa-plus mr-2"></i>Add Patient
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full bg-[#2d2d2d] rounded-lg overflow-hidden">
                    <thead class="bg-black">
                        <tr>
                            <th class="px-6 py-4 text-left">No</th>
                            <th class="px-6 py-4 text-left">Full Name</th>
                            <th class="px-6 py-4 text-left">Gender</th>
                            <th class="px-6 py-4 text-left">Address</th>
                            <th class="px-6 py-4 text-left">Phone Number</th>
                            <th class="px-6 py-4 text-left">Birth date</th>
                            <th class="px-6 py-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patients as $index => $patient)
                            <tr class="border-b border-gray-700">
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">{{ $patient->fullname }}</td>
                                <td class="px-6 py-4">{{ $patient->gender }}</td>
                                <td class="px-6 py-4">{{ $patient->address }}</td>
                                <td class="px-6 py-4">{{ $patient->phone_number }}</td>
                                <td class="px-6 py-4">{{ $patient->birthdate }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <button type="button"
                                            onclick="document.getElementById('').classList.remove('hidden')"
                                            class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg transition-colors"
                                            title="">
                                            <i class="fa fa-eye"></i>
                                        </button>

                                        <button data-patient-id="{{ $patient->id }}"
                                            class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-lg transition-colors"
                                            title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <!-- Delete -->
                                        <form action="{{ route('file.delete', $patient->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg transition-colors"
                                                title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <!-- Add Patient Modal -->
    <div id="addPatientModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-[#2d2d2d] rounded-xl w-full max-w-4xl mx-4 my-8">
                <!-- Modal Header -->
                <div class="bg-black rounded-t-xl p-6 flex justify-between items-center">
                    <h3 class="text-xl font-bold"><i class="fa fa-user-plus mr-2"></i>Add New Patient</h3>
                    <button onclick="document.getElementById('addPatientModal').classList.add('hidden')"
                        class="text-gray-400 hover:text-white text-2xl">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 max-h-[80vh] overflow-y-auto">
                    {{-- <form method="POST" action="" enctype="multipart/form-data"> --}}
                    <form method="POST" action="{{ route('archive.store') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Personal Information -->
                        <div class="bg-[#1a1a1a] p-6 rounded-xl mb-6">
                            <h4 class="text-blue-400 font-bold mb-4"><i class="fa fa-user mr-2"></i>Personal Information
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block font-bold mb-2">Full Name *</label>
                                    <input type="text" required name="fullname"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block font-bold mb-2">Gender *</label>
                                    <select required name="gender"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block font-bold mb-2">Birth Date *</label>
                                    <input type="date" required name="birthdate"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block font-bold mb-2">Phone Number *</label>
                                    <input type="tel" required name="phone_number"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block font-bold mb-2">Address *</label>
                                    <input type="text" required name="address"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Physical Information -->
                        <div class="bg-[#1a1a1a] p-6 rounded-xl mb-6">
                            <h4 class="text-green-400 font-bold mb-4"><i class="fa fa-heartbeat mr-2"></i>Physical
                                Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block font-bold mb-2">Weight (kg)</label>
                                    <input type="number" name="weight"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block font-bold mb-2">Height (cm)</label>
                                    <input type="number" name="height"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Personal Details -->
                        <div class="bg-[#1a1a1a] p-6 rounded-xl mb-6">
                            <h4 class="text-orange-400 font-bold mb-4"><i class="fa fa-info-circle mr-2"></i>Personal
                                Details</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block font-bold mb-2">Job/Occupation</label>
                                    <input type="text" name="job"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block font-bold mb-2">Tribes/Ethnicity</label>
                                    <input type="text" name="tribes"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block font-bold mb-2">Marital Status</label>
                                    <select name="marital_status"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                        <option value="">Select Marital Status</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Widowed">Widowed</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block font-bold mb-2">Reference</label>
                                    <input type="text" name="reference"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block font-bold mb-2">With Suspect/Companion</label>
                                    <input type="text" name="with_suspect"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- FIXED File Upload Section -->
                        <div class="bg-[#1a1a1a] p-6 rounded-xl mb-6">
                            <h4 class="text-purple-400 font-bold mb-4"><i class="fa fa-file-archive mr-2"></i>Patient
                                Files Upload</h4>

                            <!-- Simple File Upload -->
                            <div class="mb-4">
                                <label class="block font-bold mb-2">Select Files *</label>
                                <input type="file" name="files[]" multiple required
                                    accept=".pdf,.jpg,.jpeg,.png,.xlsx,.xls,.csv"
                                    class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                    id="fileInput" onchange="handleFileSelect(this)">
                            </div>

                            <!-- File Preview -->
                            <div id="filePreview" class="hidden">
                                <h5 class="font-bold mb-2 text-white">Selected Files:</h5>
                                <div id="fileList"
                                    class="space-y-2 max-h-60 overflow-y-auto bg-[#2d2d2d] p-4 rounded-lg"></div>
                                <div class="mt-4 flex justify-between items-center">
                                    <span id="fileCount" class="text-sm text-gray-400">0 files selected</span>
                                    <button type="button" onclick="clearAllFiles()"
                                        class="text-red-400 hover:text-red-300 text-sm px-3 py-1 rounded hover:bg-red-500/10">
                                        <i class="fa fa-trash mr-1"></i>Clear All
                                    </button>
                                </div>
                            </div>

                            <!-- Drag & Drop Zone (Optional) -->
                            <div class="relative border-2 border-dashed border-gray-600 rounded-xl h-32 mt-4 hover:border-blue-500 transition-colors"
                                id="dropZone" ondragover="handleDragOver(event)"
                                ondragleave="handleDragLeave(event)" ondrop="handleDrop(event)">
                                <div
                                    class="absolute inset-0 flex flex-col items-center justify-center p-4 text-center">
                                    <i class="fa fa-cloud-upload fa-2x text-gray-400 mb-2"></i>
                                    <p class="text-gray-400 text-sm">Or drag and drop files here</p>
                                    <p class="text-xs text-gray-500 mt-1">Allowed: PDF, JPG, PNG, XLSX, CSV (Max 10MB)
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Form Buttons -->
                        <div class="flex justify-end space-x-4">
                            <button type="button"
                                onclick="document.getElementById('addPatientModal').classList.add('hidden')"
                                class="bg-gray-600 hover:bg-gray-700 px-6 py-3 rounded-lg transition-colors">
                                <i class="fa fa-times mr-2"></i>Cancel
                            </button>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-lg transition-colors">
                                <i class="fa fa-save mr-2"></i>Save Patient
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        {{-- upload script --}}
        <script>
            let selectedFiles = [];

            const fileInput = document.getElementById('fileInput');
            const fileList = document.getElementById('fileList');
            const filePreview = document.getElementById('filePreview');
            const fileCount = document.getElementById('fileCount');

            fileInput.addEventListener('change', (e) => {
                // Tambah file baru ke array, tapi jangan duplikat
                for (const file of e.target.files) {
                    if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                        selectedFiles.push(file);
                    }
                }
                updateFilePreview();
                updateInputFiles();
            });

            function updateFilePreview() {
                if (selectedFiles.length === 0) {
                    filePreview.classList.add('hidden');
                    fileList.innerHTML = '';
                    fileCount.textContent = '0 files selected';
                    return;
                }

                filePreview.classList.remove('hidden');
                fileCount.textContent = `${selectedFiles.length} file${selectedFiles.length > 1 ? 's' : ''} selected`;
                fileList.innerHTML = '';

                selectedFiles.forEach((file, index) => {
                    const div = document.createElement('div');
                    div.className = 'flex items-center justify-between p-2 bg-[#1a1a1a] rounded border border-gray-700';

                    const fileIcon = getFileIcon(file.name);
                    const fileSize = formatFileSize(file.size);

                    div.innerHTML = `
                <div class="flex items-center space-x-3">
                    <i class="fa ${fileIcon} text-blue-400"></i>
                    <div>
                        <p class="text-white text-sm font-medium">${file.name}</p>
                        <p class="text-gray-400 text-xs">${fileSize}</p>
                    </div>
                </div>
                <button class="text-red-400 hover:text-red-300 text-xs px-2 py-1 rounded hover:bg-red-500/10" data-index="${index}" aria-label="Remove file">
                    <i class="fa fa-times"></i> Cancel
                </button>
            `;

                    fileList.appendChild(div);
                });

                // Tambah event listener untuk tombol cancel per file
                fileList.querySelectorAll('button').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const index = parseInt(e.currentTarget.getAttribute('data-index'));
                        selectedFiles.splice(index, 1);
                        updateFilePreview();
                        updateInputFiles();
                    });
                });
            }

            function clearAllFiles() {
                selectedFiles = [];
                fileInput.value = '';
                updateFilePreview();
                updateInputFiles();
            }

            // Update input.files dengan selectedFiles via DataTransfer
            function updateInputFiles() {
                const dt = new DataTransfer();
                selectedFiles.forEach(file => dt.items.add(file));
                fileInput.files = dt.files;
            }

            // Utility fungsi icon file
            function getFileIcon(filename) {
                const extension = filename.split('.').pop().toLowerCase();
                switch (extension) {
                    case 'pdf':
                        return 'fa-file-pdf';
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                        return 'fa-file-image';
                    case 'xlsx':
                    case 'xls':
                        return 'fa-file-excel';
                    case 'csv':
                        return 'fa-file-csv';
                    default:
                        return 'fa-file';
                }
            }

            // Utility fungsi format ukuran file
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
        </script>
    </div>

    <!-- Modal Edit Patient -->
    <div id="editPatientModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-[#2d2d2d] rounded-xl w-full max-w-4xl mx-4 my-8">
                <!-- Modal Header -->
                <div class="bg-black rounded-t-xl p-6 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-white">
                        <i class="fa fa-user-edit mr-2"></i>Edit Patient
                    </h3>
                    <button onclick="closeEditModal()"
                        class="text-gray-400 hover:text-white text-2xl">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 max-h-[80vh] overflow-y-auto">
                    <form id="editPatientForm" method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- PERSONAL INFO -->
                        <div class="bg-[#1a1a1a] p-6 rounded-xl mb-6">
                            <h4 class="text-blue-400 font-bold mb-4"><i class="fa fa-user mr-2"></i>Personal
                                Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block font-bold mb-2">Full Name *</label>
                                    <input type="text" required name="fullname" id="edit_fullname"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 text-white">
                                </div>
                                <div>
                                    <label class="block font-bold mb-2">Gender *</label>
                                    <select required name="gender" id="edit_gender"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 text-white">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block font-bold mb-2">Date of Birth *</label>
                                    <input type="date" required name="birthdate" id="edit_birthdate"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 text-white">
                                </div>
                                <div>
                                    <label class="block font-bold mb-2">Phone Number *</label>
                                    <input type="tel" required name="phone_number" id="edit_phone_number"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block font-bold mb-2">Address *</label>
                                    <input type="text" required name="address" id="edit_address"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Physical Info -->
                        <div class="bg-[#1a1a1a] p-6 rounded-xl mb-6">
                            <h4 class="text-green-400 font-bold mb-4"><i class="fa fa-heartbeat mr-2"></i>Physical
                                Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block font-bold mb-2" for="edit_weight">Weight (kg)</label>
                                    <input type="number" name="weight" id="edit_weight"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block font-bold mb-2" for="edit_height">Height (cm)</label>
                                    <input type="number" name="height" id="edit_height"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Personal Details -->
                        <div class="bg-[#1a1a1a] p-6 rounded-xl mb-6">
                            <h4 class="text-orange-400 font-bold mb-4"><i class="fa fa-info-circle mr-2"></i>Personal
                                Details</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block font-bold mb-2" for="edit_job">Job/Occupation</label>
                                    <input type="text" name="job" id="edit_job"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block font-bold mb-2" for="edit_tribes">Tribes/Ethnicity</label>
                                    <input type="text" name="tribes" id="edit_tribes"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block font-bold mb-2" for="edit_marital_status">Marital
                                        Status</label>
                                    <select name="marital_status" id="edit_marital_status"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                        <option value="">Select Marital Status</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Widowed">Widowed</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block font-bold mb-2" for="edit_reference">Reference</label>
                                    <input type="text" name="reference" id="edit_reference"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block font-bold mb-2" for="edit_with_suspect">With
                                        Suspect/Companion</label>
                                    <input type="text" name="with_suspect" id="edit_with_suspect"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- IMPROVED File Upload Section -->
                        <div class="bg-[#1a1a1a] p-6 rounded-xl mb-6">
                            <h4 class="text-purple-400 font-bold mb-4"><i class="fa fa-file-archive mr-2"></i>Patient
                                Files Management</h4>

                            <!-- File Upload Input -->
                            <div class="mb-4">
                                <label class="block font-bold mb-2" for="edit_files">Add New Files</label>
                                <input type="file" name="files[]" id="edit_files" multiple
                                    accept=".pdf,.jpg,.jpeg,.png,.xlsx,.xls,.csv"
                                    class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                    onchange="handleNewFileSelect(this)">
                            </div>

                            <!-- Drag & Drop Zone -->
                            <div class="relative border-2 border-dashed border-gray-600 rounded-xl h-32 mb-4 hover:border-blue-500 transition-colors"
                                id="edit_dropZone" ondragover="handleDragOver(event)"
                                ondragleave="handleDragLeave(event)" ondrop="handleEditDrop(event)">
                                <div
                                    class="absolute inset-0 flex flex-col items-center justify-center p-4 text-center">
                                    <i class="fa fa-cloud-upload fa-2x text-gray-400 mb-2"></i>
                                    <p class="text-gray-400 text-sm">Or drag and drop files here</p>
                                    <p class="text-xs text-gray-500 mt-1">Allowed: PDF, JPG, PNG, XLSX, CSV (Max 10MB)
                                    </p>
                                </div>
                            </div>

                            <!-- Combined File List (Existing + New) -->
                            <div id="edit_filePreview" class="hidden">
                                <div class="flex justify-between items-center mb-3">
                                    <h5 class="font-bold text-white">Files:</h5>
                                    <div class="flex gap-3">
                                        <span id="edit_fileCount" class="text-sm text-gray-400">0 files total</span>
                                        <button type="button" onclick="clearNewFiles()"
                                            class="text-yellow-400 hover:text-yellow-300 text-sm px-2 py-1 rounded hover:bg-yellow-500/10">
                                            <i class="fa fa-undo mr-1"></i>Clear New
                                        </button>
                                    </div>
                                </div>

                                <div id="edit_fileList"
                                    class="space-y-2 max-h-60 overflow-y-auto bg-[#2d2d2d] p-4 rounded-lg">
                                    <!-- Files will be populated here -->
                                </div>
                            </div>
                        </div>

                        <!-- FOOTER -->
                        <div class="flex justify-end space-x-4">
                            <button type="button" onclick="closeEditModal()"
                                class="bg-gray-600 hover:bg-gray-700 px-6 py-3 rounded-lg text-white transition">
                                <i class="fa fa-times mr-2"></i>Cancel
                            </button>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-lg text-white transition">
                                <i class="fa fa-save mr-2"></i>Update Patient
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            // Global variables to manage files
            let existingFiles = [];
            let newFiles = [];
            let currentPatientId = null;

            // Function to close modal and reset everything
            function closeEditModal() {
                document.getElementById('editPatientModal').classList.add('hidden');
                resetFileState();
            }

            // Reset file state
            function resetFileState() {
                existingFiles = [];
                newFiles = [];
                currentPatientId = null;
                document.getElementById('edit_files').value = '';
                document.getElementById('edit_filePreview').classList.add('hidden');
                document.getElementById('edit_fileList').innerHTML = '';
            }

            // Handle new file selection
            function handleNewFileSelect(input) {
                const files = Array.from(input.files);

                // Add new files to newFiles array
                files.forEach(file => {
                    const fileObj = {
                        file: file,
                        file_name: file.name,
                        size: formatFileSize(file.size),
                        type: file.name.split('.').pop().toLowerCase(),
                        isNew: true,
                        id: 'new_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9)
                    };
                    newFiles.push(fileObj);
                });

                updateFileDisplay();
            }

            // Handle drag and drop for new files
            function handleEditDrop(e) {
                e.preventDefault();
                const dropZone = document.getElementById('edit_dropZone');
                dropZone.classList.remove('border-blue-500', 'bg-blue-500/5');

                const files = Array.from(e.dataTransfer.files);

                // Filter allowed file types
                const allowedTypes = ['pdf', 'jpg', 'jpeg', 'png', 'xlsx', 'xls', 'csv'];
                const validFiles = files.filter(file => {
                    const extension = file.name.split('.').pop().toLowerCase();
                    return allowedTypes.includes(extension);
                });

                // Add valid files to newFiles array
                validFiles.forEach(file => {
                    const fileObj = {
                        file: file,
                        file_name: file.name,
                        size: formatFileSize(file.size),
                        type: file.name.split('.').pop().toLowerCase(),
                        isNew: true,
                        id: 'new_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9)
                    };
                    newFiles.push(fileObj);
                });

                updateFileDisplay();
            }

            function handleDragOver(e) {
                e.preventDefault();
                const dropZone = document.getElementById('edit_dropZone');
                dropZone.classList.add('border-blue-500', 'bg-blue-500/5');
            }

            function handleDragLeave(e) {
                e.preventDefault();
                const dropZone = document.getElementById('edit_dropZone');
                dropZone.classList.remove('border-blue-500', 'bg-blue-500/5');
            }

            // Update file display combining existing and new files
            function updateFileDisplay() {
                const fileList = document.getElementById('edit_fileList');
                const filePreview = document.getElementById('edit_filePreview');
                const fileCount = document.getElementById('edit_fileCount');

                // Clear current display
                fileList.innerHTML = '';

                const totalFiles = existingFiles.length + newFiles.length;

                if (totalFiles > 0) {
                    filePreview.classList.remove('hidden');

                    // Display existing files
                    existingFiles.forEach(file => {
                        const item = createFileItem(file, false);
                        fileList.appendChild(item);
                    });

                    // Display new files
                    newFiles.forEach(file => {
                        const item = createFileItem(file, true);
                        fileList.appendChild(item);
                    });

                    fileCount.textContent =
                        `${totalFiles} files total (${existingFiles.length} existing, ${newFiles.length} new)`;
                } else {
                    filePreview.classList.add('hidden');
                }
            }

            // Create file item element
            function createFileItem(file, isNew) {
                const item = document.createElement('div');
                item.classList.add('flex', 'items-center', 'justify-between', 'bg-[#1f1f1f]', 'p-3', 'rounded', 'text-sm',
                    'text-white');

                if (isNew) {
                    item.classList.add('border-l-4', 'border-green-400'); // Visual indicator for new files
                }

                const statusBadge = isNew ?
                    '<span class="text-xs bg-green-600 px-2 py-1 rounded-full ml-2">NEW</span>' :
                    '<span class="text-xs bg-blue-600 px-2 py-1 rounded-full ml-2">EXISTING</span>';

                item.innerHTML = `
                <div class="flex items-center gap-2">
                    <i class="fa fa-file-${getFileIcon(file.type)} text-blue-400"></i>
                    <div>
                        <div class="flex items-center">
                            ${file.file_name}
                            ${statusBadge}
                        </div>
                        <div class="text-xs text-gray-400">${file.size}</div>
                    </div>
                </div>
                <div class="flex gap-2">
                    ${!isNew ? `
                                <a href="/storage/${file.file}" target="_blank" class="text-blue-400 hover:underline text-xs">
                                    <i class="fa fa-eye"></i> View
                                </a>
                                <a href="/storage/${file.file}" download class="text-green-400 hover:underline text-xs">
                                    <i class="fa fa-download"></i> Download
                                </a>
                                <button type="button" class="delete-file-btn text-red-400 hover:text-red-300 text-xs" 
                                        onclick="deleteExistingFile(${file.id}, this.closest('.flex'))">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            ` : `
                                <button type="button" class="text-yellow-400 hover:text-yellow-300 text-xs" 
                                        onclick="removeNewFile('${file.id}')">
                                    <i class="fa fa-times"></i> Remove
                                </button>
                            `}
                </div>
            `;

                return item;
            }

            // Remove new file from array
            function removeNewFile(fileId) {
                newFiles = newFiles.filter(file => file.id !== fileId);
                updateFileDisplay();
                updateFileInput();
            }

            // Clear all new files
            function clearNewFiles() {
                if (newFiles.length > 0 && confirm('Remove all new files?')) {
                    newFiles = [];
                    document.getElementById('edit_files').value = '';
                    updateFileDisplay();
                }
            }

            // Update file input with remaining new files
            function updateFileInput() {
                const input = document.getElementById('edit_files');
                const dt = new DataTransfer();

                newFiles.forEach(fileObj => {
                    if (fileObj.file instanceof File) {
                        dt.items.add(fileObj.file);
                    }
                });

                input.files = dt.files;
            }

            // Delete existing file via AJAX
            function deleteExistingFile(fileId, fileElement) {
                if (!confirm('Delete this file permanently?')) {
                    return;
                }

                const deleteBtn = fileElement.querySelector('.delete-file-btn');
                const originalContent = deleteBtn.innerHTML;
                deleteBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
                deleteBtn.disabled = true;

                fetch(`/file/remove/${fileId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Remove from existingFiles array
                            existingFiles = existingFiles.filter(file => file.id !== fileId);

                            // Update display
                            updateFileDisplay();

                            showToast('File deleted successfully!', 'success');
                        } else {
                            throw new Error(data.message || 'Failed to delete file');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        deleteBtn.innerHTML = originalContent;
                        deleteBtn.disabled = false;
                        showToast('Failed to delete file. Please try again.', 'error');
                    });
            }

            // Show toast notification
            function showToast(message, type = 'success') {
                const toast = document.createElement('div');
                toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white z-50 transition-all duration-300 ${
                type === 'success' ? 'bg-green-600' : 'bg-red-600'
            }`;
                toast.textContent = message;
                document.body.appendChild(toast);

                // Animate in
                setTimeout(() => toast.classList.add('opacity-100'), 10);

                // Remove after 3 seconds
                setTimeout(() => {
                    toast.classList.add('opacity-0');
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }

            // Format file size
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Get file icon
            function getFileIcon(type) {
                const iconMap = {
                    'pdf': 'pdf',
                    'jpg': 'image',
                    'jpeg': 'image',
                    'png': 'image',
                    'xlsx': 'excel',
                    'xls': 'excel',
                    'csv': 'csv'
                };
                return iconMap[type.toLowerCase()] || 'o';
            }

            // Main script for modal - UPDATED
            document.querySelectorAll('[data-patient-id]').forEach(button => {
                button.addEventListener('click', function() {
                    const patientId = this.getAttribute('data-patient-id');
                    currentPatientId = patientId;
                    const modal = document.getElementById('editPatientModal');

                    // Reset file state first
                    resetFileState();

                    fetch(`/archive/${patientId}/edit`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('edit_fullname').value = data.patient.fullname || '';
                            document.getElementById('edit_birthdate').value = data.patient.birthdate || '';
                            document.getElementById('edit_gender').value = data.patient.gender || '';
                            document.getElementById('edit_phone_number').value = data.patient
                                .phone_number || '';
                            document.getElementById('edit_address').value = data.patient.address || '';
                            document.getElementById('edit_weight').value = data.patient.weight || '';
                            document.getElementById('edit_height').value = data.patient.height || '';
                            document.getElementById('edit_job').value = data.patient.job || '';
                            document.getElementById('edit_tribes').value = data.patient.tribes || '';
                            document.getElementById('edit_marital_status').value = data.patient
                                .marital_status || '';
                            document.getElementById('edit_reference').value = data.patient.reference || '';
                            document.getElementById('edit_with_suspect').value = data.patient
                                .with_suspect || '';

                            // Set form action
                            document.getElementById('editPatientForm').action =
                                `/archive/${data.patient.id}`;

                            // Store existing files
                            existingFiles = data.files || [];

                            // Update display
                            updateFileDisplay();

                            // Show modal
                            modal.classList.remove('hidden');
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('Failed to load patient data', 'error');
                        });
                });
            });
        </script>
    </div>

</body>

</html>

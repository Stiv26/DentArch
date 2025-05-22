<!DOCTYPE html>
<html>

<head>
    <title>DentArch</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
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
            <a href="#" class="text-white font-bold text-xl">DENTARCH | </a>
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

    <div class="mt-[68px] p-6">
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
                        @foreach ($allFiles as $file)
                            <tr class="hover:bg-gray-800 border-b border-gray-700">
                                <td class="px-6 py-4">
                                    <i
                                        class="fa 
                                        @switch($file->type)
                                            @case('pdf') fa-file-pdf-o text-red-400 @break
                                            @case('jpg') @case('jpeg') @case('png') fa-file-image-o text-blue-400 @break
                                            @case('csv') @case('xls') @case('xlsx') fa-file-excel-o text-green-400 @break
                                            @default fa-file-o
                                        @endswitch
                                    mr-2"></i>{{ basename($file->file) }}
                                </td>
                                <td class="px-6 py-4">{{ strtoupper($file->type) }}</td>
                                <td class="px-6 py-4">{{ $file->size }}</td>
                                <td class="px-6 py-4">{{ $file->uploaded_at->format('Y-m-d') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ Storage::url('uploads/' . $file->file) }}"
                                            class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg transition-colors">
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <form action="{{ route('file.delete', $file->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg transition-colors">
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
                    <form method="POST" action="{{ route('patients.store') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Personal Information -->
                        <div class="bg-[#1a1a1a] p-6 rounded-xl">
                            <h4 class="text-blue-400 font-bold mb-4"><i class="fa fa-user mr-2"></i>Personal Information
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block font-bold mb-2">Full Name *</label>
                                    <input type="text" required
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block font-bold mb-2">Gender *</label>
                                    <select required
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block font-bold mb-2">Birth Date *</label>
                                    <input type="date" required
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block font-bold mb-2">Phone Number *</label>
                                    <input type="tel" required
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block font-bold mb-2">Address *</label>
                                    <input type="text" required
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Physical Information -->
                        <div class="bg-[#1a1a1a] p-6 rounded-xl">
                            <h4 class="text-green-400 font-bold mb-4"><i class="fa fa-heartbeat mr-2"></i>Physical
                                Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block font-bold mb-2">Weight (kg)</label>
                                    <input type="number"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block font-bold mb-2">Height (cm)</label>
                                    <input type="number"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Personal Details -->
                        <div class="bg-[#1a1a1a] p-6 rounded-xl">
                            <h4 class="text-orange-400 font-bold mb-4"><i class="fa fa-info-circle mr-2"></i>Personal
                                Details</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block font-bold mb-2">Job/Occupation</label>
                                    <input type="text"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block font-bold mb-2">Tribes/Ethnicity</label>
                                    <input type="text"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block font-bold mb-2">Marital Status</label>
                                    <select
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
                                    <input type="text"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block font-bold mb-2">With Suspect/Companion</label>
                                    <input type="text"
                                        class="w-full bg-[#2d2d2d] border border-gray-600 rounded-lg p-3 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Tambahkan di dalam modal form pasien -->
                        <!-- Updated File Upload Section -->
                        <div class="bg-[#1a1a1a] p-6 rounded-xl">
                            <h4 class="text-purple-400 font-bold mb-4"><i class="fa fa-file-archive mr-2"></i>Patient
                                Files Upload</h4>

                            <!-- Drag & Drop Zone -->
                            <div class="relative border-2 border-dashed border-gray-600 rounded-xl h-48 mb-4 hover:border-blue-500 transition-colors"
                                id="dropZone" ondragover="handleDragOver(event)"
                                ondragleave="handleDragLeave(event)" ondrop="handleDrop(event)">
                                <div
                                    class="absolute inset-0 flex flex-col items-center justify-center p-4 text-center">
                                    <i class="fa fa-cloud-upload fa-3x text-gray-400 mb-2"></i>
                                    <p class="text-gray-400">Drag and drop files here or click to upload</p>
                                    <p class="text-sm text-gray-500 mt-1">Allowed formats: PDF, JPG, PNG, XLSX, CSV
                                        (Max 10MB)</p>
                                </div>
                                <input type="file" name="files[]" multiple
                                    accept=".pdf,.jpg,.jpeg,.png,.xlsx,.xls,.csv"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" id="fileInput"
                                    onchange="handleFileSelect(this)">
                            </div>

                            <!-- File Preview -->
                            <div id="filePreview" class="hidden">
                                <h5 class="font-bold mb-2 text-white">Selected Files:</h5>
                                <ul id="fileList" class="space-y-2 max-h-60 overflow-y-auto"></ul>
                                <div class="mt-4 flex justify-between items-center">
                                    <span id="fileCount" class="text-sm text-gray-400">0 files selected</span>
                                    <button type="button" onclick="clearAllFiles()"
                                        class="text-red-400 hover:text-red-300 text-sm">
                                        <i class="fa fa-trash mr-1"></i>Clear All
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- FILE JS SCRIPT --}}
                        <script>
                            // Global variable to store selected files
                            let selectedFiles = [];

                            // Handle drag over
                            function handleDragOver(event) {
                                event.preventDefault();
                                event.currentTarget.classList.add('border-blue-500', 'bg-blue-50/5');
                            }

                            // Handle drag leave
                            function handleDragLeave(event) {
                                event.currentTarget.classList.remove('border-blue-500', 'bg-blue-50/5');
                            }

                            // Handle drop
                            function handleDrop(event) {
                                event.preventDefault();
                                event.currentTarget.classList.remove('border-blue-500', 'bg-blue-50/5');

                                const files = Array.from(event.dataTransfer.files);
                                addFilesToSelection(files);
                            }

                            // Handle file input change
                            function handleFileSelect(input) {
                                const files = Array.from(input.files);
                                addFilesToSelection(files);
                            }

                            // Add files to selection
                            function addFilesToSelection(files) {
                                const allowedTypes = ['pdf', 'jpg', 'jpeg', 'png', 'xlsx', 'xls', 'csv'];
                                const maxSize = 10 * 1024 * 1024; // 10MB

                                files.forEach(file => {
                                    // Check file type
                                    const fileExtension = file.name.split('.').pop().toLowerCase();
                                    if (!allowedTypes.includes(fileExtension)) {
                                        showNotification(`File ${file.name} has invalid format`, 'error');
                                        return;
                                    }

                                    // Check file size
                                    if (file.size > maxSize) {
                                        showNotification(`File ${file.name} is too large (max 10MB)`, 'error');
                                        return;
                                    }

                                    // Check if file already exists
                                    const exists = selectedFiles.some(f => f.name === file.name && f.size === file.size);
                                    if (exists) {
                                        showNotification(`File ${file.name} is already selected`, 'warning');
                                        return;
                                    }

                                    // Add unique ID to file
                                    file.id = Date.now() + Math.random();
                                    selectedFiles.push(file);
                                });

                                updateFilePreview();
                                updateFileInput();
                            }

                            // Update file preview
                            function updateFilePreview() {
                                const filePreview = document.getElementById('filePreview');
                                const fileList = document.getElementById('fileList');
                                const fileCount = document.getElementById('fileCount');

                                if (selectedFiles.length === 0) {
                                    filePreview.classList.add('hidden');
                                    return;
                                }

                                filePreview.classList.remove('hidden');

                                // Update file count
                                fileCount.textContent = `${selectedFiles.length} file${selectedFiles.length > 1 ? 's' : ''} selected`;

                                // Clear existing list
                                fileList.innerHTML = '';

                                // Add each file to the list
                                selectedFiles.forEach((file, index) => {
                                    const li = document.createElement('li');
                                    li.className =
                                        'flex items-center justify-between bg-[#2d2d2d] p-3 rounded-lg border border-gray-600';

                                    const fileIcon = getFileIcon(file.name);
                                    const fileSize = formatFileSize(file.size);

                                    li.innerHTML = `
                                        <div class="flex items-center space-x-3 flex-1">
                                            <i class="fa ${fileIcon} text-2xl text-blue-400"></i>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-white font-medium truncate">${file.name}</p>
                                                <p class="text-gray-400 text-sm">${fileSize}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="px-2 py-1 bg-green-600/20 text-green-400 text-xs rounded-full">Ready</span>
                                            <button type="button" 
                                                    onclick="removeFile(${index})" 
                                                    class="text-red-400 hover:text-red-300 p-1 hover:bg-red-500/10 rounded"
                                                    title="Remove file">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    `;

                                    fileList.appendChild(li);
                                });
                            }

                            // Remove file from selection
                            function removeFile(index) {
                                selectedFiles.splice(index, 1);
                                updateFilePreview();
                                updateFileInput();
                                showNotification('File removed from selection', 'success');
                            }

                            // Clear all files
                            function clearAllFiles() {
                                selectedFiles = [];
                                updateFilePreview();
                                updateFileInput();
                                showNotification('All files cleared', 'success');
                            }

                            // Update file input with selected files
                            function updateFileInput() {
                                const fileInput = document.getElementById('fileInput');
                                const dt = new DataTransfer();

                                selectedFiles.forEach(file => {
                                    dt.items.add(file);
                                });

                                fileInput.files = dt.files;
                            }

                            // Get file icon based on extension
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

                            // Format file size
                            function formatFileSize(bytes) {
                                if (bytes === 0) return '0 Bytes';

                                const k = 1024;
                                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                                const i = Math.floor(Math.log(bytes) / Math.log(k));

                                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                            }

                            // Show notification
                            function showNotification(message, type = 'info') {
                                // Create notification element
                                const notification = document.createElement('div');
                                notification.className =
                                    `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transition-all duration-300 transform translate-x-full`;

                                // Set color based on type
                                switch (type) {
                                    case 'success':
                                        notification.classList.add('bg-green-600', 'text-white');
                                        break;
                                    case 'error':
                                        notification.classList.add('bg-red-600', 'text-white');
                                        break;
                                    case 'warning':
                                        notification.classList.add('bg-yellow-600', 'text-white');
                                        break;
                                    default:
                                        notification.classList.add('bg-blue-600', 'text-white');
                                }

                                notification.innerHTML = `
                                    <div class="flex items-center space-x-2">
                                        <i class="fa fa-${type === 'success' ? 'check' : type === 'error' ? 'exclamation-triangle' : type === 'warning' ? 'exclamation' : 'info'}-circle"></i>
                                        <span>${message}</span>
                                    </div>
                                `;

                                document.body.appendChild(notification);

                                // Animate in
                                setTimeout(() => {
                                    notification.classList.remove('translate-x-full');
                                }, 100);

                                // Remove after 3 seconds
                                setTimeout(() => {
                                    notification.classList.add('translate-x-full');
                                    setTimeout(() => {
                                        document.body.removeChild(notification);
                                    }, 300);
                                }, 3000);
                            }

                            // Form submission handler
                            document.querySelector('form').addEventListener('submit', function(e) {
                                if (selectedFiles.length === 0) {
                                    e.preventDefault();
                                    showNotification('Please select at least one file to upload', 'warning');
                                    return;
                                }

                                // Show loading state
                                const submitBtn = this.querySelector('button[type="submit"]');
                                const originalText = submitBtn.innerHTML;
                                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i>Uploading...';
                                submitBtn.disabled = true;

                                // You can add additional validation here if needed
                            });
                        </script>

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
    </div>

</body>

</html>

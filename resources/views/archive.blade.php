<!DOCTYPE html>
<html>

<head>
    <title>DentArch</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Raleway", sans-serif;
            color: white;
        }

        body,
        html {
            height: 100%;
            line-height: 1.8;
            background-color: #1a1a1a;
        }

        .w3-bar .w3-button {
            padding: 16px;
        }

        /* Custom dark mode colors */
        .w3-dark-grey {
            background-color: #2d2d2d !important;
        }
    </style>
</head>

<body>
    <!-- Navbar (Dark Mode) -->
    <div class="w3-top">
        <div class="w3-bar w3-black w3-card" id="myNavbar">
            <a href="" class="w3-bar-item w3-button w3-wide w3-text-white">DENTARCH</a>
            <!-- Right-sided navbar links -->
            <div class="w3-right w3-hide-small">
                <a href="/" class="w3-bar-item w3-button w3-hover-text-grey w3-text-white">UPLOAD FILE</a>
            </div>

        </div>
    </div>

    <div class="w3-main" style="margin-top:43px;">
        <div class="w3-container w3-dark-grey w3-padding-32">
            <!-- Upload Section -->
            <div class="w3-row-padding w3-center" style="margin-top:32px">
                <div class="w3-col l8 m12 s12 w3-margin-bottom">
                    <div class="w3-card-4 w3-black w3-padding-32">
                        <h3 class="w3-border-bottom w3-border-dark-grey w3-padding-16">Upload New File</h3>

                        <!-- Upload Form -->
                        <form action="/upload" method="POST" enctype="multipart/form-data" class="w3-container">
                            @csrf

                            <!-- Drag & Drop Zone -->
                            <div class="w3-drop-hover w3-border w3-border-dark-grey w3-round-large"
                                style="height:200px; border-style: dashed!important; position: relative;">
                                <div class="w3-drop-content w3-center w3-text-grey w3-padding-64">
                                    <i class="fa fa-cloud-upload fa-3x"></i>
                                    <p class="w3-margin-top">Drag and drop files here or click to upload</p>
                                    <input type="file" name="files[]" multiple
                                        accept="image/*,application/pdf,.csv,.xlsx,.xls" class="w3-input w3-opacity-0"
                                        style="position: absolute; width: 100%; height: 100%; top: 0; left: 0;"
                                        onchange="previewFiles(this)">
                                </div>
                            </div>

                            <!-- File Preview -->
                            <div id="filePreview" class="w3-margin-top w3-hide">
                                <h5>Selected Files:</h5>
                                <ul class="w3-ul w3-border w3-border-dark-grey" id="fileList"></ul>
                            </div>

                            <!-- Upload Button -->
                            <button type="submit" class="w3-button w3-green w3-margin-top w3-block">
                                <i class="fa fa-upload"></i> Upload Files
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Recent Files -->
                <div class="w3-col l4 m12 s12">
                    <div class="w3-card-4 w3-black w3-padding-32">
                        <h3 class="w3-border-bottom w3-border-dark-grey w3-padding-16">Recent Files</h3>
                        <div class="w3-container">
                            <!-- File List -->
                            <ul class="w3-ul w3-hoverable">
                                <li class="w3-padding-16 w3-dark-grey">
                                    <i class="fa fa-file-pdf-o w3-text-red"></i> report.pdf<br>
                                    <small>Uploaded: 2 hours ago</small>
                                </li>
                                <li class="w3-padding-16 w3-dark-grey">
                                    <i class="fa fa-file-image-o w3-text-blue"></i> xray.jpg<br>
                                    <small>Uploaded: 1 day ago</small>
                                </li>
                                <li class="w3-padding-16 w3-dark-grey">
                                    <i class="fa fa-file-excel-o w3-text-green"></i> data.xlsx<br>
                                    <small>Uploaded: 3 days ago</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Uploaded Files Table -->
            <div class="w3-row-padding w3-margin-top">
                <div class="w3-col l12">
                    <div class="w3-card-4 w3-black">
                        <div class="w3-container w3-padding-16">
                            <h4>All Files</h4>
                            <table class="w3-table w3-bordered w3-dark-grey">
                                <thead>
                                    <tr class="w3-black">
                                        <th>File Name</th>
                                        <th>Type</th>
                                        <th>Size</th>
                                        <th>Upload Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Sample Data -->
                                    <tr>
                                        <td><i class="fa fa-file"></i> patient_report.pdf</td>
                                        <td>PDF</td>
                                        <td>2.5 MB</td>
                                        <td>2024-03-20</td>
                                        <td>
                                            <button class="w3-button w3-blue w3-tiny"><i
                                                    class="fa fa-download"></i></button>
                                            <button class="w3-button w3-red w3-tiny"><i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <!-- Add more rows dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // File Preview Script
        function previewFiles(input) {
            const preview = document.getElementById('filePreview');
            const fileList = document.getElementById('fileList');

            preview.classList.remove('w3-hide');
            fileList.innerHTML = '';

            for (let file of input.files) {
                const listItem = document.createElement('li');
                listItem.className = 'w3-padding-small';

                let iconClass = 'fa-file-o';
                if (file.type.includes('image')) iconClass = 'fa-file-image-o w3-text-blue';
                if (file.type.includes('pdf')) iconClass = 'fa-file-pdf-o w3-text-red';
                if (file.type.includes('sheet')) iconClass = 'fa-file-excel-o w3-text-green';

                listItem.innerHTML = `
            <i class="fa ${iconClass}"></i> ${file.name}
            <span class="w3-right w3-small">${(file.size/1024/1024).toFixed(2)} MB</span>
        `;
                fileList.appendChild(listItem);
            }
        }
    </script>

</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #495057;
        }

        header {
            background-color: #343a40;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        main {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #343a40;
            color: white;
        }

        tr:hover {
            background-color: #e9ecef;
        }

        form {
            margin-bottom: 20px;
        }

        form input, form select, form button {
            margin: 8px;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        form button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0056b3;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        p {
            color: #007bff;
        }

        .row {
            display: flex;
            margin-bottom: 10px;
        }

    </style>
</head>
<body>
    <header>
        <h1>User Management System</h1>
    </header>

    <main>
        <p>Note : if the excel have users that already exist in the DB then the <span style="color: red">import users tool</span> will ignore those users and add only the new users!</p>
        <form action="{{ route('import') }}" method="post" enctype="multipart/form-data">
            @csrf
            <label for="file">Choose file:</label>
            <input type="file" name="file" id="file" required>
            <button type="submit">Import Users</button>
        </form>
        <p>Use Ctrl to multi-select</p>
        <div class="row">
        <form id="exportForm" action="{{ route('export') }}" method="get" enctype="multipart/form-data">
            @csrf
                <label for="columns">Select Columns:</label>
                <select id="columns" name="columns[]" multiple>
                    <option value="name">Name</option>
                    <option value="email">Email</option>
                    <option value="phone">Phone</option>
                </select>

                <label for="rowLimit">Row Limit:</label>
                <input type="number" id="rowLimit" name="row_limit" min="1" value="10">
                <button type="button" onclick="exportUsers()">Export Users</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>

                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>

    <script>
        function exportUsers() {
            var columnsSelect = document.getElementById('columns');
            var selectedColumns = Array.from(columnsSelect.selectedOptions).map(option => option.value);

            var rowLimit = document.getElementById('rowLimit').value;

            var columnsInput = document.createElement('input');
            columnsInput.type = 'hidden';
            columnsInput.name = 'selected_columns';
            columnsInput.value = JSON.stringify(selectedColumns);

            var rowLimitInput = document.createElement('input');
            rowLimitInput.type = 'hidden';
            rowLimitInput.name = 'row_limit';
            rowLimitInput.value = rowLimit;

            var exportForm = document.getElementById('exportForm');
            exportForm.appendChild(columnsInput);
            exportForm.appendChild(rowLimitInput);

            exportForm.submit();
        }
    </script>
</body>
</html>

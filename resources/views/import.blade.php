<form action="{{ route('import') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" required>
    <button type="submit">Import Users</button>
</form>

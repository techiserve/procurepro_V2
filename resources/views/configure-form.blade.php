@extends('stack.layouts.admin')

@section('content')

    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
   



      <h1>Configure Form</h1>
    <form method="POST" action="{{ route('form.configure.store') }}">
        @csrf
        <div id="fields">
            <!-- Dynamic fields will be added here -->
        </div>
        <button type="button" onclick="addField()">Add Field</button>
        <br><br>
        <button type="submit">Save Configuration</button>
    </form>

</div>
@endsection
<script>
        function addField() {
            const container = document.getElementById('fields');
            const index = container.children.length;
            const div = document.createElement('div');
            div.innerHTML = `
                <input type="text" name="fields[${index}][name]" placeholder="Field Name" required>
                <input type="text" name="fields[${index}][label]" placeholder="Label" required>
                <select name="fields[${index}][type]" required>
                    <option value="string">String</option>
                    <option value="integer">Integer</option>
                    <option value="text">Text</option>
                </select>
                <br><br>
            `;
            container.appendChild(div);
        }
    </script>
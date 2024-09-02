<!-- resources/views/your-view.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procure Pro 360</title>
    <!-- Include Bootstrap CSS for the modal -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Modal -->
      	  <!-- /.modal for provinces modal -->
    <div class="modal fade" id="addProvince" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-md" role="document">
            	<form method="post" action="/executivehome/store">
            		 @csrf
	              <div class="modal-content">
	                <div class="modal-header">
	                  <h4 class="modal-title">Select Company</h4>
	                
	                </div>
	                <div class="modal-body">
                  <div class="form-group">
                                <label for="province_id">Companies</label>
                                <select name="company" class="js-example-basic-single form-control" required>
                                <option value="" selected disabled>-- Select Company --</option>
                                    @foreach($companies as $company)
                                    <option value="{{ $company->companyId }}"> @foreach($allcompanies as $comp) @if($comp->id == $company->companyId)
                                    {{ $comp->name }}
                                    @endif  @endforeach</option>
                                    @endforeach
                                </select>
                  </div>
	                </div>
	                <div class="modal-footer">
	                  <button class="btn btn-primary" type="submit">Select Company</button>
	                </div>
	              </div>
	            </form>
              <!-- /.modal-content-->
            </div>
            <!-- /.modal-dialog-->
          </div>
    </div>

    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Activate the modal as soon as the page is rendered
            $('#addProvince').modal('show');
        });
    </script>
</body>
</html>

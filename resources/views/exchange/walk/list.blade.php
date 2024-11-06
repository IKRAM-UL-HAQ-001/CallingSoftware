@extends("layouts.main")
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-11 mb-xl-0 mx-auto my-5 border w-full bg-white rounded d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center p-3 border-bottom mb-5">
                <h2 class="mb-0">Walks</h2>
                <div>
                    <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#addPhoneNumberModal" 
                    data-id="">Form</button>
                </div>
            </div>
            <div class="flex-grow-1 d-flex flex-column justify-content-center align-items-center col-12">
                <div class="card-body px-0 pb-2 px-3 col-12">
                    <div class="table-responsive p-0">
                        <table id="DataTable" class="table align-items-center mb-0 table-striped table-hover px-2">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary font-weight-bolder text-dark">Name</th>
                                    <th class="text-uppercase text-secondary font-weight-bolder text-dark">Phone Number</th>
                                    <th class="text-uppercase text-secondary font-weight-bolder text-dark">Feedback</th>
                                    <th class="text-uppercase text-secondary font-weight-bolder text-dark">Amount</th>
                                    <th class="text-center text-uppercase text-secondary font-weight-bolder text-dark">Date and Time</th>
                                </tr>
                            </thead>
                            <tbody id="DataTableBody">
                                @foreach ($Walks as $walk)
                                <tr data-user-id="a" data-exchange-id="a">
                                    <td style="width: 45%;" class="encrypted-data">{{$walk->name}}</td>
                                    <td style="width: 45%;" class="encrypted-data">{{$walk->phone}}</td>
                                    <td style="width: 45%;" class="encrypted-data">{{$walk->feedback}}</td>
                                    <td style="width: 45%;" class="encrypted-data">{{$walk->amount}}</td>
                                    <td style="width: 45%;" class="encrypted-data">{{$walk->created_at}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addPhoneNumberModal" tabindex="-1" aria-labelledby="addPhoneNumberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center" style="background: #344767;">
                <h5 class="modal-title text-white" id="addPhoneNumberModalLabel" >Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="addPhoneForm">
                  @csrf <!-- Add CSRF token for Laravel -->
                  <div class="mb-3">
                      <label for="customer_name" class="form-label">Customer Name </label>
                      <input type="text" class="form-control border px-3" id="customer_name" name="customer_name" placeholder="Enter Customer Name" required>
                  </div>
                  <div class="mb-3">
                      <label for="customer_phone" class="form-label">Customer Phone Number </label>
                      <input type="text" class="form-control border px-3 customer_phone" id="customer_phone" name="customer_phone" placeholder="Enter Customer Phone Number" required>
                      <input type="hidden" class="form-control border px-3 customer_phone" id="phone_id" name="phone_id" placeholder="Enter Customer Phone Number">
                  </div>
                  <div class="mb-3">
                    <label for="feedback" class="form-label">Customer Feedback </label>
                    <input type="text" class="form-control border px-3" id="feedback" name="customer_feedback" placeholder="Enter Feedback" required>
                  </div>
                  <div class="mb-3">
                    <label for="followup" class="form-label">Customer Amount </label>
                    <input type="text" class="form-control border px-3" id="followup" name="customer_amount" placeholder="Enter Amount" required>
                  </div>
              </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-action="{{ route('exchange.demo_send.formPost') }}">Demo Send</button>
            <button type="button" class="btn btn-warning" data-action="{{ route('exchange.reject.formPost') }}">Reject</button>
            <button type="button" class="btn btn-warning" data-action="{{ route('exchange.refer_id.formPost') }}">Refer ID</button>
            <button type="button" class="btn btn-success" data-action="{{ route('exchange.new_id.formPost') }}">New ID</button>
            <button type="button" class="btn btn-info" data-action="{{ route('exchange.follow_up.formPost') }}">Follow Up</button>
            <button type="button" class="btn btn-dark" data-action="{{ route('exchange.complaint.formPost') }}">Complaint</button>
            <button type="button" class="btn btn-primary" data-action="{{ route('exchange.walk.formPost') }}">Walk</button> 
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>                    
          </div>
        </div>
    </div>
</div>
<script>

    document.querySelectorAll('[data-bs-target="#addPhoneNumberModal"]').forEach(button => {
        button.addEventListener('click', function () {
            const entryId = button.getAttribute('data-id');

            document.getElementById('phone_id').value = entryId;
        });
    });


    document.querySelectorAll('.modal-footer button[data-action]').forEach(button => {
        button.addEventListener('click', () => {
            const form = document.getElementById('addPhoneForm');
            const formData = new FormData();

            formData.append('customer_name', encryptData(form.customer_name.value));
            formData.append('customer_phone', encryptData(form.customer_phone.value));
            formData.append('customer_feedback', encryptData(form.feedback.value));
            formData.append('customer_amount', encryptData(form.followup.value));
            formData.append('phone_id', form.phone_id.value);



            const actionRoute = button.getAttribute('data-action');

            fetch(actionRoute, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                form.reset();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
</script>
@endsection

@extends("layout.main")
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 d-flex justify-content-between align-items-center px-3">
                        <p style="color: white;"><strong>Follow-Up Table</strong></p>
                        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addFollowUpModal">Add New Follow-Up</button>
                    </div>
                </div>
                <div class="card-body px-0 pb-2 px-3">
                    <div class="table-responsive p-0">
                        <table id="FollowUpTable" class="table align-items-center mb-0 table-striped table-hover px-2">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Follow-Up Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date and Time</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($followUpRecords as $followUp)
                                <tr>
                                    <td>{{ $followUp->name }}</td>
                                    <td>{{ $followUp->created_at }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-danger btn-sm" onclick="deleteFollowUp(this, {{ $followUp->id }})">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addFollowUpModal" tabindex="-1" aria-labelledby="addFollowUpModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h5 class="modal-title" id="addFollowUpModalLabel" style="color:white">Add New Follow-Up</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addFollowUpForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Follow-Up Name</label>
                            <input type="text" class="form-control border px-3" id="name" name="name" placeholder="Enter Follow-Up Name" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addFollowUp()">Save FollowUp</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
        const userTable = $('#FollowUpTable').DataTable({
            pagingType: "full_numbers",
            language: {
                paginate: {
                    first: '«',
                    last: '»',
                    next: '›',
                    previous: '‹'
                }
            },
            lengthMenu: [1, 10, 25, 50],
            pageLength: 10
        });
});

function addFollowUp() {
    const name = document.getElementById('name').value;

    $.ajax({
        url: "{{ route('care_center.follow_up.store') }}",
        method: "POST",
        data: {
            name: name,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.message) {
                alert(response.message);
                closeModal();
            }

            $('#addFollowUpModal').modal('hide');
            document.getElementById('addFollowUpForm').reset();
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert('Error: ' + xhr.status + ' - ' + xhr.statusText);
        }
    });
}

function deleteFollowUp(button, id) {
    const row = $(button).parents('tr');
    const table = $('#FollowUpTable').DataTable();

    if (!confirm('Are you sure you want to delete this followup?')) {
        return;
    }

    $.ajax({
        url: "{{ route('care_center.follow_up.destroy') }}",
        method: "POST",
        data: {
            id: id,
            // _method: 'DELETE',
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                table.row(row).remove().draw();
                alert(response.message);
            } else {
                alert(response.message || 'Failed to delete the followup.');
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert('Error: ' + xhr.status + ' - ' + xhr.statusText);
        }
    });
}
</script>

@endsection

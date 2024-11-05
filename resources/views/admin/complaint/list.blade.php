@extends("layouts.main")
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-11 mb-xl-0 mx-auto my-5 border w-full bg-white rounded d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center p-3 border-bottom mb-5">
                <h2 class="mb-0">Complaint</h2>
            </div>
            <div class="flex-grow-1 d-flex flex-column justify-content-center align-items-center col-12">
                <div class="card-body px-0 pb-2 px-3 col-12">
                    <div class="table-responsive p-0">
                        <table id="DataTable" class="table align-items-center mb-0 table-striped table-hover px-2">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary font-weight-bolder text-dark">User Name</th>
                                    <th class="text-center text-uppercase text-secondary font-weight-bolder text-dark">Action</th>
                                </tr>
                            </thead>
                            <tbody id="DataTableBody">
                                @foreach ($Complaints as $Complaint)
                                <tr data-user-id="a" data-exchange-id="a">
                                    <td style="width: 45%;" class="encrypted-data">{{$Complaint->id}}</td>
                                    <td style="width: 10%; text-align: center;">
                                        <button class="btn btn-danger btn-sm" onclick="DeleteId(this)">Delete</button>
                                        <button class="btn btn-warning btn-sm" onclick="EditId(this)">Edit</button>
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
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
<script>
    $(document).ready(function() {
        $('#DataTable').DataTable({
            pagingType: "full_numbers",
            order: [[0, 'desc']],
            language: {
                paginate: {
                    first: '«',
                    last: '»',
                    next: '›',
                    previous: '‹'
                }
            },
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10
        });

        const secretKey = 'MRikam@#@2024!';
        $('.encrypted-data').each(function() {
            const encryptedData = $(this).text().trim();
            const decryptedData = CryptoJS.AES.decrypt(encryptedData, secretKey).toString(CryptoJS.enc.Utf8);
            $(this).text(decryptedData);
        });

        $('#form').on('submit', function(e) {
            e.preventDefault();
            const exchangeName = $('#exchange_name').val();
            const encryptedExchangeName = CryptoJS.AES.encrypt(exchangeName, secretKey).toString();
            const formData = {
                exchange_name: encryptedExchangeName,
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
    if (response.success) {
        $('#success').show().text(response.message);
        $('#DataTable').DataTable().ajax.reload();
        $('#myModal').modal('hide');
        $('#form')[0].reset();
        setTimeout(function() { 
            $('#success').fadeOut('slow');
        }, 2000); 
    } else {
        $('#error').show().text(response.message);
        setTimeout(function() { 
            $('#error').fadeOut('slow');
        }, 2000);
    }
},
error: function() {
    $('#error').show().text('An error occurred.');
    setTimeout(function() { 
        $('#error').fadeOut('slow');
    }, 2000);
}

            });
        });
    });
</script>
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Datatable</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0-alpha3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">


</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Laravel 10 Yajra Datatables Example</h2>
            <table  id="datatable" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th style="visibility: hidden;"></th>
                        <th>No</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="table-rows">
    
                </tbody>
            </table>
        </div>
</body>
{{-- Datatable cdns::begin --}}
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script> {{-- JQuery ui for sortable feature --}}
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

{{-- Datatable cdns::end --}}


<script>
    $(document).ready(function () {
        let table = $('#datatable').DataTable({
            "order": [[ 0, 'asc' ]],
            "lengthMenu": [ 10, 25, 50, 75, 100 ],
            processing: true,
            serverSide: true,
            rowId: 'id',
            ajax: "{{ route('users.list') }}",
            columns: [
                {data: 'drag', name: 'drag'},
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'first_name', name: 'first_name'},
                {data: 'last_name', name: 'last_name'},
                {data: 'email', name: 'email'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: true, 
                    searchable: true,
                    delete:true
                },
            ]
        }); 


        /*console.log(table.rows().ids());


        $('#table-rows').sortable({
            items: "tr",
            cursor: 'move',
            opacity: 0.6,
            update: function() {
              	sendOrderToServer();
             }
        }); */

        function sendOrderToServer()
        {
            var order = [];
            var total_items = (this).$('.hidden').data('total');

            $('#table-rows tr').each(function (index, element)
            { 
                order.push({
                    'user_id': element.id,
                    'position': index+1,
                    'total': total_items
                });
            });
        }
    });
</script>

<script>
        function deleteUser(user_id) 
        {
            console.log(user_id);
            $.ajax({
                type: "post",
                url: "{{ route('users.delete') }}",
                data: {'id':user_id},
                dataType: "json",

                success: function (response) {
                    console.log('success');
                },
                
                error: function (xhr, status, error) {
                    console.log('error');
                }
            });
        }
</script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });
</script>
</html>
@extends('layouts.layout')

@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatablecard-s.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h2 class="card-header bg-secondary text-white">
                    User URL
                    <a class="btn btn-primary" style="position: absolute; top: 20%; right: 1%;" href="{{ url('admin/users/')}}"> Back</a>
                    <a class="btn btn-success" style="position: absolute; top: 20%; right: 7%;" href="{{ url('admin/user/'. $userId . '/links/create') }}"> <i class="fas fa-plus"></i> Add New URL</a>
                </h2>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered datatable">
                            <thead>
                                <tr>
                                    <th>Url</th>
                                    <th>Generated Url</th>
                                    <th>Count</th>
                                    <th width="150" class="text-center">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete  Modal -->
<div class="modal" id="DeleteLinkModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">URL Delet</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <h4>Are you sure want to delete this URL?</h4>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="SubmitDeleteLink">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // init datatable.
        var dataTable = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            pageLength: 10,
            // scrollX: true,
            "order": [[ 0, "desc" ]],
            ajax: "/get-links-admin/"+{{$userId}},
            columns: [
                {data: 'primary_link', name: 'link'},
                {data: 'generated_link', name: 'generate url'},
                {data: 'count', name: 'count'},
                {data: 'Actions', name: 'Actions',orderable:false,serachable:false,sClass:'text-center'},
            ]
        });

        // Get single  in EditModel
        var id;
        $('body').on('click', '#getEditLinkData', function(e) {
            // e.preventDefault();
            $('.alert-danger').html('');
            $('.alert-danger').hide();
            id = $(this).data('id');
            document.location.href = "links/"+id+"/edit";
        });

        // Delete link Ajax request.
        var deleteID;
        $('body').on('click', '#getDeleteId', function(){
            deleteID = $(this).data('id');
        })
        $('#SubmitDeleteLink').click(function(e) {
            e.preventDefault();
            var id = deleteID;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "links/"+id,
                method: 'DELETE',
                success: function(result) {
                    location.reload();
                }
            });
        });
    });
</script>
@endsection
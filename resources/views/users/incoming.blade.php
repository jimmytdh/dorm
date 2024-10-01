<style>
    .form-inline {
        display: block;
    }
    @media (max-width: 575px) {
        .btn { width: 100% !important;}
    }
</style>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="font-weight-bold"><span class="text-danger">Incoming</span> Documents
                </h2>
            </div>
            <div class="card-body">
                <form class="form-inline" id="searchForm">
                    @csrf
                    <div class="form-group row">
                        <input type="text" class="form-control mr-1 mb-1" id="search" value="{{ session('searchIncoming') }}"
                               name="search" placeholder="Search...">
                        <button type="submit" class="btn btn-success mr-1 mb-1">
                            <i class="fa fa-search"></i> Search
                        </button>
                        <a href="{{ url('document') }}" class="btn btn-primary handle-link mr-1 mb-1">
                            <i class="fa fa-book"></i> Documents List
                        </a>
                    </div>
                </form>
                <hr>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover">
                        <thead class="bg-dark">
                        <tr>
                            <th class="nowrap">Route No.</th>
                            <th class="nowrap">Description</th>
                            <th class="nowrap">Forward Remarks</th>
                            <th class="nowrap">Forwarded By</th>
                            <th class="nowrap">Date Forwarded</th>
                            <th class="nowrap">TAT</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($documents as $document)
                            <tr>
                                <td>
                                    <a href="#acceptModal" data-toggle="modal" class="editable route_no"
                                       data-id="{{ $document->id }}"
                                       data-route="{{ $document->document->route_number }}">
                                        {{ $document->document->route_number }}
                                    </a>
                                </td>
                                <td>{{ $document->document->description }}</td>
                                <td>{!! $document->forward_remarks ?? '<span class="text-danger font-italic">Empty</span>' !!}</td>
                                <td>
                                    {!!  (@$document->forwardBy->lname) ? $document->forwardBy->lname.", ":'<span class="text-danger font-italic">None</span>'  !!} {{ @$document->forwardBy->fname }}
                                    {!!  ($document->sectionFrom) ? "<small class='text-danger'>(".$document->sectionFrom->name.")</small>" : null !!}
                                </td>
                                <td>{{ date('M d, Y h:i:s A',strtotime($document->created_at)) }}</td>
                                <td class="turnaround-time text-danger"></td>
                            </tr>
                        @empty
                            <div class="alert alert-warning">
                                No documents found!
                            </div>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('modal.acceptModal')
@include('js.customUrl')
@php
    $num = 4;
@endphp
<script>
    $(function () {
        let document_id = 0;
        updateTurnAroundTime(3);

        $('.route_no').click(function(){
            var route_no = $(this).data('route')
            document_id = $(this).data('id')

            $('.modal-title').html(route_no)
        })

        $('#acceptForm').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: `{{ route('tracking.accept') }}`,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    document_id: document_id,
                    remarks: $('#remarks').val()
                },
                success: () =>{
                    $('#acceptModal').modal('hide');
                    resetForm()
                    // Bind the hidden.bs.modal event to navigate after the modal is hidden
                    $('#acceptModal').on('hidden.bs.modal', function () {
                        navigate(window.location.href);
                        // Unbind the event after it's triggered to prevent multiple calls
                        $(this).off('hidden.bs.modal');
                    });
                },
                error: async (xhr) => {
                    // Handle validation errors
                    if (xhr.status === 422) {
                        await resetForm();
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            // Displaying errors on form
                            $('#error_messages').append('<div class="alert alert-danger">'+value+'</div>');
                        });

                    } else {
                        // Handle other errors (if any)
                        console.error(xhr.responseText);
                    }
                }
            })
        })

        async function resetForm(){
            $('#error_messages').empty();
        }

        $('#searchForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: `{{ route('document.search.incoming') }}`,
                type: 'POST',
                data: {
                    search: $('#search').val(),
                    _token: "{{ csrf_token() }}"
                },
                success: (response)=> {
                    console.log(response)
                    navigate(window.location.href)
                }
            })
        })
    })
</script>
@include('js.tat')

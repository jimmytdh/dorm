<style>
    .form-inline {
        display: block;
    }
    .table td { vertical-align: middle;}
    @media (max-width: 575px) {
        .btn { width: 100% !important;}
    }
</style>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="font-weight-bold"><span class="text-danger">Section</span> Logs
                </h2>
            </div>
            <div class="card-body">
                <form class="form-inline" id="searchForm">
                    @csrf
                    <div class="form-group row">
                        <input type="text" class="form-control mr-1 mb-1" id="search" value="{{ session('searchLogs') }}"
                               name="search" placeholder="Search...">
                        <button type="submit" class="btn btn-success mr-1 mb-1">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </form>
                <hr>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover">
                        <thead class="bg-dark">
                        <tr>
                            <th class="nowrap">Route No.</th>
                            <th class="nowrap">Description</th>
                            <th class="nowrap">Forwarded By</th>
                            <th class="nowrap">Date Forwarded</th>
                            <th class="nowrap">Accepted By</th>
                            <th class="nowrap">Date Accepted</th>
                            <th class="nowrap">Released By</th>
                            <th class="nowrap">Date Released</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($documents as $document)
                            <tr>
                                <td>
                                    <a href="#optionModal" data-toggle="modal" class="editable route_no"
                                       data-id="{{ $document->id }}"
                                       data-route="{{ $document->document->route_number }}">
                                        {{ $document->document->route_number }}
                                    </a>
                                </td>
                                <td>{{ $document->document->description }}</td>
                                <td>
                                    @if($document->forwardBy)
                                        {{ $document->forwardBy->lname }}, {{ $document->forwardBy->fname }}
                                        <small class="text-danger">({{ $document->forwardBy->section->name }})</small>
                                        <br>
                                        <small class="font-italic text-muted">
                                            Remarks: {!! $document->forward_remarks ?? '<span class="text-danger font-italic">Empty</span>' !!}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    @if($document->created_at)
                                        {{ date('M d, Y',strtotime($document->created_at)) }}
                                        <br><small class="text-primary">{{ date('h:i A',strtotime($document->created_at)) }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($document->acceptedBy)
                                    {!!  (@$document->acceptedBy->lname) ? $document->acceptedBy->lname.", ":'<span class="text-danger font-italic">None</span>'  !!} {{ @$document->acceptedBy->fname }}

                                    <small class="text-danger">({{ @$document->acceptedBy->section->name }})</small>
                                    <br>
                                    <small class="font-italic text-muted">
                                        Remarks: {!! $document->accept_remarks ?? '<span class="text-danger font-italic">Empty</span>' !!}
                                    </small>
                                    @else
                                        <span class="text-danger font-italic">Waiting to accept in {{ $document->sectionCurrent->name }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($document->date_accepted)
                                    {{ date('M d, Y',strtotime($document->date_accepted)) }}
                                    <br><small class="text-primary">{{ date('h:i A',strtotime($document->date_accepted)) }}</small>
                                    @endif
                                </td>


                                <td>
                                    @if($document->releaseBy)
                                        {{ $document->releaseBy->lname }}, {{ $document->releaseBy->fname }}
                                        <small class="text-danger">({{ $document->releaseBy->section->name }})</small>
                                        <br>
                                        <small class="font-italic text-muted">
                                            Remarks: {!! $document->release_remarks ?? '<span class="text-danger font-italic">Empty</span>' !!}
                                        </small>
                                    @elseif($document->status==='Cycle End')
                                        <span class="text-success">Cycle End</span>
                                    @else
                                        <span class="text-danger font-italic">Waiting to release</span>
                                    @endif
                                </td>
                                <td>
                                    @if($document->date_released)
                                        {{ date('M d, Y',strtotime($document->date_released)) }}
                                        <br><small class="text-primary">{{ date('h:i A',strtotime($document->date_released)) }}</small>
                                    @endif
                                </td>
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
@include('js.customUrl')
<script>
    $(function () {
        let document_id = 0;
        $('.route_no').click(function(){
            var route_no = $(this).data('route')
            document_id = $(this).data('id')

            $('.modal-title').html(route_no)
        })

        $('#searchForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: `{{ route('document.search.logs') }}`,
                type: 'POST',
                data: {
                    search: $('#search').val(),
                    _token: "{{ csrf_token() }}"
                },
                success: ()=> {
                    navigate(window.location.href)
                }
            })
        })
    })
</script>


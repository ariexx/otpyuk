{{-- check only login user can access this modal --}}
@auth()
    <div>
        @if ($informations != null)
            <div id="information" class="modal fade">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Information</h5>
                            {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
                        </div>
                        <div class="modal-body">
                            <div id="accordion">
                                @if (cache()->has('informations'))
                                    @foreach (cache()->get('informations') as $information)
                                        <div class="accordion">
                                            <div class="accordion-header" role="button" data-toggle="collapse"
                                                data-target="#panel-body-{{ $information->id }}" aria-expanded="true">
                                                <h4>{{ $information->title }}</h4>
                                            </div>
                                            <div class="accordion-body collapse" id="panel-body-{{ $information->id }}"
                                                data-parent="#accordion">
                                                <p class="mb-0">{!! $information->description !!}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                    <center>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                    </center>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @push('scripts')
                <script>
                    $(document).ready(function() {
                        $("#information").modal('show');
                    });
                </script>
            @endpush
        @endif
    </div>
@endauth

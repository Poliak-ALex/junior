@extends('layouts.layout')

@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h2 class="card-header bg-secondary text-white">
                    Edit URL
                    <a class="btn btn-primary" style="position: absolute; top: 20%; right: 1%;" href="{{ route('link.index') }}"> Back</a>
                </h2>
                <div class="card-body">    
                    <form action="{{ route('link.update',$link->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                         <div class="row">
                            {{-- Url field --}}
                            <div class="col-xs-6 col-sm-6 col-md-6"> 
                                <strong>Url:</strong>
                                <input type="text" name="primary_link" maxlength="250" class="form-control {{ $errors->has('primary_link') ? 'is-invalid' : '' }}"
                                    value="{{ old('eprimary_linkmail') == "" ? $link->primary_link : old('primary_link') }}"
                                    placeholder="Url" autofocus >
                                @if($errors->has('primary_link'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('primary_link') }}</strong>
                                    </div>
                                @endif
                            </div>  
                            
                            {{-- Generated Url field --}}
                            <div class="col-xs-6 col-sm-6 col-md-6"> 
                                <strong>Generated Url:</strong>       
                                <div class="input-group has-validation" bis_skin_checked="1">
                                    <span class="input-group-text"> {{$_SERVER['HTTP_HOST'].'/'}} </span>
                                    <input type="text" name="generated_link" id="generated_link" maxlength="250" class="form-control {{ $errors->has('generated_link') ? 'is-invalid' : '' }}"
                                    value="{{ old('generated_link') == "" ? $link->generated_link : old('generated_link') }}"       
                                    placeholder="Enter or Generate url" oninput="verify(this.value)">
                                    @if($errors->has('generated_link'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('generated_link') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding-left:8px;padding-right:8px;margin-top: 20px;"  } >
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="button"  class="btn btn-success" id="ChangeCompanyStatus"> <i class="fa fa-magic" aria-hidden="true"></i>Generate</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection

@section('script')
<script type="text/javascript">
        
    function verify(id) {

        $.ajaxSetup(
        {
            headers: 
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax(
        {
            url: "{{route('verify-link')}}",
            type: "POST",
            data: {
                generated_link : id,
            },
            success: function(result) 
            {   
                // alert(result);
                var div = document.getElementById("generated_link");
                if(result == 'err')
                {
                    div.classList.add("is-invalid");
                    // var container = document.createElement('div')
                    // container.innerHTML = '<div class="invalid-feedback" bis_skin_checked="1">\
                    //     <strong>The generated link has already been taken.</strong>\
                    //     </div>';
                    // div.insertBefore(container, div.firstChild);
                }
                
                if(result == 'ok')
                {
                    div.classList.remove("is-invalid");
                }               
            }
        });
    };    

    $(document).ready(function() {
        // Change Company status  Ajax request.
        
        $('body').on('click', '#ChangeCompanyStatus', function()
        {   
            $.ajaxSetup(
            {
                headers: 
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax(
            {
                url: "{{route('generate-link')}}",
                method: 'GET',
                success: function(result) 
                {   
                    console.log(result);
                    document.getElementById("generated_link").value = result;
                }
            });
        })
    });
</script>
@endsection
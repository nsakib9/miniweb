@if ($errors->any())
    <div class="alert alert-danger" style="text-align: center; color:red; padding-bottom: 30px">
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    </div>
@endif
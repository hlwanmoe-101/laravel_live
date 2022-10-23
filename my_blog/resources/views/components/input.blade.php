<div class="mb-3">
    <label for="title">{{$inputTitle}}</label>
    <input type="{{$type}}"
           name="{{$name}}"
           @isset($form)
           form="{{$form}}"
           @endisset
           @isset($value)
           value="{{old($name,$value)}}"
           @else
           value="{{old($name)}}"
               @endisset
           class="form-control @error($name) is-invalid @enderror">
    @error($name)
    <p class="small text-danger">{{$message}}</p>
    @enderror
</div>

<div class="component-flex">


<label>
    <input type="radio" name="{{$name}}"  value="1">{{$value1}}
    </label>
    <label>
    <input type="radio" name="{{$name}}"  value="2">{{$value2}}
</label>
<label>
    <input type="radio" name="{{$name}}"  value="3">{{$value3}}
</label>
<label>
    <input type="radio" name="{{$name}}"  value="4">{{$value4}}
</label>

    @error($name)

    <div style="font-size: 12px; color:red">
        {{$message}}
    </div>

    @enderror

</div>

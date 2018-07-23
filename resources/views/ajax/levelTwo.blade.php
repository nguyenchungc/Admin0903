<select name="id_type" class="form-control" id="level-two">
    @foreach($levelTwo as $l2)
    <option value="{{$l2->id}}">{{$l2->name}}</option>
    @endforeach
</select>
@foreach($rows as $row)
    <div class="form-group">
        <label for="{{$row['name']}}">{{$row['display']}}</label>

        {{-- Zobrazení podle typu inputu --}}
        @if($row['type'] == 'string')
            <input id="{{$row['name']}}" type="text" class="form-control"
                   name="{{$row['name']}}"
                   @if(isset($object->{$row['name']}))
                   value="{{ $object->{$row['name']} }}"
                   @else
                   value="{{ old($row['name']) }}"
                   @endif
                   placeholder="{{$row['display']}}">

        @elseif($row['type'] == 'number')
            <input id="{{$row['name']}}" type="number" class="form-control"
                   name="{{$row['name']}}"
                   @if(isset($object->{$row['name']}))
                   value="{{ $object->{$row['name']} }}"
                   @else
                   value="{{ old($row['name']) }}"
                   @endif
                   placeholder="{{$row['display']}}">

        @elseif($row['type'] == 'bool' || $row['type'] == 'boolean')
            <select id="{{$row['name']}}" class="form-control" name="{{$row['name']}}">
                <option value="0">{{ $row['strings']['true'] }}</option>
                <option value="1"
                        @if(isset($object) and $object->{$row['name']} == 1)
                        selected
                        @endif>{{ $row['strings']['false'] }}</option>
            </select>

        @elseif($row['type'] == 'select')
            <select id="{{$row['name']}}" class="form-control" name="{{$row['name']}}">

                @forelse($row['options'] as $option)
                    <option value="{{$option['value']}}"
                            @if(isset($object) and $object->{$row['name']} == $option['value'])
                            selected
                            @endif
                    >{{$option['title']}}</option>
                @empty
                    <option disabled>žádné položky k dispozici</option>
                @endforelse
            </select>
        @elseif($row['type'] == 'email')
            <input id="{{$row['name']}}" type="email" class="form-control"
                   name="{{$row['name']}}"
                   @if(isset($object->{$row['name']}))
                   value="{{ $object->{$row['name']} }}"
                   @else
                   value="{{ old($row['name']) }}"
                   @endif
                   placeholder="{{$row['display']}}">
        @elseif($row['type'] == 'datetime')
            <input id="{{$row['name']}}" type="datetime-local" class="form-control"
                   name="{{$row['name']}}"
                   @if(isset($object->{$row['name']}))
                   value="{{ $object->{$row['name']} }}"
                   @else
                   value="{{ old($row['name']) }}"
                   @endif
                   placeholder="{{$row['display']}}">

        @elseif($row['type'] == 'password')
            <input id="{{$row['name']}}" type="password" class="form-control"
                   name="{{$row['name']}}"
                   placeholder="{{$row['display']}}">
            <br>
            <input id="{{$row['name']}}_confirm" type="password" class="form-control"
                   name="{{$row['name']}}_confirmation"
                   placeholder="{{$row['display']}} pro ověření">
        @endif

        {{-- Alert validace --}}
        @if ($errors->first($row['name']))
            <span class="text-danger"><strong>{{ $errors->first($row['name']) }}</strong></span>
        @endif
    </div>
@endforeach

<style>
    .pt-label {
        color:          #9300b0;
        text-transform: uppercase;
        font-weight:    bold;
    }
</style>

<a href="{{route('organize.dashboard.subGroup', ['group' => $group->parentGroup->id, 'subgroup' => $group->id])}}"
   class="pt-label"
   title="Rozkliknout nástěnku týmu {{$group->name}}">{{$group->getAbbr()}}</a>
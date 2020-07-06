<a onclick="cycleTask({{$task->id}})" style="cursor: pointer; font-size: 16px" id="status{{$task->id}}">
    @if($task->status == 0)
        <span style="font-weight: bold; color: red">???</span>
    @elseif($task->status == 1)
        <i class="fas fa-sync" style="color: #ff982b"></i>
        <span style="color: #ff982b; font-size: 11px; text-transform: uppercase; font-weight: bold">Probíhá</span>
    @else
        <i class="fas fa-check" style="color: #00891a"></i>
        <span style="color: #00891a; font-size: 11px; text-transform: uppercase; font-weight: bold">Dokončeno</span>
    @endif
</a>


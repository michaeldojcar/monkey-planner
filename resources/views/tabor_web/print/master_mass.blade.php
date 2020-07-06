<html>
<body>
    <script>
        function PrintAll() {
            var pages = [
                @foreach($group->users as $member)
                "{{route('organize.program.print', [$group, $member])}}"{{$loop->last ? '' : ','}}
                @endforeach
            ];
            for (var i = 0; i < pages.length; i++) {
                var oWindow = window.open(pages[i]);
            }
        }

        PrintAll();
    </script>
</body>
</html>
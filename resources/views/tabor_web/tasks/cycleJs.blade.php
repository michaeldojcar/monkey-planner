<script>
    function cycleTask(id) {

        $.get("/organizace-akce/ukol/" + id + "/status_update", function (data) {
            console.log("Cycle of task " + id + " was performed." + data);

            if (data === '0') {
                $("#status" + id).html("<span style=\"font-weight: bold; color: red\">???</span>")

            }
            if (data === '1') {
                $("#status" + id).html("<i class=\"fas fa-sync\" style=\"color: #ff982b\"></i>\n" +
                    "        <span style=\"color: #ff982b; font-size: 11px; text-transform: uppercase; font-weight: bold\">Probíhá</span>");
            }
            if (data === '2') {
                $("#status" + id).html("<i class=\"fas fa-check\" style=\"color: #00891a\"></i> <span style=\"color: #00891a; font-size: 11px; text-transform: uppercase; font-weight: bold\">Dokončeno</span>");
            }
        });
    }
</script>
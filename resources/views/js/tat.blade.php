<script>
    var num = @json($num);
    function updateTurnAroundTime() {
        // Iterate through each row in the table
        $('tbody tr').each(function() {
            const dateInText = $(this).find('td:eq('+num+')').text(); // Get the Date In text
            if (dateInText) {
                const dateIn = new Date(dateInText);
                const currentTime = new Date();
                const timeDiff = currentTime - dateIn;

                // Calculate hours, minutes, and seconds
                const days = Math.floor(timeDiff / (24 * 3600000)); // 1 day = 24 * 3600000 milliseconds
                const hours = Math.floor((timeDiff % (24 * 3600000)) / 3600000); // Remaining hours
                const minutes = Math.floor((timeDiff % 3600000) / 60000); // Remaining minutes
                const seconds = Math.floor((timeDiff % 60000) / 1000); // Remaining seconds

                // Format the time difference as "X hours Y minutes Z seconds"
                let formattedTime = '';
                if (days > 0) {
                    formattedTime += days + 'd ';
                }
                if (hours > 0) {
                    formattedTime += hours + 'h ';
                }
                if (minutes > 0) {
                    formattedTime += minutes + 'm ';
                }
                if (days < 1 && seconds > 0) {
                    formattedTime += seconds + 's';
                }

                // Update the "Turn Around Time" column
                $(this).find('.turnaround-time').text(formattedTime);
            }
        });
        // Request the next animation frame
        requestAnimationFrame(updateTurnAroundTime);
    }
</script>

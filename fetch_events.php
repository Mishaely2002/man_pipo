<?php
$conn = new mysqli("localhost", "root", "", "school_dbs");
$result = $conn->query("SELECT * FROM events");
$events = [];
while ($row = $result->fetch_assoc()) {
  $color = match($row['category']) {
    'exams' => '#ff4d4d',
    'sports' => '#4dff4d',
    'clubs' => '#4d4dff',
    'spiritual' => '#ffff4d',
    default => '#cccccc',
  };
  $events[] = [
    'id' => $row['id'],
    'title' => $row['title'],
    'start' => $row['start'],
    'end' => $row['end'],
    'color' => $color
  ];
}
echo json_encode($events);
?>
<!-- Include FullCalendar -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js'></script>

<div id='calendar'></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    editable: true,
    selectable: true,
    events: 'fetch_events.php', // Your PHP endpoint
    eventColor: '#378006',
    eventClick: function(info) {
      alert('Event: ' + info.event.title);
    },
    eventDrop: function(info) {
      // Send updated date to backend
      updateEvent(info.event);
    }
  });
  calendar.render();
});
</script>

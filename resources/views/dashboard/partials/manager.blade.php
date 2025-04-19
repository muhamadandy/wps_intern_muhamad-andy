<div>
  <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Dashboard Header -->
    <div class="px-4 py-5 sm:px-6">
      <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
    </div>

    <!-- Kalender untuk Log Harian -->
    <div class="mt-8">
      <h2 class="text-lg font-medium text-gray-900">Kalender Log Harian</h2>
      <div id="calendar" class="mt-4 bg-white p-4 rounded-lg shadow"></div>
    </div>
  </div>
</div>

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar')

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'id',
      height: 'auto',
      firstDay: 1, // Mulai dari Senin
      eventTimeFormat: {
        hour: '2-digit',
        minute: '2-digit',
        meridiem: false,
      },
      events: function (info, successCallback, failureCallback) {
        // Fetch events from your endpoint
        fetch('{{ route("calendar.logs") }}')
          .then((response) => response.json())
          .then((data) => {
            // Process the events to add color based on status
            const coloredEvents = data.map((event) => {
              // Add color property based on status
              if (event.status === 'ditolak' || event.contains_rejected === true) {
                event.backgroundColor = '#f44336' // Merah untuk yang ditolak
                event.borderColor = '#f44336'
              } else if (event.status === 'pending' || event.contains_pending === true) {
                event.backgroundColor = '#ffeb3b' // Kuning untuk yang pending
                event.borderColor = '#ffeb3b'
              } else {
                event.backgroundColor = '#4caf50' // Hijau untuk yang disetujui
                event.borderColor = '#4caf50'
              }
              return event
            })

            successCallback(coloredEvents)
          })
          .catch((error) => {
            console.error('Error fetching events:', error)
            failureCallback(error)
          })
      },
      dateClick: function (info) {
        // Format the date as YYYY-MM-DD
        var clickedDate = info.dateStr
        // Redirect to the verification page with the date parameter
        window.location.href = '{{ route("verifikasi-log") }}?date=' + clickedDate
      },
    })

    calendar.render()
  })
</script>

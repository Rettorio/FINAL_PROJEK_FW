<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Live Count Pemilihan Kades</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body style="background-color: #f7f7f7;">

  <div class="container my-5">
    <h2 class="text-center mb-3">Live Count Pemilihan Kepala Desa Waihaong 2025</h2>
    <p class="text-center">Terakhir diperbarui: <span id="waktu">30 Juli 2025, 13:45 WIT</span></p>

    <!-- Total suara masuk -->
    <div class="mb-3">
      <h5>Total Suara Masuk: <strong>1.250</strong> dari 1.500 pemilih</h5>
      <div class="progress">
        <div class="progress-bar bg-info" style="width: 83%;">83%</div>
      </div>
    </div>

    <!-- Data per calon -->
    <div class="row text-center mt-4">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5>Budi Santoso</h5>
            <p>Suara: <strong>480</strong></p>
            <div class="progress mb-2">
              <div class="progress-bar bg-primary" style="width: 38%">38%</div>
            </div>
            <span class="badge bg-secondary">Calon 1</span>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-success">
          <div class="card-body">
            <h5>Siti Aminah</h5>
            <p>Suara: <strong>560</strong></p>
            <div class="progress mb-2">
              <div class="progress-bar bg-success" style="width: 45%">45%</div>
            </div>
            <span class="badge bg-success">Memimpin</span>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5>Joko Raharjo</h5>
            <p>Suara: <strong>210</strong></p>
            <div class="progress mb-2">
              <div class="progress-bar bg-warning" style="width: 17%">17%</div>
            </div>
            <span class="badge bg-secondary">Calon 3</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Grafik Pie + Line -->
    <div class="row mt-5">
      <!-- Pie kecil -->
      <div class="col-md-4">
        <h6 class="text-center">Persentase Suara</h6>
        <canvas id="pieChart" height="200"></canvas>
      </div>

      <!-- Line chart -->
      <div class="col-md-8">
        <h6 class="text-center">Perkembangan Suara per Jam</h6>
        <canvas id="lineChart" height="200"></canvas>
      </div>
    </div>

    <!-- Tombol refresh -->
    <div class="text-center mt-4">
      <button class="btn btn-outline-primary" onclick="location.reload()">🔄 Perbarui Data</button>
    </div>
  </div>

  <script>
    // Pie Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
      type: 'pie',
      data: {
        labels: ['Budi Santoso', 'Siti Aminah', 'Joko Raharjo'],
        datasets: [{
          data: [480, 560, 210],
          backgroundColor: ['#0d6efd', '#198754', '#ffc107']
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'bottom' }
        }
      }
    });

    // Line Chart
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    new Chart(lineCtx, {
      type: 'line',
      data: {
        labels: ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00'],
        datasets: [
          {
            label: 'Budi Santoso',
            data: [50, 120, 210, 300, 370, 480],
            borderColor: '#0d6efd',
            fill: false
          },
          {
            label: 'Siti Aminah',
            data: [60, 130, 220, 310, 400, 560],
            borderColor: '#198754',
            fill: false
          },
          {
            label: 'Joko Raharjo',
            data: [40, 90, 150, 180, 200, 210],
            borderColor: '#ffc107',
            fill: false
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'top' },
          title: { display: false }
        }
      }
    });
  </script>
</body>
</html>

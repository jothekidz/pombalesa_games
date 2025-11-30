const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['jan', 'fev', 'mar', 'abril', 'mai', 'jun', 'jul', 'ago', 'out', 'nov', 'dez'],
      datasets: [{
        label: 'creditos de carbono produzidos',
        data: [350, 500, 300, 100, 500, 300],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          min:0,
          max:1000,
          ticks:{
            stepSize:100
          }
        }
      }
    }
  });
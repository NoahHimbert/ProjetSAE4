function simulateTemperature() {
    const value = (Math.random() * 10 + 20).toFixed(1); // 20.0 à 30.0
    const gauge = document.getElementById('gaugeValue');
    if (gauge) {
      gauge.textContent = value + ' °C';
    }
  }
  
  setInterval(simulateTemperature, 3000); // Mise à jour toutes les 3 sec
  

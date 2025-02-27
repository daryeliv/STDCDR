// Script para inicializar el gráfico
var ctx = document.getElementById('resultadoGrafico').getContext('2d');
var resultadoGrafico = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
        datasets: [{
            label: 'Resultados Mensuales',
            data: [15, 30, 13, 8, 21], // Puedes actualizar esto con datos reales
            backgroundColor: 'rgba(211, 47, 47, 0.5)',
            borderColor: 'rgba(211, 47, 47, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});


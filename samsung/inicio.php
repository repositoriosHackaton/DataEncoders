<?php
session_start();
require_once 'conexion.php';
$correo = mysqli_real_escape_string($conn, $_SESSION['correo']);

// Verifica si el correo está presente en la base de datos
$sql = "SELECT usua_nombre FROM usuario WHERE usua_correo='$correo'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $usua_nombre = $row['usua_nombre'];
} else {
    $usua_nombre = "Usuario no encontrado";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto Samsung</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wordcloud2.js/1.0.0/wordcloud2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wordcloud2.js/1.0.0/wordcloud2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wordcloud2.js/1.0.6/wordcloud2.min.js"></script>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            background-color: #f4f6f9;
        }

        #sidebar {
            width: 250px;
            background-color: #031634;
            color: white;
            padding: 20px;
            transition: width 0.3s;
            /* Transición de ancho */
            overflow-x: hidden;
        }


        #sidebar.collapsed {
            width: 60px;
        }

        #main-content {
            flex-grow: 1;
            padding: 20px;
            transition: all 0.3s;
        }

        .menu-item {
            padding: 10px;
            cursor: pointer;
            color: #c2c7d0;
            display: flex;
            align-items: center;
        }

        .menu-item:hover {
            background-color: #494e53;
        }

        .menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .menu-item span {
            white-space: nowrap;
        }

        .active {
            background-color: #031634;
        }

        #top-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .button {
            padding: 10px;
            background-color: #031634;
            color: white;
            border: none;
            cursor: pointer;
            margin-right: 10px;
        }



        .dashboard-section {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            padding: 20px;
            margin-bottom: 20px;
        }

        .user-panel {
            border-bottom: 1px solid #4f5962;
            margin-bottom: 20px;
            padding-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .user-panel img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        #toggle-sidebar {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            margin-bottom: 20px;
        }


        #top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            /* Ajusta el padding según sea necesario */
            border-radius: 0%;
        }

        .top-bar-left {
            display: flex;
            align-items: center;
        }

        .top-bar-right {
            flex-grow: 1;
            /* Hace que ocupe todo el espacio disponible */
        }

        .button {
            padding: 10px 20px;
            background-color: #031634;
            /* Azul marino bonito */
            color: white;

            /* Borde del mismo color que el fondo */
            border-radius: 10px;
            /* Borde curvado */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Sombra */
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
            margin-left: 10px;
            /* Espacio entre botones */
        }

        .button:hover {
            background-color: #005f6b;
            /* Cambio de color al pasar el mouse */
        }


        .buscar {
            display: flex;
            justify-content: center;
            margin-bottom: 2px;
        }



        #busqueda {
            width: 300px;
            padding: 10px;
            border: 2px solid #ced4da;
            border-radius: 2px 0 0 2px;
            outline: none;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        #busqueda:focus {
            border-color: #104389;
        }

        .dashboard-section {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            padding: 20px;
            margin-bottom: 20px;

            align-items: center;
        }

        .report-content {
            display: flex;
            align-items: center;

        }

        .report-button {
            flex: 1;

            text-align: left;

        }

        .report-image {
            margin-left: auto;

        }

        h3 {
            font-size: 20px;
        }

        .menu-item a {
            text-decoration: none;
            color: inherit;
        }
        #wordcloud {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
/* CSS DE LA NUBE */
#wordcloud span {
    transition: transform 0.3s ease;
}

#wordcloud span:hover {
    transform: scale(1.1);
}
    </style>
</head>

<body>
    <div id="sidebar">
        <button class="menu-item active" id="toggle-sidebar"><i class="fas fa-bars"></i></button>
        <div class="user-panel">
            <div class="menu-item"> <i class="fas fa-user"></i><span></span></div>
            <span class="user-name"></span>
        </div>
        <div class="menu-item active"><a href="inicio.php"><i class="fas fa-home"></i><span>Inicio</span></a></div>
        <div class="menu-item"><a href="modelo.php"><i class="fas fa-chart-bar"></i><span>Model X</span></a></div>
        <div class="menu-item"><a href="reportes.php"><i class="fas fa-chart-pie"></i><span>Reporte</span></a></div>
        <div class="menu-item">
            <a href="cerrar_sesion.php"><i class="fas fa-sign-out-alt"></i><span>Cerrar Sesión</span></a>
        </div>
    </div>
    <div id="main-content">
        <div id="top-bar">
            <div class="top-bar-right">
                <h1 id="search-bar">Bienvenido <?php echo $usua_nombre; ?></h1>
            </div>
            <div class="top-bar-left">
                <div class="buscar">
                    <input id="busqueda" type="text" placeholder="Buscar" required>
                    <button id="buscar" class="button"><i class="fa fa-search"></i></button>
                </div>
                <input type="file" id="file-input" accept=".csv">
                <button onclick="subirCSV()" class="button"><i class="fas fa-upload"></i> Subir y Analizar CSV</button>
            </div>
        </div>
        <div class="dashboard-grid">
            <div class="dashboard-section">
                <h3>Conteo de Observaciones por Tema</h3>
                <div>
                    <canvas id="topicChart"></canvas>
                </div>
            </div>
            <div class="dashboard-section">
                <h3>Mira los reportes del último año</h3>
                <div class="report-content">
                    <div class="report-button">
                        <button class="button" style="height: 80px; font-size: 18px;"><i class="fas fa-file"></i>
                            Reportes 2023</button>
                    </div>
                    <div class="report-image">
                        <img src="img/reporte.jpg" alt="Imagen de reporte" width="400">
                    </div>
                </div>
            </div>
            <div class="dashboard-section">
                <h3>Valoracion de comentarios</h3>
                <div>
                    <canvas id="myChart"></canvas>
                </div>
            </div>
            <div class="dashboard-section">
                <h3>Áreas de Mayor aceptación</h3>
            </div>
            <div class="dashboard-section">
                <h3>Áreas de Menor aceptación</h3>
            </div>
            <div class="dashboard-section">
                <h3>Resultados del Análisis LDA</h3>
                <div id="chart"></div>
            </div>
            </div>
            <!-- CONTENEDOR DEL CONJUTNO DE PALABRAS -->
            <div class="dashboard-section">
    <h3>Temas con Mayores Observaciones</h3>
    <div id="wordcloud" style="width: 100%; height: 800px; text-align: center; overflow: hidden; background-color: transparent;"></div>
</div>

       
        <!-- Bootstrap core JavaScript -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="js/jquery.nice-select.min.js"></script>
        <script src="js/jquery.counterup.min.js"></script>
        <script src="js/jquery.meanmenu.min.js"></script>
        <script src="js/jquery.magnific-popup.min.js"></script>
        <script src="js/tilt.jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/slick.min.js"></script>
        <script src="js/waypoints.js"></script>
        <script src="js/inview.min.js"></script>
        <script src="js/wow.js"></script>
        <script src="js/custom.js"></script>

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Plotly.js -->
        <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

        <script>
            document.getElementById('search-bar').addEventListener('input', function(e) {
                console.log('Buscando: ' + e.target.value);
                // Aquí iría la lógica de búsqueda
            });

            document.getElementById('toggle-sidebar').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('collapsed');
                document.querySelectorAll('.menu-item span').forEach(function(el) {
                    el.style.display = el.style.display === 'none' ? '' : 'none';
                });
                document.querySelector('.user-name').style.display =
                    document.querySelector('.user-name').style.display === 'none' ? '' : 'none';
            });

            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });

            async function subirCSV() {
                const formData = new FormData();
                const fileInput = document.getElementById('file-input');
                formData.append('file', fileInput.files[0]);

                try {
                    const response = await fetch('http://localhost:8000/api/lda_results/', {
                        method: 'POST',
                        body: formData,
                        credentials: 'include',
                        headers: {
                            'X-CSRFToken': getCookie('csrftoken') // Asegúrate de que este token es correcto
                        }
                    });

                    if (!response.ok) {
                        console.error('Error en la respuesta del servidor');
                        return;
                    }

                    const data = await response.json();
                    console.log(data); // Verifica los datos recibidos en la consola

                    // Contar observaciones por tema
                    const topicCounts = {};
                    data.forEach(d => {
                        const topic = d.name_topic;
                        if (topic && topic.trim() !== "") { // Filtrar claves vacías
                            if (topicCounts[topic]) {
                                topicCounts[topic]++;
                            } else {
                                topicCounts[topic] = 1;
                            }
                        }
                    });

                    console.log(topicCounts);
                    console.log(window.Chart); // Verifica si Chart.js está definido en el ámbito global

                    // Preparar datos para el gráfico de barras con Chart.js
                    const topics = Object.keys(topicCounts);
                    const counts = Object.values(topicCounts);

                    const ctx = document.getElementById('topicChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: topics,
                            datasets: [{
                                label: 'Número de Observaciones',
                                data: counts,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0 // Asegura que los valores sean enteros
                                    }
                                }
                            }
                        }
                    });
                    // NUBE DE PALABRAS
                    // Crear la nube de palabras
                    const wordcloudContainer = document.getElementById('wordcloud');
                    wordcloudContainer.innerHTML = ''; // Limpiar el contenedor

                    // Encontrar el valor máximo en counts para normalizar los tamaños
                    const maxCount = Math.max(...counts);

                    // Crear un array de objetos con texto y valor para ordenar
                    let wordObjects = topics.map((topic, index) => ({
                        text: topic,
                        value: counts[index]
                    }));

                    // Ordenar las palabras por valor (frecuencia) de mayor a menor
                    wordObjects.sort((a, b) => b.value - a.value);

                    // Crear elementos para cada palabra
                    wordObjects.forEach((word) => {
                        const wordElement = document.createElement('span');
                        wordElement.textContent = word.text;

                        // Calcular el tamaño de la fuente basado en el conteo
                        // Ajusta los números 36 y 12 para cambiar el rango de tamaños
                        const fontSize = (word.value / maxCount) * 36 + 12;

                        wordElement.style.fontSize = `${fontSize}px`;
                        wordElement.style.padding = '5px';
                        wordElement.style.margin = '5px';
                        wordElement.style.display = 'inline-block';
                        wordElement.style.color = word.value > maxCount / 2 ? '#031634' : '#494e53';

                        // Añadir algo de rotación aleatoria
                        const rotation = Math.random() * 30 - 15; // Rotación entre -15 y 15 grados
                        wordElement.style.transform = `rotate(${rotation}deg)`;

                        wordcloudContainer.appendChild(wordElement);
                    });
                    // FIN DE LA NUBE DE PALABRAS

                    
                    // Preparar datos para el gráfico de pastel con Chart.js
                    const sentimentCounts = {
                        'Positivo': 0,
                        'Negativo': 0,
                        'Neutral': 0
                    };

                    data.forEach(d => {
                        const sentiment = d.SENTIMIENTO;
                        if (sentimentCounts[sentiment]) {
                            sentimentCounts[sentiment]++;
                        } else {
                            sentimentCounts[sentiment] = 1;
                        }
                    });

                    const sentiments = Object.keys(sentimentCounts);
                    const sentimentCountsValues = Object.values(sentimentCounts);

                    const pieCtx = document.getElementById('myChart').getContext('2d');
                    new Chart(pieCtx, {
                        type: 'pie',
                        data: {
                            labels: sentiments,
                            datasets: [{
                                label: 'Sentimientos',
                                data: sentimentCountsValues,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.7)', // Color para Positivo
                                    'rgba(54, 162, 235, 0.7)', // Color para Negativo
                                    'rgba(255, 206, 86, 0.7)' // Color para Neutral
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        generateLabels: function(chart) {
                                            const data = chart.data;
                                            if (data.labels.length && data.datasets.length) {
                                                return data.labels.map(function(label, i) {
                                                    const value = data.datasets[0].data[i];
                                                    const total = data.datasets[0].data.reduce((a, b) => a + b, 0);
                                                    const percentage = parseFloat((value / total * 100).toFixed(2));
                                                    return {
                                                        text: `${label}: ${percentage}%`,
                                                        fillStyle: data.datasets[0].backgroundColor[i],
                                                        strokeStyle: data.datasets[0].borderColor[i],
                                                        lineWidth: data.datasets[0].borderWidth,
                                                        hidden: isNaN(data.datasets[0].data[i]) || chart.getDatasetMeta(0).data[i].hidden,

                                                        // Extra properties used for toggling the correct item
                                                        index: i
                                                    };
                                                });
                                            }
                                            return [];
                                        }
                                    }
                                },
                                tooltip: {
                                    // enabled: false // Desactiva los tooltips para evitar duplicados
                                }
                            }
                        }
                    });

                    // Preparar datos para el gráfico de Plotly.js
                    const trace = {
                        x: topics,
                        y: counts,
                        type: 'bar'
                    };

                    const layout = {
                        title: 'Resultados del Análisis LDA',
                        xaxis: {
                            title: 'Temas'
                        },
                        yaxis: {
                            title: 'Puntuación (%)'
                        }
                    };

                    // Crear el gráfico con Plotly.js en el contenedor 'chart'
                    Plotly.newPlot('chart', [trace], layout);
                } catch (error) {
                    console.error('Error:', error);
                }
            }

            // Función para obtener el valor del token CSRF
            function getCookie(name) {
                let cookieValue = null;
                if (document.cookie && document.cookie !== '') {
                    const cookies = document.cookie.split(';');
                    for (let i = 0; i < cookies.length; i++) {
                        const cookie = cookies[i].trim();
                        if (cookie.substring(0, name.length + 1) === (name + '=')) {
                            cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                            break;
                        }
                    }
                }
                return cookieValue;
            }
        </script>

    </div>
</body>

</html>
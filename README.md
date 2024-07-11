# DataEncoders
En este espacio se sube el código creado para el grupo 

Se debe agregar toda la documentación que ustedes consideren pertinente para la compresión de los modelos usados, la ejecución del código y los resultados obtenidos. 
Puden, si desean, agregar imágenes o resultados obtenidos. 

Recuerden que este readme es su puerta de entrada para su proyecto. 

Un ejemplo puede ser: 
# Nombre del Proyecto

LDA solutions

## Tabla de contenidos

1. [Nombre](#Nombre)
Data Encoders fue el equipo de desarollo de esta solucion ignovadora en el procesado de texto.

3. [Descripción](#descripción)
Este es un proyecto  consiste en la creacion de un sistema el cual al ingregar un CSV con comentarios, el sistema hara un analisis de sentimiento y a cada setimiento se le realiza un proceso de clasificacion de tema mediante LDA. Todo seria controlado por un sitio web en el cual luego de procesar sus datos se generan unas graficas las cuales muestran informacion general del resultado.

4. [Arquitectura](#Arquitectura)
Se usa una arquitectura de cliente servidor donde todo esta sucediendo de manera local, por lo tanto la velocidad del resultado dependera del hardware que tenga la maquina ejecuta el sistema. La siguiente imagen muestra como se veria nuestra arquitectura de manera visual.

![image](https://github.com/user-attachments/assets/8e7c42d5-455f-45bd-ad36-3d657248c3c5)


6. [Proceso](#Proceso)
   
  -Fuente del datos:
   Los datos nos fueron proporcionados por la Universidad Tecnologia de Panamá, especificamente del departamento de estadistica el cual maneja los datos de los comentarios que tenemos los estudiantes al final del segundo semestre.
   
   -Limpieza de datos: 
   La limpieza de datos se realizo con el objetivo de quitar la mayor cantidad de ruido posible ya que habia muchos comentarios que no tenian relevancia, podemos ver en la imagen como pasamos de tener 52mil datos a solo tener 18mil
   ![image](https://github.com/user-attachments/assets/50efd0c1-88f7-41a1-abda-ae5ff46516ae)

   -Manejo excepciones/control errores: 
   Al utilizar Django se nos hizo casi de manera obligatoria el realizar tener un control de errores tanto en la parte del modelado como en el sitio web.

   -Modelo de Machine Learning usado:
   Utilizamos diferentes modelos de Machine Learning para el proceso de analisis de sentimiento y la clasificacion de texto.

  Analisis de setimiento
  
         from sentiment_analysis_spanish import sentiment_analysis
  LDA
  
         import gensim

   -Estadísticos: Se realizaron diferentes graficas que se le muestra al usuario el el portal web

8. [Funcionalidades](#Funcionalidades)
Tiene como funcionalida el poder mostrar las graficar y el clasificar los comentarios de las personas en temas importante, asignado un peso a cada palabra.

9. [Estado del proyecto](#EstadoDelProyecto)
El proyecto en si funciona de manera local genera los archivos de solucion, muestra las la información al user en el sitio web y predice de buena menera los temas de cada comentario. Lastimosamente no nos funciono el crear una imagen de docker y que asi corriera en cualquie dispositivo, nos hacen falta algunas graficas que teniamos planeada y que el user pueda mantener el registro de todo lo que has hecho.

11. [Agradecimientos](#Agradecimientos)
Quiero agradecer a mi equipo por haberme seguido en esta idea tan ambiciosa, a mis proferes tanto del curso de SIC como mi profesora de Gestion de la información que tambien me alento a seguir.


* Funcionalidades extra:

Integración del proyecto en una pág web
- Tecnología/Herramientas usadas tanto Apache, mySQL, Django
- Arquitectura
- ![WhatsApp Image 2024-07-11 at 17 34 25_e5167c5a](https://github.com/user-attachments/assets/6a97c849-abf8-409f-ac8b-a92ddad45948)




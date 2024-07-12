# DataEncoders

Este repositorio contiene el código creado por el grupo DataEncoders.

## Nombre del Proyecto

LDA Solutions

## Tabla de contenidos

1. [Descripción](#descripción)
2. [Arquitectura](#arquitectura)
3. [Proceso](#proceso)
4. [Funcionalidades](#funcionalidades)
5. [Estado del proyecto](#estado-del-proyecto)
6. [Agradecimientos](#agradecimientos)
7. [Funcionalidades extra](#funcionalidades-extra)

## Descripción

Este proyecto consiste en la creación de un sistema que permite el análisis de sentimiento y la clasificación de temas mediante LDA a partir de comentarios almacenados en un CSV. Los resultados se presentan mediante gráficas generadas en un sitio web.

## Arquitectura

La arquitectura del proyecto se basa en un modelo cliente-servidor ejecutándose localmente en el sistema del usuario. Esto permite un procesamiento rápido y eficiente de los datos, dependiendo directamente del hardware disponible para ejecutar el sistema. La separación de responsabilidades entre el cliente (navegador web) y el servidor (aplicación Django y base de datos MySQL) asegura una experiencia de usuario fluida y receptiva. La siguiente imagen muestra visualmente nuestra arquitectura de manera muy sencilla:

![Arquitectura](https://github.com/user-attachments/assets/8e7c42d5-455f-45bd-ad36-3d657248c3c5)

## Proceso

- **Fuente de los datos**: Los datos fueron proporcionados por la Universidad Tecnológica de Panamá, específicamente del departamento de estadística, que contiene comentarios de estudiantes al final del segundo semestre.

- **Limpieza de datos**: Se realizó una limpieza para eliminar ruido, reduciendo los datos de 52,000 a 18,000 registros como se muestra en la siguiente imagen:

  ![Limpieza de datos](https://github.com/user-attachments/assets/50efd0c1-88f7-41a1-abda-ae5ff46516ae)

- **Manejo de excepciones/control de errores**: El manejo de excepciones y el control de errores son aspectos críticos en el desarrollo de cualquier aplicación robusta y fiable. En nuestro proyecto, hemos implementado estas prácticas utilizando Django, lo que nos permite detectar, gestionar y solucionar errores de manera efectiva.

  Django proporciona una estructura sólida para el manejo de errores a través de su middleware y sus vistas personalizadas de errores. Hemos configurado nuestro proyecto para capturar y registrar cualquier excepción que ocurra durante el procesamiento de datos o la interacción del usuario con el sitio web. Esto incluye:

  - **Validación de Entradas**: Antes de procesar cualquier archivo CSV cargado por los usuarios, el sistema valida el formato y la integridad de los datos para prevenir fallos durante el análisis.

  - **Manejo de Excepciones en el Backend**: Utilizamos bloques try-except para capturar y manejar excepciones específicas en el código de backend, asegurando que cualquier error sea gestionado de manera adecuada y no provoque la interrupción del servicio.

  - **Mensajes de Error Amigables**: En caso de error, el sistema proporciona mensajes de error claros y útiles a los usuarios, guiándolos sobre cómo corregir el problema o proporcionar datos válidos.

  Estas prácticas nos permiten mantener un alto nivel de robustez y confiabilidad en nuestro sistema, garantizando una experiencia de usuario satisfactoria y sin interrupciones.

- **Modelo de Machine Learning utilizado**: Se emplearon varios modelos para análisis de sentimiento y clasificación de texto.

  - **Análisis de sentimiento**:
    Utilizamos la biblioteca `sentiment_analysis_spanish`, que nos proporciona una herramienta eficaz para determinar el sentimiento (positivo, negativo o neutral) de cada comentario. Este modelo ha sido entrenado específicamente para manejar texto en español, lo que mejora significativamente la precisión de nuestros resultados.
    ```python
    from sentiment_analysis_spanish import sentiment_analysis
    sentiment = sentiment_analysis.SentimentAnalysisSpanish()
    resultado_sentimiento = sentiment.sentiment(texto_comentario)
    ```

  - **LDA**:
    Para la clasificación de temas, hemos implementado el modelo LDA utilizando la biblioteca `gensim`. Este modelo nos permite identificar los temas predominantes en los comentarios al analizar las co-ocurrencias de palabras y asignar cada comentario a uno o más temas relevantes.
    ```python
    import gensim
    from gensim import corpora
    dictionary = corpora.Dictionary(texts_procesados)
    corpus = [dictionary.doc2bow(texto) para texto en texts_procesados]
    lda_model = gensim.models.LdaModel(corpus, num_topics=num_temas, id2word=dictionary, passes=10)
    ```
    Estos modelos nos han permitido no solo analizar el sentimiento general de los comentarios, sino también descomponerlos en temas específicos, proporcionando una visión más detallada y útil de los datos. La combinación de estos modelos nos ayuda a ofrecer a los usuarios información valiosa y procesable sobre sus comentarios, presentada de manera clara y comprensible a través de nuestro sitio web.

- **Estadísticas**: La generación de estadísticas es una parte fundamental de nuestro proyecto, ya que permite visualizar y comprender de manera clara y efectiva los resultados del análisis de sentimientos y la clasificación de temas. Hemos desarrollado diversas gráficas y representaciones visuales que facilitan la interpretación de los datos procesados. A continuación, se detallan algunos de los enfoques y herramientas utilizados:
  - **Gráficas de Sentimiento**: Hemos implementado gráficos de barras y de torta para mostrar la distribución de los sentimientos (positivo, negativo, neutral) en los comentarios analizados. Estas visualizaciones permiten a los usuarios identificar rápidamente la proporción de cada tipo de sentimiento presente en sus datos.
  - **Distribución de Temas**: Utilizamos gráficos de barras y nubes de palabras para representar la frecuencia y relevancia de los temas identificados por el modelo LDA. Estas visualizaciones muestran qué temas son más prevalentes en los comentarios y las palabras clave asociadas a cada tema.
  
  ![WhatsApp Image 2024-07-11 at 19 19 38_77957562](https://github.com/user-attachments/assets/58aeb8b3-da3f-4a03-b934-89f089a25d8c)
  ![WhatsApp Image 2024-07-11 at 19 19 38_a2cbdc2a](https://github.com/user-attachments/assets/e4476397-2cfe-40cf-80ca-d1c6550f2687)
  ![image](https://github.com/user-attachments/assets/17022ca2-d6ef-4df6-afb9-ece71dc35f82)

## Funcionalidades

El sistema permite visualizar gráficas en la web usando localhost y clasificar comentarios en temas importantes. Además de las funcionalidades principales mencionadas, el sistema incluye capacidades adicionales como la asignación de pesos a palabras clave en los comentarios, facilitando una comprensión más profunda de los temas discutidos en los datos analizados. Esta característica permite a los usuarios identificar rápidamente los puntos clave dentro de los comentarios y realizar análisis más detallados según sus necesidades específicas.

![funcionamiento](https://github.com/user-attachments/assets/25a6dfa4-7a4e-416e-b406-c6e9aa3ef3a1)

## Estado del proyecto

Aunque el proyecto funciona de manera satisfactoria localmente, enfrentamos desafíos significativos al intentar contener la aplicación en una imagen de Docker para lograr portabilidad entre diferentes entornos de ejecución. Además, algunas funcionalidades planificadas, como ciertas visualizaciones gráficas avanzadas, aún no se han implementado completamente debido a limitaciones de tiempo y recursos.

![image](https://github.com/user-attachments/assets/ee680024-d7b7-4f4c-873a-0f0fa661b25f)

Más adelante en la noche se subirá un video a YouTube donde se mostrará cómo configurar todo y así poder correr el código. :3

## Agradecimientos

Quiero expresar mi más profundo agradecimiento a todas las personas y recursos que hicieron posible la realización de este proyecto. En primer lugar, gracias a mi equipo de trabajo por su dedicación, esfuerzo y compromiso para llevar adelante esta ambiciosa idea. Su colaboración y creatividad fueron fundamentales para superar los numerosos desafíos que enfrentamos.

También quiero extender mi gratitud a mis profesores del curso de SIC y de Gestión de la Información. Sus enseñanzas, consejos y motivación fueron esenciales para avanzar en este proyecto. Su apoyo continuo me impulsó a superar obstáculos y a seguir mejorando.

No puedo olvidar a los contribuyentes anónimos y desconocidos de plataformas como Stack Overflow y Medium. Los innumerables fragmentos de código, tutoriales y respuestas a preguntas específicas que encontré en estas plataformas fueron invaluables. A menudo, estas contribuciones no son reconocidas adecuadamente, pero su impacto en el desarrollo de proyectos como el nuestro es enorme. Gracias a todos esos desarrolladores y escritores que comparten su conocimiento desinteresadamente.

Finalmente, gracias a la Universidad Tecnológica de Panamá y al departamento de estadística por proporcionar los datos necesarios para este proyecto. Su colaboración fue crucial para el desarrollo y la implementación de nuestro sistema de análisis de sentimientos y clasificación de temas.

## Funcionalidades extra

- **Integración del proyecto en una página web**.
- **Tecnologías/Herramientas usadas**:
  - **Apache**: Utilizado como servidor web para alojar y gestionar el sitio desarrollado en Django, asegurando una entrega rápida y segura de contenido web.
  - **MySQL**: Base de datos relacional utilizada para almacenar y gestionar los datos de comentarios y resultados de análisis, garantizando una gestión eficiente y escalable de la información.
  - **Django**: Framework de desarrollo web de alto nivel que facilita la creación de aplicaciones web complejas y potentes, integrando de manera fluida el backend y el frontend del sistema.
  
- **Arquitectura**:

  ![WhatsApp Image 2024-07-11 at 19 55 10_5908f2a4](https://github.com/user-attachments/assets/f84c7eba-fabf-4c50-a4ce-b6959de280be)

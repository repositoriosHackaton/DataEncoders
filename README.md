# DataEncoders

Este repositorio contiene el código creado por el grupo DataEncoders.

## Nombre del Proyecto

LDA Solutions

## Tabla de contenidos

1. [Descripción](#descripción)
2. [Arquitectura](#Arquitectura)
3. [Proceso](#Proceso)
4. [Funcionalidades](#Funcionalidades)
5. [Estado del proyecto](#EstadoDelProyecto)
6. [Agradecimientos](#Agradecimientos)
7. [Funcionalidades extra](#Funcionalidades-extra)

## Descripción

Este proyecto consiste en la creación de un sistema que permite el análisis de sentimiento y la clasificación de temas mediante LDA a partir de comentarios almacenados en un CSV. Los resultados se presentan mediante gráficas generadas en un sitio web.

## Arquitectura

La arquitectura del proyecto se basa en un modelo cliente-servidor ejecutándose localmente en el sistema del usuario. Esto permite un procesamiento rápido y eficiente de los datos, dependiendo directamente del hardware disponible para ejecutar el sistema. La separación de responsabilidades entre el cliente (navegador web) y el servidor (aplicación Django y base de datos MySQL) asegura una experiencia de usuario fluida y receptiva. La siguiente imagen muestra visualmente nuestra arquitectura de manera muy sensilla:

![Arquitectura](https://github.com/user-attachments/assets/8e7c42d5-455f-45bd-ad36-3d657248c3c5)

## Proceso

- **Fuente de los datos**: Los datos fueron proporcionados por la Universidad Tecnológica de Panamá, específicamente del departamento de estadística, que contiene comentarios de estudiantes al final del segundo semestre.

- **Limpieza de datos**: Se realizó una limpieza para eliminar ruido, reduciendo los datos de 52,000 a 18,000 registros como se muestra en la siguiente imagen:

  ![Limpieza de datos](https://github.com/user-attachments/assets/50efd0c1-88f7-41a1-abda-ae5ff46516ae)

- **Manejo de excepciones/control de errores**: Implementado en Django para asegurar robustez en el modelado y en el sitio web.

- **Modelo de Machine Learning utilizado**: Se emplearon varios modelos para análisis de sentimiento y clasificación de texto.

  - Análisis de sentimiento:
    ```python
    from sentiment_analysis_spanish import sentiment_analysis
    ```

  - LDA:
    ```python
    import gensim
    ```

- **Estadísticas**: Se generaron varias gráficas para mostrar información relevante al usuario en el portal web.

## Funcionalidades

El sistema permite visualizar gráficas en la web usando localhost y clasificar comentarios en temas importantes. Además de las funcionalidades principales mencionadas, el sistema incluye capacidades adicionales como la asignación de pesos a palabras clave en los comentarios, facilitando una comprensión más profunda de los temas discutidos en los datos analizados. Esta característica permite a los usuarios identificar rápidamente los puntos clave dentro de los comentarios y realizar análisis más detallados según sus necesidades específicas.


## Estado del proyecto

Aunque el proyecto funciona de manera satisfactoria localmente, enfrentamos desafíos significativos al intentar contener la aplicación en una imagen de Docker para lograr portabilidad entre diferentes entornos de ejecución. Además, algunas funcionalidades planificadas, como ciertas visualizaciones gráficas avanzadas, aún no se han implementado completamente debido a limitaciones de tiempo y recursos.

Mas adelante en la noche se subira una video a youtube donde muestre como configurar todo y asi poder correr el codigo 

## Agradecimientos

Agradezco a mi equipo por el compromiso con el proyecto siempre dando la milla extra, así como a mis profesores del curso de SIC y de Gestión de la Información por su aliento, consejos y guia. 

## Funcionalidades extra

- Integración del proyecto en una página web.
- Tecnologías/Herramientas usadas: Para asegurar un funcionamiento robusto y eficiente del sistema, hemos implementado varias tecnologías clave:

Apache: Utilizado como servidor web para alojar y gestionar el sitio desarrollado en Django, asegurando una entrega rápida y segura de contenido web.

MySQL: Base de datos relacional utilizada para almacenar y gestionar los datos de comentarios y resultados de análisis, garantizando una gestión eficiente y escalable de la información.

Django: Framework de desarrollo web de alto nivel que facilita la creación de aplicaciones web complejas y potentes, integrando de manera fluida el backend y el frontend del sistema.
- Arquitectura:

  ![Arquitectura](https://github.com/user-attachments/assets/6a97c849-abf8-409f-ac8b-a92ddad45948)

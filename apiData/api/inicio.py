import pandas as pd
import time
import csv
import json
import os
from apiData.api.procesamiento import cargar_data, quitar_columnas, elegir_columna, limpiar_tokenizar, eliminar_vacios
from apiData.api.analisisSentimiento import analizar_sentimiento, promediar_sentimiento
from apiData.api.LDA import lemmatize_text, creacion_LDA, mostrar_temas, predict_topic
from apiData.api.guardar_archivos import pasar_json, guardar_csv



# funcion que escribe un mensaje en el archivo logs.txt
def logs(mensaje):
    # comprueba si el archivo logs.txt existe, si no existe lo crea
    try:
        with open("logs.txt", "r") as file:
            pass
    except:
        with open("logs.txt", "w") as file:
            pass

    # escribe el mensaje en el archivo logs.txt
    fecha = time.strftime("%Y-%m-%d %H:%M:%S") # a str
    with open("logs.txt", "a") as file:
        file.write(fecha + mensaje + "\n")

# aqui legara si el cliente quiero solo negativo o positivos o ambos
def inicio(data, columna, cluster=False):
    if (data == None or data == "" or columna == None or columna == ""):
        
        return "No se ha ingresado ningun dato"
    
    datos = cargar_data(data)
    if isinstance(datos, str):
        print(datos)
        return
    
    # Continuar con el procesamiento del DataFrame `data`
    print(datos.head())  # Ejemplo de procesamiento del DataFrame
    
    # si el cluster es falso 
    # if (cluster == False):


    if (type(cluster) != int or type(columna) != int):
        try:
            cluster = int(cluster)
            columna = int(columna)
        except:
            return "El dato en cluster no es un numero"
        
    # si cluster es un numero menor a 1 devolver mensaje de error
    if (cluster < 3):
        return "El cluster debe ser mayor a 2"
    
    # si cluster es mayor a la cantidad de datos devolver mensaje de error
    # df = pd.read_csv(data)
    if (cluster > len(datos)):
        return "El cluster debe ser menor a la cantidad de datos"
    
    # eliminamos las rows con valores nulos
    datos.dropna(inplace=True)

    # verificamos si la columna a trabajar existe
    if len(datos.columns) < columna:
        return "La columna no existe"
    
    # elegimos la columna a trabajar
    columna_trabajar = elegir_columna(datos, columna)

    # quitamos columnas con pocos subniveles
    datos = quitar_columnas(datos)
    print(datos.head())  # Ejemplo de procesamiento del DataFrame
    # print(type(columna_trabajar))

    # Convertir la Serie a un DataFrame
    columna_trabajar = columna_trabajar.to_frame()
    print(columna_trabajar.head())

    columna_trabajar['TEXTO_TOKEN'] = columna_trabajar.iloc[:, 0].fillna('').astype(str).apply(limpiar_tokenizar)
    print(columna_trabajar.head())
    
    # quito las rows con menos de 3 tokens
    columna_trabajar = eliminar_vacios(columna_trabajar)
    logs(" - Eliminar rows con min tokens")
    # print(columna_trabajar.head())

    # lematizo los tokens
    columna_trabajar['LEMMA'] = columna_trabajar['TEXTO_TOKEN'].apply(lemmatize_text)
    print(columna_trabajar.head())
    logs(" - Lematizacion")

    # Analizar sentimientos
    columna_trabajar['SENTIMIENTO'] = analizar_sentimiento(columna_trabajar['LEMMA'])
    logs(" - Analisis de sentimiento")
    promedio_sentimiento = promediar_sentimiento(columna_trabajar)
    logs(" - Promedio de analisis de sentimiento")
    print(promedio_sentimiento)

    # Separar segun el sentimiento
    df_positivos  = pd.DataFrame()
    df_neutral = pd.DataFrame()
    df_negativos = pd.DataFrame()

    df_positivos = columna_trabajar[columna_trabajar['SENTIMIENTO'] == 'Positivo'] 
    df_neutral = columna_trabajar[columna_trabajar['SENTIMIENTO'] == 'Neutral'] 
    df_negativos = columna_trabajar[columna_trabajar['SENTIMIENTO'] == 'Negativo' ] 
    print("-------------POSITIVOS----------------------")
    print(df_positivos.head())
    print("-------------NEUTRALES----------------------")
    print(df_neutral.head())
    print("-------------NEGATIVOS----------------------")
    print(df_negativos.head())

    logs(" - Creacion de 3 DataFrames")
    # creacion del modelo LDA 
    diccionario_pos, lda_model_pos = creacion_LDA(df_positivos, cluster) # Df con sentimiento  positivo
    diccionario_neu, lda_model_neu = creacion_LDA(df_negativos, cluster) # Df con sentimiento  neutral
    diccionario_neg, lda_model_neg = creacion_LDA(df_neutral, cluster) # Df con sentimiento negativo


    # obtengo los temas con mas caloracion de cada cluster 
    temas_pos = mostrar_temas(lda_model_pos) # Df positivo
    print(temas_pos)
    temas_neu = mostrar_temas(lda_model_neu) # Df neutral
    print(temas_neu)
    temas_neg = mostrar_temas(lda_model_neg) # Df negativo
    print(temas_neg)
    
    

    # unimos la columnas TEXTO_TOKEN y LEMMA al DataFrame de cada sentimiento
    datos_pos = pd.concat([datos, df_positivos], axis=1) # Data y df positivo
    datos_neu = pd.concat([datos, df_neutral], axis=1) # Data y df neutral
    datos_neg = pd.concat([datos, df_negativos], axis=1) # Data y df negativo


    # dropea la columna TEXTO_TOKEN que sean null
    datos_pos = datos_pos.dropna(subset=['TEXTO_TOKEN'])
    datos_neu = datos_neu.dropna(subset=['TEXTO_TOKEN'])
    datos_neg = datos_neg.dropna(subset=['TEXTO_TOKEN'])

    # datos_pos = df_positivos

    # cluster asignado a cada fila
    print("-------------POSITIVOS----------------------")
    print(len(datos_pos))
    print("----------------------")
    datos_final_pos = predict_topic(datos_pos, diccionario_pos, lda_model_pos, temas_pos) # Positivos
    # datos_final_pos['Sentimiento'] = 'Positivo' # Agregar columna de categoría
    print("-------------NEUTRALES----------------------")
    print(len(datos_neu))
    print("----------------------")
    datos_final_neu = predict_topic(datos_neu, diccionario_neu, lda_model_neu, temas_neu) # Neutrales
    # datos_final_neu['Sentimiento'] = 'Neutro'  # Agregar columna de categoría
    print("-------------NEGATIVOS----------------------")
    print(len(datos_neg))
    print("----------------------")
    datos_final_neg = predict_topic(datos_neg, diccionario_neg, lda_model_neg, temas_neg) # Negativos
    # datos_final_neg['Sentimiento'] = 'Negativo'  # Agregar columna de categoría

    # guarda el DataFrame en un archivo CSV
    ruta_positiva = "datos_procesados_positivos_1.csv"
    ruta_neutral = "datos_procesados_neutrales_1.csv"
    ruta_negativa = "datos_procesados_negativos_1.csv"
    
    # Datos procesados en formato CSV
    guardar_csv(datos_final_pos, ruta_positiva) 
    guardar_csv(datos_final_neu, ruta_neutral)
    guardar_csv(datos_final_neg, ruta_negativa)
    
    # Datos procesados en formato JSON
    pasar_json(ruta_positiva)
    pasar_json(ruta_neutral)
    pasar_json(ruta_negativa)

    # Combina los DataFrames en uno solo para devolverlo
    combined_df = pd.concat([datos_final_pos, datos_final_neu, datos_final_neg])
    print(combined_df.sample(10))

    return combined_df

if __name__ == "__main__":
    T_inicio = time.time()
    print(time.strftime("%Y-%m-%d %H:%M:%S") + " - Inicio del programa")
    cosa = inicio("Opiniones.csv", 4, 8)
    print(cosa)
    print(time.strftime("%Y-%m-%d %H:%M:%S") + " - Fin del programa")
    print("Tiempo de ejecución:", time.time() - T_inicio)
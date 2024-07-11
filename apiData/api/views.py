# apiData/api/views.py
from django.http import JsonResponse
from django.views import View
from django.views.decorators.csrf import csrf_exempt
from .inicio import inicio
import pandas as pd
import json

class FileUploadView(View):
    @csrf_exempt
    def post(self, request, *args, **kwargs):
        if request.method == 'POST' and request.FILES.get('file'):
            file = request.FILES['file']
            
            with open('temp_file.csv', 'wb+') as destination:
                for chunk in file.chunks():
                    destination.write(chunk)
            
            datos_final = inicio('temp_file.csv', 4, 8)
            
            if not isinstance(datos_final, pd.DataFrame):
                return JsonResponse({'error': 'Processing failed'}, status=500)
            
            data = datos_final[['TOPIC', 'name_topic', 'SCORE']].to_dict('records')
            
            return JsonResponse(data, safe=False)
        
        return JsonResponse({'error': 'Invalid request'}, status=400)
# ARREGLAR ESTE ES EL ERROR   
# class 

@csrf_exempt

def lda_results(request):
    if request.method == 'POST' and request.FILES.get('file'):
        file = request.FILES['file']
        
        try:
            with open('temp_file.csv', 'wb+') as destination:
                for chunk in file.chunks():
                    destination.write(chunk)
            print("File saved successfully.")
        except Exception as e:
            print(f"Error saving file: {str(e)}")
            return JsonResponse({'error': f'Error saving file: {str(e)}'}, status=500)
        
        try:
            datos_final = inicio('temp_file.csv', 4, 8)
            print("File processed successfully.")
        except Exception as e:
            print(f"Error processing file: {str(e)}")
            return JsonResponse({'error': f'Error processing file: {str(e)}'}, status=500)
        
        if not isinstance(datos_final, pd.DataFrame):
            print("Processing failed: Result is not a DataFrame.")
            return JsonResponse({'error': 'Processing failed'}, status=500)
        
        try:
            # Agregar la columna de Sentimiento si no existe
            if 'SENTIMIENTO' not in datos_final.columns:
                datos_final['SENTIMIENTO'] = ''
            
            data = datos_final[['TOPIC', 'name_topic', 'SCORE', 'SENTIMIENTO']].to_dict('records')
            # imprime solo las primera 5 elementos de la lista data
            print(data[:5])
            print("Data converted successfully.")
        except Exception as e:
            print(f"Error converting data: {str(e)}")
            return JsonResponse({'error': f'Error converting data: {str(e)}'}, status=500)
        
        return JsonResponse(data, safe=False)
    
    print("Invalid request.")
    return JsonResponse({'error': 'Invalid request'}, status=400)

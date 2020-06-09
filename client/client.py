import xlrd
import requests
import os.path
from time import sleep

web_location  = 'https://Path_to_server';
web_passcode  = 'Your_code';
delay_time=0.2 
file_location = input('enter file location \n');

if os.path.exists(file_location):
	rb = xlrd.open_workbook(file_location)
	sheet = rb.sheet_by_index(0)
	for rownum in range(sheet.nrows):
		row = sheet.row_values(rownum)
		requests.post(web_location, data={'text': str(row[1])+" "+str(row[2]), 'pass':web_passcode })
		print (str(row[1])+" "+str(row[2]))
		sleep(delay_time)
else:
	print ('file not found')
